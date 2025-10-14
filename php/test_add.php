<?php
// Simple test to add a center directly
require_once __DIR__ . '/config.php';

header('Content-Type: application/json');

try {
    $db = get_db();
    
    $sql = "INSERT INTO centers (name, `type`, latitude, longitude, address, phone, opening_hours, supplies) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $db->prepare($sql);
    
    $name = "Test Center";
    $type = "shelter";
    $lat = 17.4065;
    $lng = 78.4772;
    $address = "Test Address";
    $phone = "1234567890";
    $hours = "24/7";
    $supplies = "Test supplies";
    
    $stmt->bind_param('ssddssss', $name, $type, $lat, $lng, $address, $phone, $hours, $supplies);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
    } else {
        echo json_encode(['error' => $stmt->error]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
