<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config.php';

header('Content-Type: application/json');

$db = get_db();

// Inputs: type (optional), lat/lng/radiusKm (optional)
$type = isset($_GET['type']) ? trim($_GET['type']) : null;
$lat = isset($_GET['lat']) ? floatval($_GET['lat']) : null;
$lng = isset($_GET['lng']) ? floatval($_GET['lng']) : null;
$radiusKm = isset($_GET['radiusKm']) ? floatval($_GET['radiusKm']) : 10.0; // default 10km

$params = [];
$wheres = [];

if ($type) {
    $wheres[] = "`type` = ?";
    $params[] = $type;
}

$distanceSelect = '';
if ($lat !== null && $lng !== null) {
    // Haversine formula to filter by distance
    $distanceSelect = ", (6371 * 2 * ASIN(SQRT(POWER(SIN(RADIANS(? - latitude)/2),2) + COS(RADIANS(latitude)) * COS(RADIANS(?)) * POWER(SIN(RADIANS(? - longitude)/2),2)))) AS distance_km";
}

$sql = "SELECT id, name, `type`, latitude, longitude, address, phone, opening_hours, supplies, updated_at $distanceSelect FROM centers";

if ($lat !== null && $lng !== null) {
    // We'll filter by distance in HAVING after selecting the computed column
}

if (count($wheres) > 0) {
    $sql .= ' WHERE ' . implode(' AND ', $wheres);
}

if ($lat !== null && $lng !== null) {
    $sql .= ' HAVING distance_km <= ?';
}

// Order by distance if available, else latest update
if ($lat !== null && $lng !== null) {
    $sql .= ' ORDER BY distance_km ASC';
} else {
    $sql .= ' ORDER BY updated_at DESC';
}

// Build parameter types and values
$types = '';
$values = [];

// First, add distance calculation parameters (used in SELECT)
if ($lat !== null && $lng !== null) {
    // distanceSelect bind order: (? - latitude), (?) for cos(lat), (? - longitude)
    $types .= 'ddd';
    $values[] = $lat;
    $values[] = $lat; // used in COS(RADIANS(?))
    $values[] = $lng;
}

// Then add WHERE clause parameters
if ($type) { 
    $types .= 's'; 
    $values[] = $type; 
}

// Finally add HAVING clause parameters
if ($lat !== null && $lng !== null) { 
    $types .= 'd'; 
    $values[] = $radiusKm; 
}

$stmt = $db->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Query prepare failed', 'detail' => $db->error]);
    exit;
}

if (strlen($types) > 0) {
    $stmt->bind_param($types, ...$values);
}

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['error' => 'Query execute failed', 'detail' => $stmt->error]);
    exit;
}

$res = $stmt->get_result();
$rows = [];
while ($row = $res->fetch_assoc()) {
    $row['latitude'] = (float)$row['latitude'];
    $row['longitude'] = (float)$row['longitude'];
    if (isset($row['distance_km'])) $row['distance_km'] = (float)$row['distance_km'];
    $rows[] = $row;
}

echo json_encode(['data' => $rows]);

