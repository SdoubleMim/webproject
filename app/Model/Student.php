<?php

namespace App\Model;

use App\Database\Database;
use PDO;

class Student extends BaseModel
{
    protected $table = 'students';

    public function __construct()
    {
        parent::__construct();
    }

    public function getStudentById($id)
    {
        $sql = "SELECT s.*, u.email, u.username 
                FROM students s 
                JOIN users u ON s.user_id = u.id 
                WHERE s.id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getByUserId($userId)
    {
        $sql = "SELECT s.*, u.email, u.username 
                FROM students s 
                JOIN users u ON s.user_id = u.id 
                WHERE s.user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch();
    }

    public function emailExists($email, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) as count 
                FROM students s 
                JOIN users u ON s.user_id = u.id 
                WHERE u.email = :email";
        $params = ['email' => $email];

        if ($excludeId) {
            $sql .= " AND s.id != :id";
            $params['id'] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }

    public function updateStudent($id, $data)
    {
        try {
            $this->db->beginTransaction();

            // Update student data
            $studentData = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'student_id' => $data['student_id']
            ];

            $studentFields = array_map(function($field) {
                return "{$field} = :{$field}";
            }, array_keys($studentData));

            $sql = "UPDATE {$this->table} 
                    SET " . implode(', ', $studentFields) . " 
                    WHERE id = :id";

            $studentData['id'] = $id;
            $stmt = $this->db->prepare($sql);
            $stmt->execute($studentData);

            // Update user data if email is provided
            if (!empty($data['email'])) {
                $student = $this->getStudentById($id);
                if ($student) {
                    $sql = "UPDATE users SET email = :email WHERE id = :user_id";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([
                        'email' => $data['email'],
                        'user_id' => $student['user_id']
                    ]);
                }
            }

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getAllStudents()
    {
        $sql = "SELECT s.*, u.email, u.username 
                FROM students s 
                JOIN users u ON s.user_id = u.id 
                ORDER BY s.last_name, s.first_name";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function createStudent($data)
    {
        try {
            $this->db->beginTransaction();

            // Create user first
            $sql = "INSERT INTO users (username, email, password, role) 
                    VALUES (:username, :email, :password, 'student')";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT)
            ]);
            
            $userId = $this->db->lastInsertId();

            // Then create student
            $sql = "INSERT INTO students (user_id, student_id, first_name, last_name) 
                    VALUES (:user_id, :student_id, :first_name, :last_name)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'user_id' => $userId,
                'student_id' => $data['student_id'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name']
            ]);

            $this->db->commit();
            return $this->db->lastInsertId();
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function deleteStudent($id)
    {
        try {
            $this->db->beginTransaction();

            // Get user_id first
            $student = $this->getStudentById($id);
            if (!$student) {
                throw new \Exception("Student not found");
            }

            // Delete student
            $sql = "DELETE FROM students WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);

            // Delete user
            $sql = "DELETE FROM users WHERE id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $student['user_id']]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
} 