<?php

try {
    $db = new PDO(
        "mysql:host=localhost;dbname=webproject_database;charset=utf8mb4",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Test queries
    $tables = ['users', 'students', 'courses', 'enrollments', 'schedules'];
    
    foreach ($tables as $table) {
        $count = $db->query("SELECT COUNT(*) as count FROM $table")->fetch()['count'];
        echo "$table: $count records\n";
        
        if ($count > 0) {
            $rows = $db->query("SELECT * FROM $table LIMIT 1")->fetch();
            echo "Sample row: " . print_r($rows, true) . "\n\n";
        }
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
} 