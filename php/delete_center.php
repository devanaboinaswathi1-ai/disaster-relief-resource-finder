<?php
require_once __DIR__ . '/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || empty($data['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing center ID']);
    exit;
}

$db = get_db();

$sql = "DELETE FROM centers WHERE id = ?";
$stmt = $db->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Database prepare failed', 'detail' => $db->error]);
    exit;
}

$stmt->bind_param('i', $data['id']);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to delete center', 'detail' => $stmt->error]);
    exit;
}

if ($stmt->affected_rows === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Center not found']);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => 'Center deleted successfully'
]);
?>