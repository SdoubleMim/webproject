<?php

$password = 'password123';
$hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

echo "Testing password verification:\n";
echo "Password: " . $password . "\n";
echo "Hash: " . $hash . "\n";
echo "Verification result: " . (password_verify($password, $hash) ? "Success" : "Failed") . "\n";

// Generate a new hash for comparison
$newHash = password_hash($password, PASSWORD_DEFAULT);
echo "\nNew hash generated: " . $newHash . "\n";
echo "New hash verification: " . (password_verify($password, $newHash) ? "Success" : "Failed") . "\n"; 