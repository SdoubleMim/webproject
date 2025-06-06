<?php

namespace App\Model;

use PDO;

class Student
{
    private static function getDB()
    {
        $config = require __DIR__ . '/../../config/database.php';
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
        
        return new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public static function create(array $data)
    {
        $db = self::getDB();
        $sql = "INSERT INTO students (user_id, first_name, last_name, student_id, phone, address) 
                VALUES (:user_id, :first_name, :last_name, :student_id, :phone, :address)";
        
        $stmt = $db->prepare($sql);
        return $stmt->execute($data);
    }

    public static function findById(int $id)
    {
        $db = self::getDB();
        $sql = "SELECT s.*, u.email, u.username 
                FROM students s 
                JOIN users u ON s.user_id = u.id 
                WHERE s.id = :id";
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        return $stmt->fetch();
    }

    public static function findByUserId(int $userId)
    {
        $db = self::getDB();
        $sql = "SELECT s.*, u.email, u.username 
                FROM students s 
                JOIN users u ON s.user_id = u.id 
                WHERE s.user_id = :user_id";
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        
        return $stmt->fetch();
    }

    public static function update(int $id, array $data)
    {
        $db = self::getDB();
        $sql = "UPDATE students 
                SET first_name = :first_name, 
                    last_name = :last_name, 
                    phone = :phone, 
                    address = :address 
                WHERE id = :id";
        
        $stmt = $db->prepare($sql);
        return $stmt->execute(array_merge($data, ['id' => $id]));
    }

    public static function getAll()
    {
        $db = self::getDB();
        $sql = "SELECT s.*, u.email, u.username 
                FROM students s 
                JOIN users u ON s.user_id = u.id 
                ORDER BY s.last_name, s.first_name";
        
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public static function delete(int $id)
    {
        $db = self::getDB();
        $sql = "DELETE FROM students WHERE id = :id";
        
        $stmt = $db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
} 