<?php

// Authentication routes
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

// Dashboard
$router->get('/', 'DashboardController@index');
$router->get('/dashboard', 'DashboardController@index');

// Courses
$router->get('/courses', 'CourseController@index');
$router->get('/courses/{id}', 'CourseController@show');
$router->post('/courses/enroll', 'CourseController@enroll');
$router->post('/courses/drop', 'CourseController@drop');

// Schedule
$router->get('/schedule', 'ScheduleController@index');

// Grades
$router->get('/grades', 'GradesController@index');
$router->post('/grades/update', 'GradesController@update');

// Admin routes
if (isAdmin()) {
    $router->get('/courses/create', 'CourseController@create');
    $router->post('/courses/store', 'CourseController@store');
    $router->get('/courses/{id}/edit', 'CourseController@edit');
    $router->post('/courses/{id}/update', 'CourseController@update');
    $router->post('/courses/{id}/delete', 'CourseController@delete');
} 