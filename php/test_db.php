<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Database Connection Test</h2>";

// Test 1: Check if we can connect to MySQL
echo "<h3>Test 1: MySQL Connection</h3>";
$mysqli = new mysqli('127.0.0.1', 'root', '');
if ($mysqli->connect_errno) {
    echo "<p style='color:red'>❌ Failed to connect to MySQL: " . $mysqli->connect_error . "</p>";
    exit;
} else {
    echo "<p style='color:green'>✓ Successfully connected to MySQL</p>";
}

// Test 2: Check if database exists
echo "<h3>Test 2: Database Existence</h3>";
$result = $mysqli->query("SHOW DATABASES LIKE 'disaster_relief'");
if ($result->num_rows > 0) {
    echo "<p style='color:green'>✓ Database 'disaster_relief' exists</p>";
} else {
    echo "<p style='color:red'>❌ Database 'disaster_relief' does NOT exist</p>";
    echo "<p><strong>Action needed:</strong> Run the SQL file at db/schema.sql in phpMyAdmin</p>";
    exit;
}

// Test 3: Select the database
echo "<h3>Test 3: Select Database</h3>";
if (!$mysqli->select_db('disaster_relief')) {
    echo "<p style='color:red'>❌ Failed to select database: " . $mysqli->error . "</p>";
    exit;
} else {
    echo "<p style='color:green'>✓ Successfully selected database</p>";
}

// Test 4: Check if centers table exists
echo "<h3>Test 4: Centers Table</h3>";
$result = $mysqli->query("SHOW TABLES LIKE 'centers'");
if ($result->num_rows > 0) {
    echo "<p style='color:green'>✓ Table 'centers' exists</p>";
} else {
    echo "<p style='color:red'>❌ Table 'centers' does NOT exist</p>";
    echo "<p><strong>Action needed:</strong> Run the SQL file at db/schema.sql in phpMyAdmin</p>";
    exit;
}

// Test 5: Check table structure
echo "<h3>Test 5: Table Structure</h3>";
$result = $mysqli->query("DESCRIBE centers");
if ($result) {
    echo "<p style='color:green'>✓ Table structure:</p>";
    echo "<table border='1' cellpadding='5'><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td><td>{$row['Null']}</td><td>{$row['Key']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color:red'>❌ Failed to describe table: " . $mysqli->error . "</p>";
}

// Test 6: Count records
echo "<h3>Test 6: Data Count</h3>";
$result = $mysqli->query("SELECT COUNT(*) as count FROM centers");
if ($result) {
    $row = $result->fetch_assoc();
    $count = $row['count'];
    if ($count > 0) {
        echo "<p style='color:green'>✓ Found {$count} records in centers table</p>";
    } else {
        echo "<p style='color:orange'>⚠ Table exists but has 0 records</p>";
        echo "<p><strong>Suggestion:</strong> Run the SQL files in db/ folder to add sample data</p>";
    }
} else {
    echo "<p style='color:red'>❌ Failed to count records: " . $mysqli->error . "</p>";
}

// Test 7: Test the actual query from get_centers.php
echo "<h3>Test 7: Sample Query</h3>";
$sql = "SELECT id, name, `type`, latitude, longitude, address, phone, opening_hours, supplies, updated_at FROM centers ORDER BY updated_at DESC LIMIT 5";
$result = $mysqli->query($sql);
if ($result) {
    echo "<p style='color:green'>✓ Query executed successfully</p>";
    if ($result->num_rows > 0) {
        echo "<p>Sample records:</p>";
        echo "<table border='1' cellpadding='5'><tr><th>ID</th><th>Name</th><th>Type</th><th>Latitude</th><th>Longitude</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['type']}</td><td>{$row['latitude']}</td><td>{$row['longitude']}</td></tr>";
        }
        echo "</table>";
    }
} else {
    echo "<p style='color:red'>❌ Query failed: " . $mysqli->error . "</p>";
}

echo "<hr>";
echo "<h3>Summary</h3>";
echo "<p>If all tests passed, the database is set up correctly.</p>";
echo "<p>If any tests failed, follow the action items above.</p>";
echo "<p><a href='../index.html'>← Back to Application</a></p>";

$mysqli->close();
?>
