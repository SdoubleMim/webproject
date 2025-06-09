<?php

namespace App\Controller;

use App\Database\Database;
use PDO;

class BaseController
{
    protected $db;
    
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    protected function view($name, $data = [])
    {
        extract($data);
        $viewPath = __DIR__ . '/../../views/' . $name . '.php';
        
        if (!file_exists($viewPath)) {
            throw new \Exception("View {$name} not found");
        }
        
        ob_start();
        require $viewPath;
        $content = ob_get_clean();
        return $content;
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

    protected function requireLogin()
    {
        if (!isset($_SESSION['user'])) {
            setFlash('Please login to continue', 'warning');
            $this->redirect('/login');
        }
        return $_SESSION['user'];
    }

    protected function getCurrentUser()
    {
        return $_SESSION['user'] ?? null;
    }
} 