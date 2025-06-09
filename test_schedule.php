<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Connect to database
    $db = new PDO('mysql:host=localhost;dbname=webproject_database', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Test query 1: Check users
    echo "<h3>Users:</h3>";
    $stmt = $db->query("SELECT * FROM users");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

    // Test query 2: Check students
    echo "<h3>Students:</h3>";
    $stmt = $db->query("SELECT * FROM students");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

    // Test query 3: Check courses
    echo "<h3>Courses:</h3>";
    $stmt = $db->query("SELECT * FROM courses");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

    // Test query 4: Check enrollments
    echo "<h3>Enrollments:</h3>";
    $stmt = $db->query("SELECT * FROM enrollments");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

    // Test query 5: Check specific student's schedule
    echo "<h3>Jane Smith's Schedule:</h3>";
    $query = "
        SELECT c.* 
        FROM courses c 
        INNER JOIN enrollments e ON c.id = e.course_id 
        INNER JOIN students s ON e.student_id = s.id 
        WHERE s.first_name = 'Jane' AND s.last_name = 'Smith'
    ";
    $stmt = $db->query($query);
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} 