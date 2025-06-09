<?php

namespace App\Model;

use App\Database\Database;
use PDO;

class Course extends BaseModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        try {
            $stmt = $this->db->query("
                SELECT *,
                       code as code,
                       name as name,
                       instructor_name as instructor_name,
                       schedule_days as schedule_days,
                       schedule_time as schedule_time,
                       room as room
                FROM courses 
                ORDER BY schedule_time, code
            ");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("getAll() results: " . print_r($results, true));
            return $results;
        } catch (\PDOException $e) {
            error_log("Error in getAll(): " . $e->getMessage());
            return [];
        }
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
                   c.code as code,
                   c.name as name
            FROM courses c
            JOIN enrollments e ON c.id = e.course_id
            WHERE e.student_id = ?
            ORDER BY c.schedule_time, c.schedule_days
        ");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO courses (code, name, description, credits, category, instructor_name, schedule_days, schedule_time, room)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['code'],
            $data['name'],
            $data['description'],
            $data['credits'],
            $data['category'],
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

    public function insertSampleCourses() {
        $sampleCourses = [
            [
                'code' => 'CS101',
                'name' => 'Introduction to Programming',
                'description' => 'Basic programming concepts using Python',
                'credits' => 3,
                'category' => 'Computer Science',
                'instructor_name' => 'Dr. Smith',
                'schedule_days' => 'Monday,Wednesday',
                'schedule_time' => '8:00-10:00',
                'room' => 'Room 101'
            ],
            [
                'code' => 'MATH201',
                'name' => 'Calculus I',
                'description' => 'Limits, derivatives, and integrals',
                'credits' => 4,
                'category' => 'Mathematics',
                'instructor_name' => 'Dr. Johnson',
                'schedule_days' => 'Monday,Wednesday',
                'schedule_time' => '10:00-12:00',
                'room' => 'Room 202'
            ],
            [
                'code' => 'ENG101',
                'name' => 'Academic Writing',
                'description' => 'Essay writing and composition',
                'credits' => 3,
                'category' => 'English',
                'instructor_name' => 'Prof. Williams',
                'schedule_days' => 'Monday,Wednesday',
                'schedule_time' => '14:00-16:00',
                'room' => 'Room 303'
            ],
            [
                'code' => 'PHY201',
                'name' => 'Physics I',
                'description' => 'Mechanics and thermodynamics',
                'credits' => 4,
                'category' => 'Physics',
                'instructor_name' => 'Dr. Brown',
                'schedule_days' => 'Tuesday,Thursday',
                'schedule_time' => '8:00-10:00',
                'room' => 'Room 401'
            ],
            [
                'code' => 'CHEM101',
                'name' => 'General Chemistry',
                'description' => 'Basic chemistry concepts',
                'credits' => 4,
                'category' => 'Chemistry',
                'instructor_name' => 'Dr. Davis',
                'schedule_days' => 'Tuesday,Thursday',
                'schedule_time' => '10:00-12:00',
                'room' => 'Room 502'
            ],
            [
                'code' => 'BIO101',
                'name' => 'Introduction to Biology',
                'description' => 'Cell biology and genetics',
                'credits' => 4,
                'category' => 'Biology',
                'instructor_name' => 'Dr. Wilson',
                'schedule_days' => 'Tuesday,Thursday',
                'schedule_time' => '14:00-16:00',
                'room' => 'Room 601'
            ],
            [
                'code' => 'CS202',
                'name' => 'Data Structures',
                'description' => 'Advanced programming and algorithms',
                'credits' => 3,
                'category' => 'Computer Science',
                'instructor_name' => 'Dr. Anderson',
                'schedule_days' => 'Friday',
                'schedule_time' => '8:00-10:00',
                'room' => 'Room 102'
            ],
            [
                'code' => 'MATH202',
                'name' => 'Linear Algebra',
                'description' => 'Vectors, matrices, and linear transformations',
                'credits' => 3,
                'category' => 'Mathematics',
                'instructor_name' => 'Dr. Taylor',
                'schedule_days' => 'Friday',
                'schedule_time' => '10:00-12:00',
                'room' => 'Room 203'
            ],
            [
                'code' => 'CS303',
                'name' => 'Database Systems',
                'description' => 'Database design and SQL',
                'credits' => 3,
                'category' => 'Computer Science',
                'instructor_name' => 'Dr. Martin',
                'schedule_days' => 'Friday',
                'schedule_time' => '14:00-16:00',
                'room' => 'Room 103'
            ]
        ];

        foreach ($sampleCourses as $course) {
            try {
                $stmt = $this->db->prepare("
                    INSERT INTO courses (code, name, description, credits, category, instructor_name, schedule_days, schedule_time, room)
                    VALUES (:code, :name, :description, :credits, :category, :instructor_name, :schedule_days, :schedule_time, :room)
                    ON DUPLICATE KEY UPDATE
                    name = VALUES(name),
                    description = VALUES(description),
                    credits = VALUES(credits),
                    category = VALUES(category),
                    instructor_name = VALUES(instructor_name),
                    schedule_days = VALUES(schedule_days),
                    schedule_time = VALUES(schedule_time),
                    room = VALUES(room)
                ");
                
                $stmt->execute($course);
            } catch (\PDOException $e) {
                error_log("Error inserting course {$course['code']}: " . $e->getMessage());
                throw new \Exception("Failed to insert course {$course['code']}");
            }
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