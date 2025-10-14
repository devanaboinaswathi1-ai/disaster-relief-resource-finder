<?php
// Database configuration and connection helper
// Adjust credentials if your XAMPP setup uses a password

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', ''); // set if you have a root password
define('DB_NAME', 'disaster_relief');

function get_db() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Database connection failed', 'detail' => $mysqli->connect_error]);
        exit;
    }
    $mysqli->set_charset('utf8mb4');
    return $mysqli;
}

// Simple CORS for local dev (adjust origins as needed)
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Credentials: true');
    header('Vary: Origin');
}
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
?>

