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
            $path = getBaseUrl() . ($path[0] === '/' ? $path : '/' . $path);
        }
        if (!headers_sent()) {
            header("Location: {$path}");
        }
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
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin(): bool
    {
        $user = auth();
        return $user && $user['role'] === 'admin';
    }
}

if (!function_exists('getCurrentUserId')) {
    function getCurrentUserId(): ?int
    {
        $user = auth();
        return $user ? (int)$user['id'] : null;
    }
}

if (!function_exists('getCurrentUserRole')) {
    function getCurrentUserRole(): ?string
    {
        $user = auth();
        return $user ? $user['role'] : null;
    }
}

if (!function_exists('getBaseUrl')) {
    function getBaseUrl(): string
    {
        static $baseUrl = null;
        if ($baseUrl === null) {
            $baseUrl = '/webproject';
            if (isset($_ENV['APP_URL'])) {
                $parsedUrl = parse_url($_ENV['APP_URL']);
                if (isset($parsedUrl['path'])) {
                    $baseUrl = rtrim($parsedUrl['path'], '/');
                }
            }
        }
        return $baseUrl;
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'Y-m-d H:i:s'): string
    {
        return date($format, strtotime($date));
    }
}

if (!function_exists('e')) {
    function e($value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('isPost')) {
    function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}

if (!function_exists('isGet')) {
    function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
}

if (!function_exists('setFlash')) {
    function setFlash(string $message, string $type = 'info'): void
    {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
    }
}

if (!function_exists('getFlash')) {
    function getFlash(): ?array
    {
        if (isset($_SESSION['message'])) {
            $message = [
                'message' => $_SESSION['message'],
                'type' => $_SESSION['message_type']
            ];
            unset($_SESSION['message'], $_SESSION['message_type']);
            return $message;
        }
        return null;
    }
}

if (!function_exists('generateCsrfToken')) {
    function generateCsrfToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('validateCsrfToken')) {
    function validateCsrfToken($token): bool
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
    }
}

if (!function_exists('can')) {
    function can(string $action, $resource = null): bool
    {
        $role = getCurrentUserRole();
        
        // Define permissions based on roles
        $permissions = [
            'admin' => ['*'],
            'student' => [
                'view-course',
                'enroll-course',
                'view-grades',
                'view-schedule'
            ]
        ];
        
        // Admin can do everything
        if ($role === 'admin') {
            return true;
        }
        
        // Check if role exists and has permissions
        if (isset($permissions[$role])) {
            return in_array($action, $permissions[$role]) || in_array('*', $permissions[$role]);
        }
        
        return false;
    }
}

if (!function_exists('formatCurrency')) {
    function formatCurrency(float $amount): string
    {
        return '$' . number_format($amount, 2);
    }
}

if (!function_exists('formatFileSize')) {
    function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}

if (!function_exists('getFileExtension')) {
    function getFileExtension(string $filename): string
    {
        return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    }
}

if (!function_exists('isAllowedFileExtension')) {
    function isAllowedFileExtension(string $filename, array $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx']): bool
    {
        return in_array(getFileExtension($filename), $allowedExtensions);
    }
}

if (!function_exists('generateRandomString')) {
    function generateRandomString(int $length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('cleanInput')) {
    function cleanInput($data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

if (!function_exists('dd')) {
    function dd(...$vars): void
    {
        foreach ($vars as $var) {
            echo '<pre>';
            var_dump($var);
            echo '</pre>';
        }
        die();
    }
} 