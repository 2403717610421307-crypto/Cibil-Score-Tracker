<?php
// Database credentials
define('DB_SERVER', 'localhost'); // e.g., '192.168.1.100' or 'localhost'
define('DB_USERNAME', 'root'); // e.g., 'root'
define('DB_PASSWORD', 'root'); // e.g., 'root'
define('DB_NAME', 'cibil_tracker');
define('DB_PORT', '3306'); // External MySQL port

// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Attempt to connect to MySQL database
try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage(), 3, 'errors.log');
    die("ERROR: Could not connect to the database. Please try again later.");
}
?>