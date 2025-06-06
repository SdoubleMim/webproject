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

// Define database constants
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);

// Start session
session_start();

// Helper functions
require_once __DIR__ . '/helper/functions.php';

use App\Route;
use App\Controller\AuthController;
use App\Controller\FrontController;
use App\Controller\CourseController;

// Home routes
Route::get('', [FrontController::class, 'home']);
Route::get('home', [FrontController::class, 'home']);

// Auth routes
Route::get('login', [AuthController::class, 'loginForm']);
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'registerForm']);
Route::post('register', [AuthController::class, 'register']);
Route::get('logout', [AuthController::class, 'logout']);

// Course routes
Route::get('courses', [CourseController::class, 'index']);
Route::get('courses/create', [CourseController::class, 'create']);
Route::post('courses/create', [CourseController::class, 'store']);
Route::get('courses/show/:id', [CourseController::class, 'show']);
Route::get('courses/edit/:id', [CourseController::class, 'edit']);
Route::post('courses/edit/:id', [CourseController::class, 'update']);
Route::post('courses/delete/:id', [CourseController::class, 'delete']);
Route::post('courses/enroll/:id', [CourseController::class, 'enroll']);

// Run the router
Route::run(); 