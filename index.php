<?php
// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Require composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch (Exception $e) {
    // If .env file doesn't exist, set default values
    $_ENV['DB_HOST'] = 'localhost';
    $_ENV['DB_NAME'] = 'webproject_database';
    $_ENV['DB_USER'] = 'root';
    $_ENV['DB_PASS'] = '';
    $_ENV['APP_URL'] = 'http://localhost/webproject';
    $_ENV['APP_ENV'] = 'development';
}

// Define constants
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define('APP_URL', $_ENV['APP_URL']);
define('APP_ENV', $_ENV['APP_ENV']);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set error handler
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        return false;
    }
    
    $error = [
        'type' => $errno,
        'message' => $errstr,
        'file' => $errfile,
        'line' => $errline
    ];
    
    if (APP_ENV === 'development') {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    } else {
        error_log(json_encode($error));
        require_once __DIR__ . '/views/500.php';
        exit(1);
    }
});

// Set exception handler
set_exception_handler(function($e) {
    $error = [
        'type' => get_class($e),
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ];
    
    if (APP_ENV === 'development') {
        throw $e;
    } else {
        error_log(json_encode($error));
        require_once __DIR__ . '/views/500.php';
        exit(1);
    }
});

// Helper functions
require_once __DIR__ . '/helper/functions.php';
require_once __DIR__ . '/helper/auth.php';

// Load routes
require_once __DIR__ . '/routes/web.php';

// Run the router
App\Route::run(); 