<?php

namespace App;

class Auth
{
    public static function user()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }

    public static function check()
    {
        return self::user() !== null;
    }

    public static function id()
    {
        $user = self::user();
        return $user ? $user['id'] : null;
    }

    public static function require()
    {
        if (!self::check()) {
            header('Location: ' . getBaseUrl() . '/login');
            exit;
        }
        return self::user();
    }
} 