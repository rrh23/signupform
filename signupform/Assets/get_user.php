<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include configuration and utility files
require_once 'config.php';
require_once 'utils.php';

try {
    // Get database connection
    $pdo = getDatabaseConnection();

    // Query to fetch all columns from the users table
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();

    // Fetch all rows as an associative array
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Send the users as a JSON response
    sendJsonResponse(['status' => 'success', 'data' => $users]);
} catch (Exception $e) {
    // Handle any errors
    sendJsonResponse(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}
?><?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include configuration and utility files
require_once 'config.php';
require_once 'utils.php';

try {
    // Get database connection
    $pdo = getDatabaseConnection();

    // Query to fetch all columns from the users table
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();

    // Fetch all rows as an associative array
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Send the users as a JSON response
    sendJsonResponse(['status' => 'success', 'data' => $users]);
} catch (Exception $e) {
    // Handle any errors
    sendJsonResponse(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}
?>