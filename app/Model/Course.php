<?php

namespace App\Model;

use PDO;
use App\Database;

class Course
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("
            SELECT *, 
                   code as course_code,
                   name as course_name
            FROM courses 
            ORDER BY code
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT *, 
                   code as course_code,
                   name as course_name
            FROM courses 
            WHERE id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getEnrolledCourses($studentId)
    {
        $stmt = $this->db->prepare("
            SELECT c.*, 
                   e.grade, 
                   e.id as enrollment_id,
                   c.code as course_code,
                   c.name as course_name
            FROM courses c
            JOIN enrollments e ON c.id = e.course_id
            WHERE e.student_id = ?
            ORDER BY c.code
        ");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudentSchedule($studentId)
    {
        $stmt = $this->db->prepare("
            SELECT c.*, 
                   e.id as enrollment_id,
                   c.code as course_code,
                   c.name as course_name
            FROM courses c
            JOIN enrollments e ON c.id = e.course_id
            WHERE e.student_id = ?
            ORDER BY c.schedule_days, c.schedule_time
        ");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO courses (code, name, description, credits, instructor_name, schedule_days, schedule_time, room)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['code'],
            $data['name'],
            $data['description'],
            $data['credits'],
            $data['instructor_name'],
            $data['schedule_days'],
            $data['schedule_time'],
            $data['room']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE courses 
            SET code = ?, 
                name = ?, 
                description = ?, 
                credits = ?, 
                instructor_name = ?, 
                schedule_days = ?, 
                schedule_time = ?, 
                room = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['code'],
            $data['name'],
            $data['description'],
            $data['credits'],
            $data['instructor_name'],
            $data['schedule_days'],
            $data['schedule_time'],
            $data['room'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM courses WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function isEnrolled($studentId, $courseId)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM enrollments 
            WHERE student_id = ? AND course_id = ?
        ");
        $stmt->execute([$studentId, $courseId]);
        return $stmt->fetchColumn() > 0;
    }

    public function enroll($studentId, $courseId)
    {
        if ($this->isEnrolled($studentId, $courseId)) {
            return false;
        }

        $stmt = $this->db->prepare("
            INSERT INTO enrollments (student_id, course_id)
            VALUES (?, ?)
        ");
        return $stmt->execute([$studentId, $courseId]);
    }

    public function drop($studentId, $courseId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM enrollments 
            WHERE student_id = ? AND course_id = ?
        ");
        return $stmt->execute([$studentId, $courseId]);
    }

    public function getTotalCount()
    {
        $sql = "SELECT COUNT(*) as count FROM courses";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['count'];
    }

    public function getCoursesByCategory($category)
    {
        $sql = "SELECT * FROM courses WHERE category = :category ORDER BY code";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['category' => $category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchCourses($query) {
        try {
            if (empty($query)) {
                return $this->getAll();
            }

            $searchTerm = "%{$query}%";
            $sql = "SELECT * FROM courses 
                    WHERE code LIKE :query 
                    OR name LIKE :query 
                    OR description LIKE :query 
                    OR category LIKE :query 
                    OR instructor_name LIKE :query 
                    ORDER BY code";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['query' => $searchTerm]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            throw new \Exception('Error searching courses');
        }
    }

    public function getAvailableSeats($courseId) {
        try {
            if (!is_numeric($courseId) || $courseId <= 0) {
                throw new \Exception('Invalid course ID');
            }

            $sql = "SELECT max_students FROM courses WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $courseId]);
            $course = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$course) {
                throw new \Exception('Course not found');
            }

            $sql = "SELECT COUNT(*) as count FROM enrollments WHERE course_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $courseId]);
            $enrolled = $stmt->fetch(PDO::FETCH_ASSOC);

            return $course['max_students'] - $enrolled['count'];
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            throw new \Exception('Error getting available seats');
        }
    }

    public function getEnrolledStudents($courseId) {
        try {
            if (!is_numeric($courseId) || $courseId <= 0) {
                throw new \Exception('Invalid course ID');
            }

            $sql = "SELECT u.* FROM users u 
                    JOIN enrollments e ON u.id = e.user_id 
                    WHERE e.course_id = :id 
                    ORDER BY u.name";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $courseId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            throw new \Exception('Error getting enrolled students');
        }
    }
} 