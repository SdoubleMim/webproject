<?php

require_once __DIR__ . '/../config/database.php';

try {
    $config = require __DIR__ . '/../config/database.php';
    
    // First connect without database to ensure it exists
    $pdo = new PDO(
        "{$config['driver']}:host={$config['host']};charset={$config['charset']}", 
        $config['username'], 
        $config['password']
    );
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS webproject_database");
    $pdo->exec("USE webproject_database");
    
    // Now connect with the database
    $db = new PDO(
        "{$config['driver']}:host={$config['host']};dbname=webproject_database;charset={$config['charset']}", 
        $config['username'], 
        $config['password'], 
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
    
    // Read and execute the SQL file
    $sql = file_get_contents(__DIR__ . '/seed.sql');
    
    // Split SQL file into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    // Execute each statement
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            try {
                $db->exec($statement);
                echo "Executed: " . substr($statement, 0, 50) . "...\n";
            } catch (PDOException $e) {
                echo "Error executing statement: " . substr($statement, 0, 50) . "...\n";
                echo "Error message: " . $e->getMessage() . "\n\n";
            }
        }
    }
    
    echo "\nDatabase seeded successfully!\n";
    echo "You can now log in with the following credentials:\n";
    echo "Admin:\n";
    echo "  Username: admin\n";
    echo "  Password: password123\n\n";
    echo "Sample Student:\n";
    echo "  Username: john.doe\n";
    echo "  Password: password123\n";
    
} catch (PDOException $e) {
    die("Error seeding database: " . $e->getMessage() . "\n");
} 