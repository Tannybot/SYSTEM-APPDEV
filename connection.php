<?php
// Railway database configuration
$database_url = getenv('DATABASE_URL');

error_log("DATABASE_URL: " . ($database_url ?: 'NOT SET'));

if ($database_url) {
    // Parse Railway DATABASE_URL (format: mysql://user:password@host:port/database)
    $parsed_url = parse_url($database_url);

    if ($parsed_url && isset($parsed_url['scheme']) && $parsed_url['scheme'] === 'mysql') {
        $host = $parsed_url['host'];
        $username = $parsed_url['user'];
        $password = $parsed_url['pass'];
        $database_name = ltrim($parsed_url['path'], '/');
        $port = $parsed_url['port'] ?: 3306;

        error_log("Parsed DB config - Host: $host, User: $username, DB: $database_name, Port: $port");

        // Create mysqli connection
        $database = new mysqli($host, $username, $password, $database_name, $port);
        if ($database->connect_error) {
            error_log("Database connection failed: " . $database->connect_error);
            die("Connection failed: " . $database->connect_error);
        }
    } else {
        error_log("Invalid DATABASE_URL format: $database_url");
        die("Invalid DATABASE_URL format");
    }
} else {
    // Fallback to individual environment variables or local settings
    $host = getenv('MYSQLHOST') ?: 'localhost';
    $username = getenv('MYSQLUSER') ?: 'root';
    $password = getenv('MYSQLPASSWORD') ?: '';
    $database_name = getenv('MYSQLDATABASE') ?: 'edoc';
    $port = getenv('MYSQLPORT') ?: 3306;

    error_log("Using fallback DB config - Host: $host, User: $username, DB: $database_name, Port: $port");

    // Create mysqli connection
    $database = new mysqli($host, $username, $password, $database_name, $port);
    if ($database->connect_error) {
        error_log("Database connection failed: " . $database->connect_error);
        die("Connection failed: " . $database->connect_error);
    }
}

// Test query to ensure database is accessible
$result = $database->query("SELECT 1");
if (!$result) {
    error_log("Database test query failed: " . $database->error);
    die("Database test failed: " . $database->error);
}
$result->free();
?>

