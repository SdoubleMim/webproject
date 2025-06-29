<?php

namespace App\Model;

use PDO;

class User
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
        $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
        
        $stmt = $db->prepare($sql);
        if ($stmt->execute($data)) {
            return $db->lastInsertId();
        }
        return false;
    }

    public static function findByEmail(string $email)
    {
        $db = self::getDB();
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['email' => $email]);
        
        return $stmt->fetch();
    }

    public static function findById(int $id)
    {
        $db = self::getDB();
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        return $stmt->fetch();
    }

    public static function update(int $id, array $data)
    {
        $db = self::getDB();
        $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
        
        $stmt = $db->prepare($sql);
        return $stmt->execute(array_merge($data, ['id' => $id]));
    }

    public static function updatePassword(int $id, string $hashedPassword)
    {
        $db = self::getDB();
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            'password' => $hashedPassword,
            'id' => $id
        ]);
    }

    public static function delete(int $id)
    {
        $db = self::getDB();
        $sql = "DELETE FROM users WHERE id = :id";
        
        $stmt = $db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public static function findByStudentId(string $studentId)
    {
        $db = self::getDB();
        $sql = "SELECT u.* FROM users u 
                JOIN students s ON s.user_id = u.id 
                WHERE s.student_id = :student_id 
                LIMIT 1";
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['student_id' => $studentId]);
        
        return $stmt->fetch();
    }
} 