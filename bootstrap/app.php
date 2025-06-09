<?php

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load configuration
$config = require_once __DIR__ . '/../config/database.php';

// Create PDO instance
try {
    $pdo = new PDO(
        "{$config['driver']}:host={$config['host']};dbname={$config['database']};charset={$config['charset']}",
        $config['username'],
        $config['password'],
        $config['options']
    );
    
    // Make PDO instance available globally
    $GLOBALS['db'] = $pdo;
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Load helper functions
require_once __DIR__ . '/../app/helpers.php';

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set default timezone
date_default_timezone_set('UTC');

// Return PDO instance
return $pdo; 