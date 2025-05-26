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

    // Retrieve JSON data from POST request
    $jsonData = $_POST['jsonData'] ?? file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    // Check if JSON decoding was successful
    if (json_last_error() !== JSON_ERROR_NONE || empty($data)) {
        sendJsonResponse(['status' => 'error', 'message' => 'Invalid JSON data']);
        exit;
    }

    // Extract data from the request
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
    $createDate = $data['createDate'] ?? date('Y-m-d H:i:s'); // Default to current timestamp if not provided

    // Validate input
    $validationResult = validateSignUpInput($email, $password);
    if ($validationResult['status'] === 'error') {
        sendJsonResponse($validationResult);
        exit;
    }

    // Check if email already exists
    if (emailExists($pdo, $email)) {
        sendJsonResponse(['status' => 'error', 'message' => 'Email already exists']);
        exit;
    }

    // Create user
    $stmt = $pdo->prepare("INSERT INTO users (email, password, created_at) VALUES (?, ?, ?)");
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    if ($stmt->execute([$email, $hashedPassword, $createDate])) {
        // Fetch the newly created user's ID
        $userId = $pdo->lastInsertId();

        // Prepare the response with the same structure as get_user.php
        $newUser = [
            'id' => (int)$userId,
            'email' => $email,
            'created_at' => $createDate
        ];

        sendJsonResponse(['status' => 'success', 'data' => $newUser]);
    } else {
        sendJsonResponse(['status' => 'error', 'message' => 'Failed to create user']);
    }
} catch (Exception $e) {
    sendJsonResponse(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}
?>