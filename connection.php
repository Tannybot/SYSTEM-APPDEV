<?php
// Database configuration - supports DATABASE_URL for cloud hosting or individual env vars
$database_url = getenv('DATABASE_URL');

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
    $host = getenv('MYSQLHOST') ?: 'sql210.infinityfree.com';
    $username = getenv('MYSQLUSER') ?: 'if0_40602872';
    $password = getenv('MYSQLPASSWORD') ?: 'daddymyhero123';
    $database_name = getenv('MYSQLDATABASE') ?: 'if0_40602872_XXX';
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

