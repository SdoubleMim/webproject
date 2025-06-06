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

/**
 * Check if a user is logged in
 * @return bool
 */
function auth() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if the logged-in user is an admin
 * @return bool
 */
function isAdmin() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Get the current logged-in user's ID
 * @return int|null
 */
function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get the current logged-in user's role
 * @return string|null
 */
function getCurrentUserRole() {
    return $_SESSION['user_role'] ?? null;
}

/**
 * Get base URL of the application
 * @return string
 */
function getBaseUrl() {
    return '/webproject';
}

/**
 * Format a date string
 * @param string $date
 * @param string $format
 * @return string
 */
function formatDate($date, $format = 'Y-m-d H:i:s') {
    return date($format, strtotime($date));
}

/**
 * Escape HTML special characters
 * @param string $string
 * @return string
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Check if the current request is POST
 * @return bool
 */
function isPost() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

/**
 * Check if the current request is GET
 * @return bool
 */
function isGet() {
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

/**
 * Set flash message
 * @param string $message
 * @param string $type
 * @return void
 */
function setFlash($message, $type = 'info') {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
}

/**
 * Get flash message
 * @return array|null
 */
function getFlash() {
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

/**
 * Check if string contains only alphanumeric characters
 * @param string $string
 * @return bool
 */
function isAlphanumeric($string) {
    return ctype_alnum($string);
}

/**
 * Generate CSRF token
 * @return string
 */
function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 * @param string $token
 * @return bool
 */
function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Get CSRF token field
 * @return string
 */
function csrfField() {
    return '<input type="hidden" name="csrf_token" value="' . generateCsrfToken() . '">';
}

/**
 * Check if the current user can perform an action
 * @param string $action
 * @param mixed $resource
 * @return bool
 */
function can($action, $resource = null) {
    $role = getCurrentUserRole();
    
    // Define permissions
    $permissions = [
        'admin' => ['*'],
        'teacher' => ['view', 'create', 'edit', 'delete'],
        'student' => ['view', 'enroll']
    ];

    // Check if role exists and has permissions
    if (!isset($permissions[$role])) {
        return false;
    }

    // Admin can do everything
    if (in_array('*', $permissions[$role])) {
        return true;
    }

    // Check if action is allowed for role
    return in_array($action, $permissions[$role]);
}

/**
 * Format currency
 * @param float $amount
 * @return string
 */
function formatCurrency($amount) {
    return number_format($amount, 2);
}

/**
 * Format file size
 * @param int $bytes
 * @return string
 */
function formatFileSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $i = 0;
    while ($bytes >= 1024 && $i < count($units) - 1) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, 2) . ' ' . $units[$i];
}

/**
 * Get file extension
 * @param string $filename
 * @return string
 */
function getFileExtension($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

/**
 * Check if file extension is allowed
 * @param string $filename
 * @param array $allowedExtensions
 * @return bool
 */
function isAllowedFileExtension($filename, $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx']) {
    return in_array(getFileExtension($filename), $allowedExtensions);
}

/**
 * Generate random string
 * @param int $length
 * @return string
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $string;
}

/**
 * Clean input array
 * @param array $data
 * @return array
 */
function cleanInput($data) {
    $clean = [];
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $clean[$key] = cleanInput($value);
        } else {
            $clean[$key] = trim(strip_tags($value));
        }
    }
    return $clean;
}

if (!function_exists('e')) {
    /**
     * Escape HTML entities in a string.
     *
     * @param string $value
     * @return string
     */
    function e($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }
}

if (!function_exists('getBaseUrl')) {
    /**
     * Get the base URL for the application.
     *
     * @return string
     */
    function getBaseUrl()
    {
        return '/webproject';
    }
}

if (!function_exists('auth')) {
    /**
     * Get the authenticated user.
     *
     * @return array|null
     */
    function auth()
    {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }
}

if (!function_exists('isAdmin')) {
    /**
     * Check if the current user is an admin.
     *
     * @return bool
     */
    function isAdmin()
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }
}

if (!function_exists('isTeacher')) {
    /**
     * Check if the current user is a teacher.
     *
     * @return bool
     */
    function isTeacher()
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'teacher';
    }
}

if (!function_exists('isStudent')) {
    /**
     * Check if the current user is a student.
     *
     * @return bool
     */
    function isStudent()
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student';
    }
}

if (!function_exists('getCurrentUserId')) {
    /**
     * Get the current user's ID.
     *
     * @return int|null
     */
    function getCurrentUserId()
    {
        return isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect to a given path.
     *
     * @param string $path
     * @return void
     */
    function redirect($path)
    {
        $baseUrl = getBaseUrl();
        $location = $baseUrl . '/' . ltrim($path, '/');
        header("Location: {$location}");
        exit();
    }
}

if (!function_exists('setFlash')) {
    /**
     * Set a flash message.
     *
     * @param string $message
     * @param string $type
     * @return void
     */
    function setFlash($message, $type = 'info')
    {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
    }
}

if (!function_exists('getFlash')) {
    /**
     * Get and clear the flash message.
     *
     * @return array|null
     */
    function getFlash()
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
    /**
     * Generate a CSRF token.
     *
     * @return string
     */
    function generateCsrfToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('validateCsrfToken')) {
    /**
     * Validate the CSRF token.
     *
     * @param string $token
     * @return bool
     */
    function validateCsrfToken($token)
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}

if (!function_exists('formatDate')) {
    /**
     * Format a date string.
     *
     * @param string $date
     * @param string $format
     * @return string
     */
    function formatDate($date, $format = 'Y-m-d H:i:s')
    {
        return date($format, strtotime($date));
    }
}

if (!function_exists('sanitizeInput')) {
    /**
     * Sanitize user input.
     *
     * @param string $input
     * @return string
     */
    function sanitizeInput($input)
    {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('validateEmail')) {
    /**
     * Validate an email address.
     *
     * @param string $email
     * @return bool
     */
    function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

if (!function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param mixed ...$vars
     * @return void
     */
    function dd(...$vars)
    {
        foreach ($vars as $var) {
            echo '<pre>';
            var_dump($var);
            echo '</pre>';
        }
        exit(1);
    }
} 