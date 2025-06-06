<?php

if (!function_exists('view')) {
    function view(string $view, array $data = []): void
    {
        extract($data);
        require_once __DIR__ . "/../views/{$view}.php";
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): void
    {
        // Add base path if path doesn't start with http:// or https://
        if (!preg_match('~^https?://~i', $path)) {
            $path = '/webproject' . ($path[0] === '/' ? $path : '/' . $path);
        }
        header("Location: {$path}");
        exit;
    }
}

if (!function_exists('old')) {
    function old(string $key, $default = ''): string
    {
        return $_POST[$key] ?? $default;
    }
}

if (!function_exists('auth')) {
    function auth(): ?array
    {
        return $_SESSION['user'] ?? null;
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
    }
} 