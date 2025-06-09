<?php

namespace App\Controller;

use App\Model\Course;
use App\Model\Student;

class CourseController {
    private $courseModel;
    private $studentModel;
    private $viewPath;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!auth()) {
            setFlash('Please login to continue', 'warning');
            redirect('/login');
        }
        $this->courseModel = new Course();
        $this->studentModel = new Student();
        $this->viewPath = __DIR__ . '/../../views';
    }

    private function render($view, $data = []) {
        extract($data);
        require_once $this->viewPath . '/courses/' . $view . '.php';
    }

    private function setFlash($message, $type = 'info') {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
    }

    private function redirect($path) {
        header("Location: /webproject/" . ltrim($path, '/'));
        exit();
    }

    public function index() {
        try {
            // Get search term if any
            $search = htmlspecialchars(trim($_GET['search'] ?? ''));
            
            // Get courses based on search
            if ($search) {
                $courses = $this->courseModel->searchCourses($search);
            } else {
                $courses = $this->courseModel->getAll();
            }

            // Get current user and their enrolled courses
            $user = auth();
            $enrolledIds = [];
            
            // Only try to get student info if user is a student
            if ($user['role'] === 'student') {
                $student = $this->studentModel->getByUserId($user['id']);
                if ($student) {
                    $enrolledCourses = $this->courseModel->getEnrolledCourses($student['id']);
                    $enrolledIds = array_column($enrolledCourses, 'id');
                }
            }

            // Render the view
            $this->render('index', [
                'courses' => $courses,
                'enrolledIds' => $enrolledIds,
                'search' => $search,
                'categories' => ['Programming', 'Mathematics', 'Science', 'Languages', 'Arts', 'Other']
            ]);
        } catch (\Exception $e) {
            error_log('Error in CourseController::index: ' . $e->getMessage());
            setFlash($e->getMessage(), 'danger');
            $this->render('index', [
                'courses' => [],
                'enrolledIds' => [],
                'search' => $search ?? '',
                'categories' => ['Programming', 'Mathematics', 'Science', 'Languages', 'Arts', 'Other']
            ]);
        }
    }

    public function show($id) {
        try {
            if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
                throw new \Exception('Invalid course ID');
            }

            $course = $this->courseModel->getById($id);
            
            if (!$course) {
                throw new \Exception('Course not found');
            }

            $user = auth();
            $student = $this->studentModel->getByUserId($user['id']);
            $isEnrolled = $student ? $this->courseModel->isEnrolled($student['id'], $id) : false;

            $this->render('show', [
                'course' => $course,
                'isEnrolled' => $isEnrolled
            ]);
        } catch (\Exception $e) {
            $this->setFlash($e->getMessage(), 'danger');
            $this->redirect('courses');
        }
    }

    public function create() {
        try {
            if (!isAdmin()) {
                throw new \Exception('Unauthorized access');
            }

            $this->render('form', [
                'categories' => ['Programming', 'Mathematics', 'Science', 'Languages', 'Arts', 'Other'],
                'course' => [
                    'id' => '',
                    'code' => '',
                    'name' => '',
                    'description' => '',
                    'credits' => '',
                    'category' => '',
                    'instructor_name' => '',
                    'max_students' => '30',
                    'schedule_days' => '',
                    'schedule_time' => '',
                    'room' => ''
                ],
                'isEdit' => false
            ]);
        } catch (\Exception $e) {
            $this->setFlash($e->getMessage(), 'danger');
            $this->redirect('courses');
        }
    }

    public function store() {
        try {
            if (!isAdmin()) {
                throw new \Exception('Unauthorized access');
            }

            $data = [
                'code' => filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING),
                'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
                'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
                'credits' => filter_input(INPUT_POST, 'credits', FILTER_VALIDATE_INT),
                'category' => filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'instructor_name' => filter_input(INPUT_POST, 'instructor_name', FILTER_SANITIZE_STRING),
                'max_students' => filter_input(INPUT_POST, 'max_students', FILTER_VALIDATE_INT),
                'schedule_days' => filter_input(INPUT_POST, 'schedule_days', FILTER_SANITIZE_STRING),
                'schedule_time' => filter_input(INPUT_POST, 'schedule_time', FILTER_SANITIZE_STRING),
                'room' => filter_input(INPUT_POST, 'room', FILTER_SANITIZE_STRING)
            ];

            if (in_array(false, $data, true) || in_array(null, $data, true)) {
                throw new \Exception('Please fill all required fields');
            }

            // Validate numeric fields
            if (!is_numeric($data['credits']) || $data['credits'] <= 0) {
                throw new \Exception('Credits must be a positive number');
            }

            if (!empty($data['max_students']) && (!is_numeric($data['max_students']) || $data['max_students'] <= 0)) {
                throw new \Exception('Maximum students must be a positive number');
            }

            if ($this->courseModel->create($data)) {
                $this->setFlash('Course created successfully', 'success');
                $this->redirect('courses');
            } else {
                throw new \Exception('Failed to create course');
            }
        } catch (\Exception $e) {
            $this->setFlash($e->getMessage(), 'danger');
            $this->redirect('courses/create');
        }
    }

    public function edit($id) {
        try {
            if (!isAdmin()) {
                throw new \Exception('Unauthorized access');
            }

            if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
                throw new \Exception('Invalid course ID');
            }

            $course = $this->courseModel->getById($id);
            
            if (!$course) {
                throw new \Exception('Course not found');
            }

            $this->render('form', [
                'categories' => ['Programming', 'Mathematics', 'Science', 'Languages', 'Arts', 'Other'],
                'course' => $course,
                'isEdit' => true
            ]);
        } catch (\Exception $e) {
            $this->setFlash($e->getMessage(), 'danger');
            $this->redirect('courses');
        }
    }

    public function update($id) {
        try {
            if (!isAdmin()) {
                throw new \Exception('Unauthorized access');
            }

            if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
                throw new \Exception('Invalid course ID');
            }

            $data = [
                'code' => filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING),
                'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
                'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
                'credits' => filter_input(INPUT_POST, 'credits', FILTER_VALIDATE_INT),
                'category' => filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'instructor_name' => filter_input(INPUT_POST, 'instructor_name', FILTER_SANITIZE_STRING),
                'max_students' => filter_input(INPUT_POST, 'max_students', FILTER_VALIDATE_INT),
                'schedule_days' => filter_input(INPUT_POST, 'schedule_days', FILTER_SANITIZE_STRING),
                'schedule_time' => filter_input(INPUT_POST, 'schedule_time', FILTER_SANITIZE_STRING),
                'room' => filter_input(INPUT_POST, 'room', FILTER_SANITIZE_STRING)
            ];

            if (in_array(false, $data, true) || in_array(null, $data, true)) {
                throw new \Exception('Please fill all required fields');
            }

            // Validate numeric fields
            if (!is_numeric($data['credits']) || $data['credits'] <= 0) {
                throw new \Exception('Credits must be a positive number');
            }

            if (!empty($data['max_students']) && (!is_numeric($data['max_students']) || $data['max_students'] <= 0)) {
                throw new \Exception('Maximum students must be a positive number');
            }

            if ($this->courseModel->update($id, $data)) {
                $this->setFlash('Course updated successfully', 'success');
                $this->redirect('courses');
            } else {
                throw new \Exception('Failed to update course');
            }
        } catch (\Exception $e) {
            $this->setFlash($e->getMessage(), 'danger');
            $this->redirect('courses/edit/' . $id);
        }
    }

    public function delete($id) {
        try {
            if (!isAdmin()) {
                throw new \Exception('Unauthorized access');
            }

            if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
                throw new \Exception('Invalid course ID');
            }

            if ($this->courseModel->delete($id)) {
                $this->setFlash('Course deleted successfully', 'success');
            } else {
                throw new \Exception('Failed to delete course');
            }
        } catch (\Exception $e) {
            $this->setFlash($e->getMessage(), 'danger');
        }
        $this->redirect('courses');
    }

    public function enroll($id) {
        try {
            if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
                throw new \Exception('Invalid course ID');
            }

            $user = auth();
            $student = $this->studentModel->getByUserId($user['id']);
            
            if (!$student) {
                throw new \Exception('Student profile not found');
            }

            $course = $this->courseModel->getById($id);
            if (!$course) {
                throw new \Exception('Course not found');
            }

            if ($this->courseModel->isEnrolled($student['id'], $id)) {
                throw new \Exception('You are already enrolled in this course');
            }

            if ($this->courseModel->enroll($student['id'], $id)) {
                setFlash('Successfully enrolled in the course', 'success');
            } else {
                throw new \Exception('Failed to enroll in the course');
            }
        } catch (\Exception $e) {
            setFlash($e->getMessage(), 'danger');
        }
        redirect('/courses');
    }

    public function drop($id) {
        try {
            if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
                throw new \Exception('Invalid course ID');
            }

            $user = auth();
            $student = $this->studentModel->getByUserId($user['id']);
            
            if (!$student) {
                throw new \Exception('Student profile not found');
            }

            $course = $this->courseModel->getById($id);
            if (!$course) {
                throw new \Exception('Course not found');
            }

            if (!$this->courseModel->isEnrolled($student['id'], $id)) {
                throw new \Exception('You are not enrolled in this course');
            }

            if ($this->courseModel->drop($student['id'], $id)) {
                setFlash('Successfully dropped the course', 'success');
            } else {
                throw new \Exception('Failed to drop the course');
            }
        } catch (\Exception $e) {
            setFlash($e->getMessage(), 'danger');
        }
        redirect('/courses');
    }
} 