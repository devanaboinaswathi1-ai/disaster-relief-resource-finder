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

// Build dynamic update query
$updates = [];
$types = '';
$values = [];

$allowedFields = ['name', 'type', 'latitude', 'longitude', 'address', 'phone', 'opening_hours', 'supplies'];

foreach ($allowedFields as $field) {
    if (isset($data[$field])) {
        $updates[] = "`$field` = ?";
        if (in_array($field, ['latitude', 'longitude'])) {
            $types .= 'd';
            $values[] = (float)$data[$field];
        } else {
            $types .= 's';
            $values[] = $data[$field];
        }
    }
}

if (empty($updates)) {
    http_response_code(400);
    echo json_encode(['error' => 'No fields to update']);
    exit;
}

$sql = "UPDATE centers SET " . implode(', ', $updates) . " WHERE id = ?";
$types .= 'i';
$values[] = (int)$data['id'];

$stmt = $db->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Database prepare failed', 'detail' => $db->error]);
    exit;
}

$stmt->bind_param($types, ...$values);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update center', 'detail' => $stmt->error]);
    exit;
}

if ($stmt->affected_rows === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Center not found or no changes made']);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => 'Center updated successfully'
]);
?>