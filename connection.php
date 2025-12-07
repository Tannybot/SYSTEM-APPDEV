<?php
// Railway database configuration
$host = getenv('MYSQLHOST') ?: 'localhost';
$username = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: '';
$database_name = getenv('MYSQLDATABASE') ?: 'edoc';
$port = getenv('MYSQLPORT') ?: 3306;

// Create connection
$database = new mysqli($host, $username, $password, $database_name, $port);

// Check connection
if ($database->connect_error) {
    die("Connection failed: " . $database->connect_error);
}
?>

