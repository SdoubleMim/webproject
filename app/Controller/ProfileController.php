<?php

namespace App\Controller;

use App\Database\Database;
use App\Model\User;

class ProfileController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function index() {
        if (!auth()) {
            redirect('/login');
        }

        $user = auth();
        $student = null;

        // If user is a student, get student info
        if ($user['role'] === 'student') {
            $stmt = $this->db->prepare("SELECT * FROM students WHERE user_id = ?");
            $stmt->execute([$user['id']]);
            $student = $stmt->fetch();
        }

        require_once __DIR__ . '/../../views/profile/index.php';
    }

    public function changePassword() {
        if (!auth()) {
            redirect('/login');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/profile');
        }

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $user = auth();

        // Get complete user data from database
        $dbUser = User::findById($user['id']);
        if (!$dbUser) {
            $_SESSION['error'] = 'User not found.';
            redirect('/profile');
        }

        // Validate current password
        if (!password_verify($currentPassword, $dbUser['password'])) {
            $_SESSION['error'] = 'Current password is incorrect.';
            redirect('/profile');
        }

        // Validate new password
        if (strlen($newPassword) < 8) {
            $_SESSION['error'] = 'New password must be at least 8 characters long.';
            redirect('/profile');
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $newPassword)) {
            $_SESSION['error'] = 'New password must include uppercase, lowercase, and numbers.';
            redirect('/profile');
        }

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'New passwords do not match.';
            redirect('/profile');
        }

        // Update password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT, ['cost' => 10]);
        if (User::updatePassword($user['id'], $hashedPassword)) {
            $_SESSION['success'] = 'Password updated successfully.';
            // Force re-login with new password
            session_destroy();
            redirect('/login');
        } else {
            $_SESSION['error'] = 'Failed to update password. Please try again.';
            redirect('/profile');
        }
    }
} 