<?php

namespace App\Controller;

use App\Model\Student;
use App\Model\Course;
use App\Model\Enrollment;
use PDOException;
use PDO;

class StudentController
{
    private $studentModel;
    private $courseModel;
    private $enrollmentModel;

    public function __construct()
    {
        $this->studentModel = new Student();
        $this->courseModel = new Course();
        $this->enrollmentModel = new Enrollment();
        $this->connect();
    }

    public function index()
    {
        // Check if user is admin
        if (!isAdmin()) {
            setFlash('Unauthorized access', 'danger');
            redirect('/dashboard');
        }

        $students = $this->studentModel->getAllStudents();
        
        require_once __DIR__ . '/../../views/students/index.php';
    }

    public function show($id)
    {
        // Get the student
        $student = $this->studentModel->getStudentById($id);
        
        if (!$student) {
            setFlash('Student not found', 'danger');
            redirect('/students');
        }

        // Check if current user is admin or the student themselves
        if (!isAdmin() && auth()['id'] !== $student['id']) {
            setFlash('Unauthorized access', 'danger');
            redirect('/dashboard');
        }

        // Get student's enrolled courses
        $enrolledCourses = $this->courseModel->getEnrolledCourses($id);
        
        // Get student's grades
        $grades = $this->enrollmentModel->getStudentGrades($id);
        
        // Get student's schedule
        $schedule = $this->courseModel->getStudentSchedule($id);

        require_once __DIR__ . '/../../views/students/show.php';
    }

    public function edit($id)
    {
        // Get the student
        $student = $this->studentModel->getStudentById($id);
        
        if (!$student) {
            setFlash('Student not found', 'danger');
            redirect('/students');
        }

        // Check if current user is admin or the student themselves
        if (!isAdmin() && auth()['id'] !== $student['id']) {
            setFlash('Unauthorized access', 'danger');
            redirect('/dashboard');
        }

        require_once __DIR__ . '/../../views/students/edit.php';
    }

    public function update($id)
    {
        // Get the student
        $student = $this->studentModel->getStudentById($id);
        
        if (!$student) {
            setFlash('Student not found', 'danger');
            redirect('/students');
        }

        // Check if current user is admin or the student themselves
        if (!isAdmin() && auth()['id'] !== $student['id']) {
            setFlash('Unauthorized access', 'danger');
            redirect('/dashboard');
        }

        // Validate input
        $errors = [];
        
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');

        if (empty($first_name)) {
            $errors['first_name'] = 'First name is required';
        }

        if (empty($last_name)) {
            $errors['last_name'] = 'Last name is required';
        }

        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        } elseif ($email !== $student['email'] && $this->studentModel->emailExists($email)) {
            $errors['email'] = 'Email already exists';
        }

        if (!empty($phone) && !preg_match('/^[0-9\-\(\)\/\+\s]*$/', $phone)) {
            $errors['phone'] = 'Invalid phone number format';
        }

        // If there are errors, redirect back with errors and old input
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            redirect("/students/edit/{$id}");
        }

        // Update student
        $data = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
        ];

        if ($this->studentModel->updateStudent($id, $data)) {
            setFlash('Student updated successfully', 'success');
            redirect("/students/show/{$id}");
        } else {
            setFlash('Failed to update student', 'danger');
            redirect("/students/edit/{$id}");
        }
    }

    public function __wakeup() {
        // Reconnect when unserialized
        $this->connect();
    }

    private function connect() {
        $host = 'localhost';
        $dbname = 'student_management';
        $username = 'root';
        $password = '';

        try {
            $this->connection = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
} 