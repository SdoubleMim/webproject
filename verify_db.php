<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=webproject_database", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $tables = ['users', 'students', 'courses', 'enrollments', 'schedules'];
    
    foreach ($tables as $table) {
        $result = $db->query("SELECT COUNT(*) as count FROM $table")->fetch();
        echo "$table table has {$result['count']} records\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} 