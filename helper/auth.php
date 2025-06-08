<?php

if (!function_exists('auth')) {
    function auth(): ?array
    {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
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

if (!function_exists('isAdmin')) {
    function isAdmin(): bool
    {
        $user = auth();
        return $user && $user['role'] === 'admin';
    }
}

if (!function_exists('isStudent')) {
    function isStudent(): bool
    {
        $user = auth();
        return $user && $user['role'] === 'student';
    }
}

if (!function_exists('requireAuth')) {
    function requireAuth(): void
    {
        if (!auth()) {
            redirect('/login');
        }
    }
}

if (!function_exists('requireAdmin')) {
    function requireAdmin(): void
    {
        requireAuth();
        if (!isAdmin()) {
            redirect('/dashboard');
        }
    }
}

if (!function_exists('requireStudent')) {
    function requireStudent(): void
    {
        requireAuth();
        if (!isStudent()) {
            redirect('/dashboard');
        }
    }
} 