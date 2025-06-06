<?php

namespace App\Controller;

use App\Model\Course;

class CourseController {
    private $courseModel;
    private $viewPath;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->courseModel = new Course();
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
            $category = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($search) {
                $courses = $this->courseModel->searchCourses($search);
            } elseif ($category) {
                $courses = $this->courseModel->getCoursesByCategory($category);
            } else {
                $courses = $this->courseModel->getAllCourses();
            }

            // Get available seats for each course
            foreach ($courses as &$course) {
                try {
                    $course['available_seats'] = $this->courseModel->getAvailableSeats($course['id']);
                } catch (\Exception $e) {
                    $course['available_seats'] = 0;
                    error_log($e->getMessage());
                }
            }

            $this->render('index', [
                'courses' => $courses,
                'category' => $category,
                'search' => $search,
                'categories' => ['Programming', 'Mathematics', 'Science', 'Languages', 'Arts', 'Other']
            ]);
        } catch (\Exception $e) {
            $this->setFlash($e->getMessage(), 'danger');
            $this->render('index', [
                'courses' => [],
                'category' => '',
                'search' => '',
                'categories' => ['Programming', 'Mathematics', 'Science', 'Languages', 'Arts', 'Other']
            ]);
        }
    }

    public function show($id) {
        try {
            if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
                throw new \Exception('Invalid course ID');
            }

            // Get course details
            $course = null;
            try {
                $course = $this->courseModel->getCourse($id);
            } catch (\Exception $e) {
                throw new \Exception('Course not found');
            }

            if (!$course) {
                throw new \Exception('Course not found');
            }

            // Get available seats
            try {
                $course['available_seats'] = $this->courseModel->getAvailableSeats($id);
            } catch (\Exception $e) {
                $course['available_seats'] = 0;
                error_log($e->getMessage());
            }

            // Get enrolled students
            try {
                $enrolledStudents = $this->courseModel->getEnrolledStudents($id);
            } catch (\Exception $e) {
                $enrolledStudents = [];
                error_log($e->getMessage());
            }

            $this->render('show', [
                'course' => $course,
                'enrolledStudents' => $enrolledStudents
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
                'code' => filter_input(INPUT_POST, 'code', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'credits' => filter_input(INPUT_POST, 'credits', FILTER_VALIDATE_INT),
                'category' => filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'instructor_name' => filter_input(INPUT_POST, 'instructor_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'max_students' => filter_input(INPUT_POST, 'max_students', FILTER_VALIDATE_INT),
                'schedule_days' => filter_input(INPUT_POST, 'schedule_days', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'schedule_time' => filter_input(INPUT_POST, 'schedule_time', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'room' => filter_input(INPUT_POST, 'room', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ];

            // Validate required fields
            $required = ['code', 'name', 'credits', 'category'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    throw new \Exception("Field {$field} is required");
                }
            }

            // Validate numeric fields
            if (!is_numeric($data['credits']) || $data['credits'] <= 0) {
                throw new \Exception('Credits must be a positive number');
            }

            if (!empty($data['max_students']) && (!is_numeric($data['max_students']) || $data['max_students'] <= 0)) {
                throw new \Exception('Maximum students must be a positive number');
            }

            $courseId = $this->courseModel->createCourse($data);

            if ($courseId) {
                $this->setFlash('Course created successfully', 'success');
                $this->redirect('courses/show/' . $courseId);
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

            $course = null;
            try {
                $course = $this->courseModel->getCourse($id);
            } catch (\Exception $e) {
                throw new \Exception('Course not found');
            }

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
                'code' => filter_input(INPUT_POST, 'code', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'credits' => filter_input(INPUT_POST, 'credits', FILTER_VALIDATE_INT),
                'category' => filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'instructor_name' => filter_input(INPUT_POST, 'instructor_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'max_students' => filter_input(INPUT_POST, 'max_students', FILTER_VALIDATE_INT),
                'schedule_days' => filter_input(INPUT_POST, 'schedule_days', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'schedule_time' => filter_input(INPUT_POST, 'schedule_time', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'room' => filter_input(INPUT_POST, 'room', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ];

            // Validate required fields
            $required = ['code', 'name', 'credits', 'category'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    throw new \Exception("Field {$field} is required");
                }
            }

            // Validate numeric fields
            if (!is_numeric($data['credits']) || $data['credits'] <= 0) {
                throw new \Exception('Credits must be a positive number');
            }

            if (!empty($data['max_students']) && (!is_numeric($data['max_students']) || $data['max_students'] <= 0)) {
                throw new \Exception('Maximum students must be a positive number');
            }

            if ($this->courseModel->updateCourse($id, $data)) {
                $this->setFlash('Course updated successfully', 'success');
                $this->redirect('courses/show/' . $id);
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

            if ($this->courseModel->deleteCourse($id)) {
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
            if (!auth()) {
                throw new \Exception('Please login to enroll in courses');
            }

            if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
                throw new \Exception('Invalid course ID');
            }

            $course = null;
            try {
                $course = $this->courseModel->getCourse($id);
            } catch (\Exception $e) {
                throw new \Exception('Course not found');
            }

            if (!$course) {
                throw new \Exception('Course not found');
            }

            // Check available seats
            $availableSeats = $this->courseModel->getAvailableSeats($id);
            if ($availableSeats <= 0) {
                throw new \Exception('No available seats in this course');
            }

            // Enroll student
            if ($this->courseModel->enrollStudent($id, getCurrentUserId())) {
                $this->setFlash('Successfully enrolled in the course', 'success');
                $this->redirect('courses/show/' . $id);
            } else {
                throw new \Exception('Failed to enroll in the course');
            }
        } catch (\Exception $e) {
            $this->setFlash($e->getMessage(), 'danger');
            $this->redirect('courses/show/' . $id);
        }
    }
} 