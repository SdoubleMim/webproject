<?php
$db = new PDO("mysql:host=localhost;dbname=webproject_database", "root", "");
$result = $db->query("SELECT COUNT(*) as count FROM users")->fetch();
echo "Users in database: " . $result['count']; 