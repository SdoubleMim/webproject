<?php

namespace App;

class Route
{
    private static array $routes = [];
    private static string $basePath = '/webproject';

    public static function get(string $path, array $callback)
    {
        self::$routes['GET'][$path] = $callback;
    }

    public static function post(string $path, array $callback)
    {
        self::$routes['POST'][$path] = $callback;
    }

    public static function routes(): array
    {
        return self::$routes;
    }

    public static function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        
        // Remove base path from URI if it exists
        if (strpos($uri, self::$basePath) === 0) {
            $uri = substr($uri, strlen(self::$basePath));
        }
        
        // If URI is empty, set it to '/'
        $uri = $uri ?: '/';
        
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset(self::$routes[$method][$uri])) {
            $callback = self::$routes[$method][$uri];
            $controller = new $callback[0]();
            $action = $callback[1];
            
            return call_user_func([$controller, $action]);
        }

        http_response_code(404);
        require_once __DIR__ . '/../views/errors/404.php';
        return;
    }
} 