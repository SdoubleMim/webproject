<?php

namespace App\Model;

use App\Database;

class Course extends \App\Model {
    protected $table = 'courses';

    public function getAllCourses() {
        try {
            return $this->db->fetchAll("SELECT * FROM {$this->table} ORDER BY code");
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            throw new \Exception('Error fetching courses');
        }
    }

    public function getCoursesByCategory($category) {
        try {
            if (empty($category)) {
                throw new \Exception('Category is required');
            }

            return $this->db->fetchAll(
                "SELECT * FROM {$this->table} WHERE category = :category ORDER BY code",
                ['category' => $category]
            );
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            throw new \Exception('Error fetching courses by category');
        }
    }

    public function getCourse($id) {
        try {
            if (!is_numeric($id) || $id <= 0) {
                throw new \Exception('Invalid course ID');
            }

            $course = $this->db->fetch(
                "SELECT * FROM {$this->table} WHERE id = :id",
                ['id' => $id]
            );

            if (!$course) {
                throw new \Exception('Course not found');
            }

            return $course;
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            throw new \Exception('Error fetching course');
        }
    }

    public function createCourse($data) {
        try {
            // Validate required fields
            $required = ['code', 'name', 'credits', 'category'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    throw new \Exception("Field {$field} is required");
                }
            }

            // Validate numeric fields
            if (!is_numeric($data['credits']) || $data['credits'] <= 0) {
                throw new \Exception('Credits must be a positive number');
            }

            if (!empty($data['max_students']) && (!is_numeric($data['max_students']) || $data['max_students'] <= 0)) {
                throw new \Exception('Maximum students must be a positive number');
            }

            // Check if course code already exists
            $exists = $this->db->fetch(
                "SELECT id FROM {$this->table} WHERE code = :code",
                ['code' => $data['code']]
            );

            if ($exists) {
                throw new \Exception('Course code already exists');
            }

            // Set default values
            $data['max_students'] = !empty($data['max_students']) ? (int) $data['max_students'] : 30;
            $data['description'] = $data['description'] ?? '';
            $data['instructor_name'] = $data['instructor_name'] ?? '';
            $data['schedule_days'] = $data['schedule_days'] ?? '';
            $data['schedule_time'] = $data['schedule_time'] ?? '';
            $data['room'] = $data['room'] ?? '';

            return $this->create($data);
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            throw new \Exception('Error creating course');
        }
    }

    public function updateCourse($id, $data) {
        try {
            if (!is_numeric($id) || $id <= 0) {
                throw new \Exception('Invalid course ID');
            }

            // Validate required fields
            $required = ['code', 'name', 'credits', 'category'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    throw new \Exception("Field {$field} is required");
                }
            }

            // Validate numeric fields
            if (!is_numeric($data['credits']) || $data['credits'] <= 0) {
                throw new \Exception('Credits must be a positive number');
            }

            if (!empty($data['max_students']) && (!is_numeric($data['max_students']) || $data['max_students'] <= 0)) {
                throw new \Exception('Maximum students must be a positive number');
            }

            // Check if course exists
            $exists = $this->db->fetch(
                "SELECT id FROM {$this->table} WHERE id = :id",
                ['id' => $id]
            );

            if (!$exists) {
                throw new \Exception('Course not found');
            }

            // Check if course code already exists for different course
            $duplicate = $this->db->fetch(
                "SELECT id FROM {$this->table} WHERE code = :code AND id != :id",
                ['code' => $data['code'], 'id' => $id]
            );

            if ($duplicate) {
                throw new \Exception('Course code already exists');
            }

            // Set default values
            $data['max_students'] = !empty($data['max_students']) ? (int) $data['max_students'] : 30;
            $data['description'] = $data['description'] ?? '';
            $data['instructor_name'] = $data['instructor_name'] ?? '';
            $data['schedule_days'] = $data['schedule_days'] ?? '';
            $data['schedule_time'] = $data['schedule_time'] ?? '';
            $data['room'] = $data['room'] ?? '';

            return $this->update($id, $data);
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            throw new \Exception('Error updating course');
        }
    }

    public function deleteCourse($id) {
        try {
            if (!is_numeric($id) || $id <= 0) {
                throw new \Exception('Invalid course ID');
            }

            // Check if course exists
            $exists = $this->db->fetch(
                "SELECT id FROM {$this->table} WHERE id = :id",
                ['id' => $id]
            );

            if (!$exists) {
                throw new \Exception('Course not found');
            }

            // Delete enrollments first
            $this->db->query(
                "DELETE FROM enrollments WHERE course_id = :id",
                ['id' => $id]
            );

            // Delete course
            return $this->delete($id);
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            throw new \Exception('Error deleting course');
        }
    }

    public function searchCourses($query) {
        try {
            if (empty($query)) {
                return $this->getAllCourses();
            }

            $searchTerm = "%{$query}%";
            return $this->db->fetchAll(
                "SELECT * FROM {$this->table} 
                WHERE code LIKE :query 
                OR name LIKE :query 
                OR description LIKE :query 
                OR category LIKE :query 
                OR instructor_name LIKE :query 
                ORDER BY code",
                ['query' => $searchTerm]
            );
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

            $course = $this->db->fetch(
                "SELECT max_students FROM {$this->table} WHERE id = :id",
                ['id' => $courseId]
            );

            if (!$course) {
                throw new \Exception('Course not found');
            }

            $enrolled = $this->db->fetch(
                "SELECT COUNT(*) as count FROM enrollments WHERE course_id = :id",
                ['id' => $courseId]
            );

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

            return $this->db->fetchAll(
                "SELECT u.* FROM users u 
                JOIN enrollments e ON u.id = e.user_id 
                WHERE e.course_id = :id 
                ORDER BY u.name",
                ['id' => $courseId]
            );
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            throw new \Exception('Error getting enrolled students');
        }
    }

    public function enrollStudent($courseId, $userId) {
        try {
            if (!is_numeric($courseId) || $courseId <= 0) {
                throw new \Exception('Invalid course ID');
            }

            if (!is_numeric($userId) || $userId <= 0) {
                throw new \Exception('Invalid user ID');
            }

            // Check if course exists
            $course = $this->db->fetch(
                "SELECT * FROM {$this->table} WHERE id = :id",
                ['id' => $courseId]
            );

            if (!$course) {
                throw new \Exception('Course not found');
            }

            // Check if already enrolled
            $enrolled = $this->db->fetch(
                "SELECT id FROM enrollments 
                WHERE course_id = :course_id AND user_id = :user_id",
                ['course_id' => $courseId, 'user_id' => $userId]
            );

            if ($enrolled) {
                throw new \Exception('Already enrolled in this course');
            }

            // Check available seats
            if ($this->getAvailableSeats($courseId) <= 0) {
                throw new \Exception('No available seats in this course');
            }

            // Enroll student
            return $this->db->query(
                "INSERT INTO enrollments (course_id, user_id) VALUES (:course_id, :user_id)",
                ['course_id' => $courseId, 'user_id' => $userId]
            );
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            throw new \Exception('Error enrolling in course');
        }
    }
} 