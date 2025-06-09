<?php

namespace App\Model;

use PDO;
use App\Database\Database;

class Enrollment
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data)
    {
        $sql = "INSERT INTO enrollments (student_id, course_id, enrollment_date) 
                VALUES (:student_id, :course_id, CURDATE())";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'student_id' => $data['student_id'],
            'course_id' => $data['course_id']
        ]);
    }

    public function getStudentGrades($studentId)
    {
        $sql = "SELECT e.*, c.code as course_code, c.name as course_name, c.credits 
                FROM enrollments e 
                JOIN courses c ON e.course_id = c.id 
                WHERE e.student_id = :student_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['student_id' => (int)$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateGrade($studentId, $courseId, $grade)
    {
        $sql = "UPDATE enrollments SET grade = :grade 
                WHERE student_id = :student_id AND course_id = :course_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'grade' => (float)$grade,
            'student_id' => (int)$studentId,
            'course_id' => (int)$courseId
        ]);
        return $stmt->rowCount() > 0;
    }

    public function getRecentEnrollments($limit = 5)
    {
        $sql = "SELECT e.*, 
                       c.name as course_name, 
                       CONCAT(s.first_name, ' ', s.last_name) as student_name,
                       e.enrollment_date
                FROM enrollments e 
                JOIN courses c ON e.course_id = c.id 
                JOIN students s ON e.student_id = s.id 
                ORDER BY e.enrollment_date DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isEnrolled($studentId, $courseId)
    {
        $sql = "SELECT COUNT(*) as count 
                FROM enrollments 
                WHERE student_id = :student_id 
                AND course_id = :course_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'student_id' => $studentId,
            'course_id' => $courseId
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;
    }

    public function getEnrollmentCount($courseId)
    {
        $sql = "SELECT COUNT(*) as count 
                FROM enrollments 
                WHERE course_id = :course_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['course_id' => $courseId]);
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function deleteEnrollment($studentId, $courseId)
    {
        $sql = "DELETE FROM enrollments 
                WHERE student_id = :student_id 
                AND course_id = :course_id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'student_id' => $studentId,
            'course_id' => $courseId
        ]);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM enrollments 
            WHERE id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllEnrollments()
    {
        $sql = "SELECT e.*, c.code as course_code, c.name as course_name, c.credits,
                       s.first_name, s.last_name, s.id as student_id,
                       CONCAT(s.first_name, ' ', s.last_name) as student_name,
                       c.id as course_id
                FROM enrollments e 
                JOIN courses c ON e.course_id = c.id 
                JOIN students s ON e.student_id = s.id
                ORDER BY s.last_name, s.first_name, c.code";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function enroll($studentId, $courseId)
    {
        // Check if already enrolled
        $sql = "SELECT id FROM enrollments 
                WHERE student_id = :student_id AND course_id = :course_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'student_id' => (int)$studentId,
            'course_id' => (int)$courseId
        ]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($existing) {
            return false;
        }

        $sql = "INSERT INTO enrollments (student_id, course_id) 
                VALUES (:student_id, :course_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'student_id' => (int)$studentId,
            'course_id' => (int)$courseId
        ]);
        return $stmt->rowCount() > 0;
    }

    public function drop($studentId, $courseId)
    {
        $sql = "DELETE FROM enrollments 
                WHERE student_id = :student_id AND course_id = :course_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'student_id' => (int)$studentId,
            'course_id' => (int)$courseId
        ]);
        return $stmt->rowCount() > 0;
    }
} 