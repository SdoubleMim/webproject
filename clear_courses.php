<?php
require_once 'bootstrap.php';

use App\Database\Database;

$db = Database::getInstance()->getConnection();
try {
    $db->exec("TRUNCATE TABLE courses");
    echo "Successfully cleared courses table\n";
} catch (PDOException $e) {
    echo "Error clearing courses: " . $e->getMessage() . "\n";
} 