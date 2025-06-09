<?php

namespace App;

class Route
{
    private static $routes = [];
    private static $baseUrl;

    public static function init()
    {
        // Get base URL from environment variable or calculate it
        self::$baseUrl = '/webproject';
        self::$baseUrl = rtrim(self::$baseUrl, '/');
    }

    public static function get($path, $callback, $middleware = null)
    {
        $path = trim($path, '/');
        self::$routes['GET'][$path] = [
            'callback' => $callback,
            'middleware' => $middleware
        ];
    }

    public static function post($path, $callback, $middleware = null)
    {
        $path = trim($path, '/');
        self::$routes['POST'][$path] = [
            'callback' => $callback,
            'middleware' => $middleware
        ];
    }

    public static function run()
    {
        try {
            // Initialize the router
            self::init();

            // Get the request URI and method
            $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
            $method = $_SERVER['REQUEST_METHOD'];
            
            // Remove base path from URI if it exists
            if (strpos($uri, self::$baseUrl) === 0) {
                $uri = substr($uri, strlen(self::$baseUrl));
            }
            
            // Clean up the URI
            $uri = trim($uri, '/');
            $uri = $uri ?: 'home'; // If URI is empty, set it to 'home'

            // Check for exact route match
            if (isset(self::$routes[$method][$uri])) {
                $route = self::$routes[$method][$uri];
                
                // Check middleware
                if ($route['middleware']) {
                    if ($route['middleware'] === 'auth' && !isset($_SESSION['user'])) {
                        setFlash('Please login to continue', 'warning');
                        header('Location: ' . self::$baseUrl . '/login');
                        exit;
                    }
                    if ($route['middleware'] === 'guest' && isset($_SESSION['user'])) {
                        header('Location: ' . self::$baseUrl . '/dashboard');
                        exit;
                    }
                }
                
                $callback = $route['callback'];
                if (is_array($callback)) {
                    $controller = new $callback[0]();
                    $action = $callback[1];
                    return call_user_func([$controller, $action]);
                }
                return call_user_func($callback);
            }

            // Check for dynamic routes with parameters
            foreach (self::$routes[$method] ?? [] as $routePath => $config) {
                // Convert route parameters to regex pattern
                $pattern = preg_replace('/:[a-zA-Z0-9_-]+/', '([^/]+)', $routePath);
                $pattern = '#^' . $pattern . '$#';
                
                if (preg_match($pattern, $uri, $matches)) {
                    // Remove the full match
                    array_shift($matches);
                    
                    // Get parameter names from the route
                    preg_match_all('/:([a-zA-Z0-9_-]+)/', $routePath, $paramNames);
                    $paramNames = $paramNames[1];
                    
                    // Create associative array of parameters
                    $params = array_combine($paramNames, $matches);
                    
                    // Run middleware if exists
                    if ($config['middleware']) {
                        self::runMiddleware($config['middleware']);
                    }
                    
                    $callback = $config['callback'];
                    if (is_array($callback)) {
                        $controller = new $callback[0]();
                        $action = $callback[1];
                        return call_user_func_array([$controller, $action], $params);
                    }
                    return call_user_func_array($callback, $params);
                }
            }

            // 404 Not Found
            self::notFound();
        } catch (\Exception $e) {
            // Log the error
            error_log($e->getMessage());
            
            // Show error page with message in development
            self::serverError(APP_ENV === 'development' ? $e->getMessage() : null);
        }
    }

    private static function runMiddleware($middleware)
    {
        if (is_array($middleware)) {
            foreach ($middleware as $m) {
                self::executeMiddleware($m);
            }
        } else {
            self::executeMiddleware($middleware);
        }
    }

    private static function executeMiddleware($middleware)
    {
        switch ($middleware) {
            case 'auth':
                if (!isset($_SESSION['user'])) {
                    setFlash('Please login to continue', 'warning');
                    redirect('/login');
                }
                break;
            case 'guest':
                if (isset($_SESSION['user'])) {
                    redirect('/dashboard');
                }
                break;
            case 'admin':
                if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
                    setFlash('Unauthorized access', 'danger');
                    redirect('/dashboard');
                }
                break;
            case 'csrf':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (!isset($_POST['csrf_token']) || !validateCsrfToken($_POST['csrf_token'])) {
                        setFlash('Invalid CSRF token', 'danger');
                        redirect('/');
                    }
                }
                break;
        }
    }

    private static function notFound()
    {
        if (!headers_sent()) {
            header("HTTP/1.0 404 Not Found");
        }
        require_once __DIR__ . '/../views/404.php';
        exit();
    }

    private static function serverError($message = null)
    {
        if (!headers_sent()) {
            header("HTTP/1.1 500 Internal Server Error");
        }
        require_once __DIR__ . '/../views/500.php';
        exit();
    }
} 