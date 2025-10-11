<?php
class Constants {
    // Base URL configuration
    public static function getBaseUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $script_name = $_SERVER['SCRIPT_NAME'];
        
        // Remove index.php from the path
        $base_path = str_replace('/index.php', '', $script_name);
        return $protocol . '://' . $host . $base_path;
    }
}

// Define global constants
define('BASE_URL', Constants::getBaseUrl());
define('BASE_PATH', __DIR__ . '/..');
?>