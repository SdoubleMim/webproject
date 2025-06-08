<?php

namespace App\Model;

use PDO;
use App\Database;

class Student
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO students (user_id, first_name, last_name, student_id, phone, address) 
                VALUES (:user_id, :first_name, :last_name, :student_id, :phone, :address)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'student_id' => $data['student_id'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null
        ]);
    }

    public function getByUserId($userId)
    {
        $sql = "SELECT s.*, u.email, u.username 
                FROM students s 
                JOIN users u ON s.user_id = u.id 
                WHERE s.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTotalCount()
    {
        $sql = "SELECT COUNT(*) as count FROM students";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['count'];
    }

    public function getAllStudents()
    {
        $sql = "SELECT s.*, u.email, u.username 
                FROM students s 
                JOIN users u ON s.user_id = u.id 
                ORDER BY s.last_name, s.first_name";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudentById($id)
    {
        $sql = "SELECT s.*, u.email, u.username 
                FROM students s 
                JOIN users u ON s.user_id = u.id 
                WHERE s.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStudent($id, array $data)
    {
        $sql = "UPDATE students 
                SET first_name = :first_name, 
                    last_name = :last_name, 
                    phone = :phone, 
                    address = :address 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null
        ]);
    }

    public function emailExists($email)
    {
        $sql = "SELECT COUNT(*) as count 
                FROM students s 
                JOIN users u ON s.user_id = u.id 
                WHERE u.email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['count'] > 0;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM students WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
} 