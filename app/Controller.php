<?php

namespace App;

abstract class Controller
{
    protected $viewPath;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->viewPath = __DIR__ . '/../views';
    }

    protected function render($view, $data = [])
    {
        extract($data);
        require_once $this->viewPath . '/' . $view . '.php';
    }

    protected function setFlash($message, $type = 'info')
    {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
    }

    protected function getFlash()
    {
        if (isset($_SESSION['message'])) {
            $message = [
                'message' => $_SESSION['message'],
                'type' => $_SESSION['message_type']
            ];
            unset($_SESSION['message'], $_SESSION['message_type']);
            return $message;
        }
        return null;
    }

    protected function redirect($path)
    {
        $baseUrl = getBaseUrl();
        $location = $baseUrl . '/' . ltrim($path, '/');
        header("Location: {$location}");
        exit();
    }

    protected function validateCsrfToken()
    {
        if (!isset($_POST['csrf_token']) || !validateCsrfToken($_POST['csrf_token'])) {
            $this->setFlash('Invalid CSRF token', 'danger');
            $this->redirect('/');
            exit();
        }
    }

    protected function requireAuth()
    {
        if (!auth()) {
            $this->setFlash('Please login to continue', 'warning');
            $this->redirect('/login');
            exit();
        }
    }

    protected function requireAdmin()
    {
        $this->requireAuth();
        if (!isAdmin()) {
            $this->setFlash('Access denied', 'danger');
            $this->redirect('/');
            exit();
        }
    }

    protected function requireStudent()
    {
        $this->requireAuth();
        if (!isStudent()) {
            $this->setFlash('Access denied', 'danger');
            $this->redirect('/');
            exit();
        }
    }

    protected function validate($data, $rules)
    {
        $errors = [];
        foreach ($rules as $field => $rule) {
            if (strpos($rule, 'required') !== false && (!isset($data[$field]) || trim($data[$field]) === '')) {
                $errors[$field][] = ucfirst($field) . ' is required';
            }
            if (isset($data[$field])) {
                if (strpos($rule, 'email') !== false && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = 'Invalid email format';
                }
                if (strpos($rule, 'min:') !== false) {
                    preg_match('/min:(\d+)/', $rule, $matches);
                    $min = $matches[1];
                    if (strlen($data[$field]) < $min) {
                        $errors[$field][] = ucfirst($field) . ' must be at least ' . $min . ' characters';
                    }
                }
                if (strpos($rule, 'max:') !== false) {
                    preg_match('/max:(\d+)/', $rule, $matches);
                    $max = $matches[1];
                    if (strlen($data[$field]) > $max) {
                        $errors[$field][] = ucfirst($field) . ' must not exceed ' . $max . ' characters';
                    }
                }
                if (strpos($rule, 'numeric') !== false && !is_numeric($data[$field])) {
                    $errors[$field][] = ucfirst($field) . ' must be a number';
                }
            }
        }
        return $errors;
    }
} 