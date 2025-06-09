<?php

require_once __DIR__ . '/vendor/autoload.php';

try {
    $db = new PDO(
        "mysql:host=localhost;dbname=webproject",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "Connected to database successfully\n";
    
    // Clear existing courses
    $db->exec("TRUNCATE TABLE courses");
    echo "Cleared existing courses\n";
    
    // Insert a test course
    $stmt = $db->prepare("
        INSERT INTO courses (code, name, description, credits, category, instructor_name, schedule_days, schedule_time, room)
        VALUES (:code, :name, :description, :credits, :category, :instructor_name, :schedule_days, :schedule_time, :room)
    ");
    
    $course = [
        'code' => 'CS101',
        'name' => 'Introduction to Programming',
        'description' => 'Basic programming concepts using Python',
        'credits' => 3,
        'category' => 'Computer Science',
        'instructor_name' => 'Dr. Smith',
        'schedule_days' => 'Monday,Wednesday',
        'schedule_time' => '8:00-10:00',
        'room' => 'Room 101'
    ];
    
    $result = $stmt->execute($course);
    echo $result ? "Test course inserted successfully\n" : "Failed to insert test course\n";
    
    // Verify the course was inserted
    $courses = $db->query("SELECT * FROM courses")->fetchAll(PDO::FETCH_ASSOC);
    echo "Found " . count($courses) . " courses in database\n";
    print_r($courses);
    
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage() . "\n");
} 