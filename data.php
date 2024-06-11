<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM notification_data WHERE seen = 0";
$result = $conn->query($sql);

$response = array();
$response['count'] = $result->num_rows;

if ($result->num_rows > 0) {
    $notifications = "";
    while($row = $result->fetch_assoc()) {
        $notifications .= "<p>id: " . $row["id"]. " - Notification: " . $row["description"]. "</p>";
    }
    $response['notifications'] = $notifications;
} else {
    $response['notifications'] = "<p>No new notifications</p>";
}

$conn->close();

echo json_encode($response);
?>
