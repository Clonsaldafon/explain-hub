<?php

if (!function_exists('flash')) {
    function flash($key, $value) {
        $_SESSION['_flash'][$key] = $value;
    }
}

if (!function_exists('session')) {
    function session($key = null, $default = null) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (is_null($key)) {
            return $_SESSION;
        }
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $_SESSION[$k] = $v;
            }
            return null;
        }

        if (isset($_SESSION['_flash'][$key])) {
            $value = $_SESSION['_flash'][$key];
            unset($_SESSION['_flash'][$key]);
            return $value;
        }
        
        return $_SESSION[$key] ?? $default;
    }
}