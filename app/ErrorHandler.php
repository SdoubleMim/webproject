<?php

namespace App;

class ErrorHandler {
    public static function handleError($error, $viewPath) {
        // Log the error
        error_log($error);
        
        // Set up error variables
        $errorData = [
            'error' => $error,
            'title' => 'Error',
            'enrolledCourses' => [],
            'average' => null
        ];
        
        // Extract variables for the view
        extract($errorData);
        
        // Show error page
        require_once $viewPath . '/error/500.php';
    }
} 