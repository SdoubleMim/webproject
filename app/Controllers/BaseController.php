<?php

namespace App\Controllers;

use PDO;
use PDOException;

class BaseController
{
    protected $db;
    
    public function __construct()
    {
        global $db;
        $this->db = $db;
        
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    protected function getCurrentUser()
    {
        if (!isset($_SESSION['user'])) {
            throw new \Exception("User not logged in");
        }
        return $_SESSION['user'];
    }
    
    
    
    
    
    

    
    protected function view($name, $data = [])
    {
        // Extract data to make variables available in view
        extract($data);
        
        // Define the full path to the view file
        $viewPath = __DIR__ . '/../../views/' . $name . '.php';
        
        // Check if view exists
        if (!file_exists($viewPath)) {
            throw new \Exception("View {$name} not found");
        }
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        require $viewPath;
        
        // Get the contents and clean the buffer
        return ob_get_clean();
    }
    
    protected function redirect($path)
    {
        header('Location: ' . getBaseUrl() . $path);
        exit;
    }
    
    protected function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
} 