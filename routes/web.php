<?php

use App\Route;
use App\Controller\AuthController;
use App\Controller\FrontController;
use App\Controller\CourseController;
use App\Controller\DashboardController;
use App\Controller\StudentController;
use App\Controller\GradeController;
use App\Controller\ScheduleController;

// Front Controller routes
Route::get('', [FrontController::class, 'home']);
Route::get('home', [FrontController::class, 'home']);

// Auth routes
Route::get('login', [AuthController::class, 'loginForm'], 'guest');
Route::post('login', [AuthController::class, 'login'], ['guest', 'csrf']);
Route::get('register', [AuthController::class, 'registerForm'], 'guest');
Route::post('register', [AuthController::class, 'register'], ['guest', 'csrf']);
Route::get('logout', [AuthController::class, 'logout'], 'auth');

// Dashboard routes
Route::get('dashboard', [DashboardController::class, 'index'], 'auth');

// Course routes
Route::get('courses', [CourseController::class, 'index'], 'auth');
Route::get('courses/create', [CourseController::class, 'create'], ['auth', 'admin']);
Route::post('courses/create', [CourseController::class, 'store'], ['auth', 'admin', 'csrf']);
Route::get('courses/show/:id', [CourseController::class, 'show'], 'auth');
Route::get('courses/edit/:id', [CourseController::class, 'edit'], ['auth', 'admin']);
Route::post('courses/edit/:id', [CourseController::class, 'update'], ['auth', 'admin', 'csrf']);
Route::post('courses/delete/:id', [CourseController::class, 'delete'], ['auth', 'admin', 'csrf']);
Route::post('courses/enroll/:id', [CourseController::class, 'enroll'], ['auth', 'csrf']);
Route::post('courses/drop/:id', [CourseController::class, 'drop'], ['auth', 'csrf']);

// Student routes
Route::get('students', [StudentController::class, 'index'], ['auth', 'admin']);
Route::get('students/show/:id', [StudentController::class, 'show'], 'auth');
Route::get('students/edit/:id', [StudentController::class, 'edit'], 'auth');
Route::post('students/edit/:id', [StudentController::class, 'update'], ['auth', 'csrf']);

// Grade routes
Route::get('grades', [GradeController::class, 'index'], 'auth');
Route::get('grades/all', [GradeController::class, 'allGrades'], ['auth', 'admin']);
Route::post('grades/update', [GradeController::class, 'updateGrade'], ['auth', 'admin', 'csrf']);

// Schedule routes
Route::get('schedule', [ScheduleController::class, 'index'], 'auth'); 