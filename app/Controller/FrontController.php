<?php

namespace App\Controller;

class FrontController
{
    private $viewPath;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->viewPath = __DIR__ . '/../../views';
    }

    private function render($view, $data = [])
    {
        extract($data);
        require_once $this->viewPath . '/' . $view . '.php';
    }

    private function setFlash($message, $type = 'info')
    {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
    }

    public function home()
    {
        try {
            $data = [
                'title' => 'Welcome to Student Management System',
                'description' => 'Manage your courses, grades, and schedule efficiently.',
                'features' => [
                    'Course Management' => 'Browse and enroll in available courses',
                    'Grade Tracking' => 'View your academic performance',
                    'Schedule Planning' => 'Organize your weekly schedule',
                    'Dark Theme' => 'Easy on your eyes with dark mode'
                ]
            ];

            $this->render('home', $data);
        } catch (\Exception $e) {
            $this->setFlash($e->getMessage(), 'danger');
            $this->render('home', [
                'title' => 'Welcome to Student Management System',
                'description' => 'Manage your courses, grades, and schedule efficiently.',
                'features' => []
            ]);
        }
    }

    public function error404()
    {
        http_response_code(404);
        $this->render('errors/404', [
            'title' => '404 - Page Not Found',
            'message' => 'The page you are looking for could not be found.'
        ]);
    }

    public function error500()
    {
        http_response_code(500);
        $this->render('errors/500', [
            'title' => '500 - Server Error',
            'message' => 'An internal server error occurred.'
        ]);
    }
} 