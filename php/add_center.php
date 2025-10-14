<?php
header('Content-Type: application/json');
error_reporting(0);

try {
    require_once __DIR__ . '/config.php';
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        die(json_encode(['error' => 'Method not allowed']));
    }
    
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data) {
        http_response_code(400);
        die(json_encode(['error' => 'Invalid JSON input']));
    }
    
    // Validate required fields
    if (empty($data['name']) || empty($data['type']) || !isset($data['latitude']) || !isset($data['longitude'])) {
        http_response_code(400);
        die(json_encode(['error' => 'Missing required fields']));
    }
    
    // Validate type
    $validTypes = array('shelter', 'food', 'medical', 'water');
    if (!in_array($data['type'], $validTypes)) {
        http_response_code(400);
        die(json_encode(['error' => 'Invalid type']));
    }
    
    $db = get_db();
    
    $sql = "INSERT INTO centers (name, `type`, latitude, longitude, address, phone, opening_hours, supplies) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        die(json_encode(['error' => 'Database error', 'detail' => $db->error]));
    }
    
    $name = $data['name'];
    $type = $data['type'];
    $lat = floatval($data['latitude']);
    $lng = floatval($data['longitude']);
    $address = isset($data['address']) ? $data['address'] : '';
    $phone = isset($data['phone']) ? $data['phone'] : '';
    $hours = isset($data['opening_hours']) ? $data['opening_hours'] : '';
    $supplies = isset($data['supplies']) ? $data['supplies'] : '';
    
    $stmt->bind_param('ssddssss', $name, $type, $lat, $lng, $address, $phone, $hours, $supplies);
    
    if (!$stmt->execute()) {
        http_response_code(500);
        die(json_encode(['error' => 'Insert failed', 'detail' => $stmt->error]));
    }
    
    echo json_encode(['success' => true, 'message' => 'Center added', 'id' => $stmt->insert_id]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Exception', 'message' => $e->getMessage()]);
}
?>