<?php
// Database configuration - supports DATABASE_URL for cloud hosting or individual env vars
$database_url = getenv('DATABASE_URL');

if ($database_url) {
    // Parse DATABASE_URL (format: mysql://user:password@host:port/database)
    $parsed_url = parse_url($database_url);

    if ($parsed_url && isset($parsed_url['scheme']) && $parsed_url['scheme'] === 'mysql') {
        $host = $parsed_url['host'];
        $username = $parsed_url['user'];
        $password = $parsed_url['pass'];
        $database_name = ltrim($parsed_url['path'], '/');
        $port = $parsed_url['port'] ?: 3306;

        $database = new mysqli($host, $username, $password, $database_name, $port);
        if ($database->connect_error) {
            die("Connection failed. Please ensure MySQL is running.");
        }
    }
    else {
        die("Invalid DATABASE_URL format.");
    }
}
else {
    // Fallback to local XAMPP settings
    $host = getenv('MYSQLHOST') ?: 'localhost';
    $username = getenv('MYSQLUSER') ?: 'root';
    $password = getenv('MYSQLPASSWORD') ?: '';
    $database_name = getenv('MYSQLDATABASE') ?: 'edoc';
    $port = getenv('MYSQLPORT') ?: 3306;

    $database = new mysqli($host, $username, $password, $database_name, $port);
    if ($database->connect_error) {
        die("Connection failed. Please ensure MySQL is running in XAMPP.");
    }
}
?>

