<?php

require_once __DIR__ . '/vendor/autoload.php';

try {
    // First connect without database selection
    $pdo = new PDO(
        "mysql:host=localhost",
        "root",
        "",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ]
    );
    
    echo "✅ MySQL connection successful!\n\n";
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS webproject_database");
    $pdo->exec("USE webproject_database");
    
    echo "✅ Database 'webproject_database' selected/created successfully!\n\n";
    
    // Create tables
    echo "Creating/Verifying tables:\n";
    echo "-------------------------\n";
    
    // Users table
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'teacher', 'student') NOT NULL DEFAULT 'student',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
    echo "✅ Users table ready\n";
    
    // Students table
    $pdo->exec("CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        student_id VARCHAR(20) NOT NULL UNIQUE,
        date_of_birth DATE,
        gender ENUM('male', 'female', 'other'),
        address TEXT,
        phone VARCHAR(20),
        class VARCHAR(20),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");
    echo "✅ Students table ready\n";
    
    // Courses table
    $pdo->exec("CREATE TABLE IF NOT EXISTS courses (
        id INT AUTO_INCREMENT PRIMARY KEY,
        course_code VARCHAR(20) NOT NULL UNIQUE,
        course_name VARCHAR(100) NOT NULL,
        description TEXT,
        credits INT NOT NULL,
        category VARCHAR(50),
        instructor_name VARCHAR(100),
        max_students INT DEFAULT 30,
        schedule_days VARCHAR(50),
        schedule_time VARCHAR(50),
        room VARCHAR(50)
    )");
    echo "✅ Courses table ready\n";
    
    // Enrollments table
    $pdo->exec("CREATE TABLE IF NOT EXISTS enrollments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT NOT NULL,
        course_id INT NOT NULL,
        enrollment_date DATE NOT NULL,
        grade DECIMAL(5,2),
        FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
        FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
    )");
    echo "✅ Enrollments table ready\n\n";
    
    // Test database queries
    echo "Database Information:\n";
    echo "--------------------\n";
    
    // Get MySQL version
    $version = $pdo->query('SELECT VERSION() as version')->fetch();
    echo "MySQL Version: " . $version['version'] . "\n";
    
    // Get database name
    $dbname = $pdo->query('SELECT DATABASE() as dbname')->fetch();
    echo "Current Database: " . $dbname['dbname'] . "\n";
    
    // List all tables and their row counts
    echo "\nTable Statistics:\n";
    $tables = $pdo->query('SHOW TABLES')->fetchAll();
    if (count($tables) > 0) {
        foreach ($tables as $table) {
            $tableName = reset($table);
            $count = $pdo->query("SELECT COUNT(*) as count FROM `$tableName`")->fetch();
            echo "- $tableName: {$count['count']} rows\n";
        }
    } else {
        echo "No tables found in the database.\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
    
    // Additional error information
    echo "\nTroubleshooting steps:\n";
    echo "1. Make sure MySQL is running\n";
    echo "2. Verify database name exists\n";
    echo "3. Check username and password\n";
    echo "4. Confirm host is accessible\n";
    
    // Check if MySQL service is running
    if (stripos(PHP_OS, 'WIN') === 0) {
        exec('net start mysql', $output, $returnVal);
        if ($returnVal !== 0) {
            echo "\nMySQL service appears to be stopped. Try starting it with:\n";
            echo "net start mysql\n";
        }
    }
} 