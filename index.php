<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Route;
use App\Controller\AuthController;
use App\Controller\FrontController;
use App\Controller\UserController;

// Start session
session_start();

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

// Define routes
Route::get('/', [FrontController::class, 'index']);
Route::get('/login', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);

// Route::get('/students', [UserController::class, 'index']);
// Route::get('/students/create', [UserController::class, 'create']);
// Route::post('/students/store', [UserController::class, 'store']);
// Route::get('/students/edit/{id}', [UserController::class, 'edit']);
// Route::post('/students/update/{id}', [UserController::class, 'update']);
// Route::get('/students/delete/{id}', [UserController::class, 'delete']);
// 
// Dispatch the route
Route::dispatch(); 