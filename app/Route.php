<?php

namespace App;

class Route
{
    private static $routes = [];
    private static $baseUrl = '/webproject';

    public static function get($path, $callback)
    {
        self::$routes['GET'][$path] = $callback;
    }

    public static function post($path, $callback)
    {
        self::$routes['POST'][$path] = $callback;
    }

    public static function run()
    {
        try {
            $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
            $method = $_SERVER['REQUEST_METHOD'];
            
            // Remove base path from URI if it exists
            if (strpos($uri, self::$baseUrl) === 0) {
                $uri = substr($uri, strlen(self::$baseUrl));
            }
            
            // If URI is empty or just '/', set it to 'home'
            $uri = $uri ?: 'home';
            $uri = trim($uri, '/');

            // Check for exact route match
            if (isset(self::$routes[$method][$uri])) {
                $callback = self::$routes[$method][$uri];
                if (is_array($callback)) {
                    $controller = new $callback[0]();
                    $action = $callback[1];
                    return call_user_func([$controller, $action]);
                }
                return call_user_func($callback);
            }

            // Check for dynamic routes with parameters
            foreach (self::$routes[$method] ?? [] as $route => $callback) {
                $pattern = "@^" . preg_replace('/\:([a-zA-Z0-9\_\-]+)/', '(?P<\1>[a-zA-Z0-9\-\_]+)', preg_quote($route)) . "$@D";
                
                if (preg_match($pattern, $uri, $matches)) {
                    // Remove the full match from the matches array
                    array_shift($matches);
                    
                    // Extract named parameters
                    $params = array_filter($matches, function($key) {
                        return !is_numeric($key);
                    }, ARRAY_FILTER_USE_KEY);
                    
                    if (is_array($callback)) {
                        $controller = new $callback[0]();
                        $action = $callback[1];
                        return call_user_func_array([$controller, $action], array_values($params));
                    }
                    return call_user_func_array($callback, array_values($params));
                }
            }

            // 404 Not Found
            self::notFound();
        } catch (\Exception $e) {
            // Log the error
            error_log($e->getMessage());
            
            // Show error page
            self::serverError();
        }
    }

    private static function notFound()
    {
        header("HTTP/1.0 404 Not Found");
        require_once __DIR__ . '/../views/404.php';
        exit();
    }

    private static function serverError()
    {
        header("HTTP/1.1 500 Internal Server Error");
        require_once __DIR__ . '/../views/500.php';
        exit();
    }
}

// Front Controller routes
Route::get('', [Controller\FrontController::class, 'home']);
Route::get('home', [Controller\FrontController::class, 'home']);

// Auth routes
Route::get('login', [Controller\AuthController::class, 'loginForm']);
Route::post('login', [Controller\AuthController::class, 'login']);
Route::get('register', [Controller\AuthController::class, 'registerForm']);
Route::post('register', [Controller\AuthController::class, 'register']);
Route::get('logout', [Controller\AuthController::class, 'logout']);

// Course routes
Route::get('courses', [Controller\CourseController::class, 'index']);
Route::get('courses/create', [Controller\CourseController::class, 'create']);
Route::post('courses/create', [Controller\CourseController::class, 'store']);
Route::get('courses/show/:id', [Controller\CourseController::class, 'show']);
Route::get('courses/edit/:id', [Controller\CourseController::class, 'edit']);
Route::post('courses/edit/:id', [Controller\CourseController::class, 'update']);
Route::post('courses/delete/:id', [Controller\CourseController::class, 'delete']);
Route::post('courses/enroll/:id', [Controller\CourseController::class, 'enroll']); 