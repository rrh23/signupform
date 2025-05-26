<?php
// Set headers for JSON and CORS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Accept');

if (!function_exists('sendJsonResponse')) {
    function sendJsonResponse($data) {
        echo json_encode($data);
    }
}

if (!function_exists('getDatabaseConnection')) {
    function getDatabaseConnection() {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
            DB_USER,
            DB_PASS
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}

if (!function_exists('validateSignUpInput')) {
    function validateSignUpInput($email, $password) {
        if (empty($email) || empty($password)) {
            return [
                'status' => 'error',
                'message' => 'Email and password are required'
            ];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'status' => 'error',
                'message' => 'Invalid email format'
            ];
        }

        if (strlen($password) < PASSWORD_MIN_LENGTH) {
            return [
                'status' => 'error',
                'message' => 'Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters long'
            ];
        }

        return ['status' => 'success'];
    }
}

if (!function_exists('emailExists')) {
    function emailExists($pdo, $email) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }
}

if (!function_exists('createUser')) {
    function createUser($pdo, $email, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (email, password, created_at) VALUES (?, ?, NOW())");
        return $stmt->execute([$email, $hashed_password]);
    }
}
?> <?php
// Set headers for JSON and CORS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Accept');

if (!function_exists('sendJsonResponse')) {
    function sendJsonResponse($data) {
        echo json_encode($data);
    }
}

if (!function_exists('getDatabaseConnection')) {
    function getDatabaseConnection() {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
            DB_USER,
            DB_PASS
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}

if (!function_exists('validateSignUpInput')) {
    function validateSignUpInput($email, $password) {
        if (empty($email) || empty($password)) {
            return [
                'status' => 'error',
                'message' => 'Email and password are required'
            ];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'status' => 'error',
                'message' => 'Invalid email format'
            ];
        }

        if (strlen($password) < PASSWORD_MIN_LENGTH) {
            return [
                'status' => 'error',
                'message' => 'Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters long'
            ];
        }

        return ['status' => 'success'];
    }
}

if (!function_exists('emailExists')) {
    function emailExists($pdo, $email) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }
}

if (!function_exists('createUser')) {
    function createUser($pdo, $email, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (email, password, created_at) VALUES (?, ?, NOW())");
        return $stmt->execute([$email, $hashed_password]);
    }
}
?> 