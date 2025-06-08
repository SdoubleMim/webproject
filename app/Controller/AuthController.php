<?php

namespace App\Controller;

use App\Model\User;
use App\Model\Student;

class AuthController
{
    private $studentModel;

    public function __construct()
    {
        $this->studentModel = new Student();
    }

    public function loginForm()
    {
        view('auth/login');
    }

    public function login()
    {
        $studentId = $_POST['student_id'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($studentId) || empty($password)) {
            $_SESSION['message'] = 'Student ID and password are required';
            $_SESSION['message_type'] = 'danger';
            redirect('/login');
        }

        $user = User::findByStudentId($studentId);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'username' => $user['username'],
                'role' => $user['role']
            ];
            $_SESSION['message'] = 'Welcome back!';
            $_SESSION['message_type'] = 'success';
            redirect('/dashboard');
        }

        $_SESSION['message'] = 'Invalid credentials';
        $_SESSION['message_type'] = 'danger';
        redirect('/login');
    }

    public function registerForm()
    {
        view('auth/register');
    }

    public function register()
    {
        // Validate required fields
        $required = ['username', 'email', 'password', 'password_confirm', 'first_name', 'last_name', 'student_id'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['message'] = 'All required fields must be filled';
                $_SESSION['message_type'] = 'danger';
                redirect('/register');
            }
        }

        // Validate password confirmation
        if ($_POST['password'] !== $_POST['password_confirm']) {
            $_SESSION['message'] = 'Passwords do not match';
            $_SESSION['message_type'] = 'danger';
            redirect('/register');
        }

        // Check if email already exists
        if (User::findByEmail($_POST['email'])) {
            $_SESSION['message'] = 'Email already registered';
            $_SESSION['message_type'] = 'danger';
            redirect('/register');
        }

        // Create user
        $userData = [
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role' => 'student'
        ];

        $userId = User::create($userData);

        if ($userId) {
            // Create student profile
            $studentData = [
                'user_id' => $userId,
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'student_id' => $_POST['student_id'],
                'phone' => $_POST['phone'] ?? null,
                'address' => $_POST['address'] ?? null
            ];

            if ($this->studentModel->create($studentData)) {
                $_SESSION['message'] = 'Registration successful! Please login.';
                $_SESSION['message_type'] = 'success';
                redirect('/login');
            }
        }

        $_SESSION['message'] = 'Registration failed. Please try again.';
        $_SESSION['message_type'] = 'danger';
        redirect('/register');
    }

    public function logout()
    {
        session_destroy();
        redirect('/login');
    }
} 