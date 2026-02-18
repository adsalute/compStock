<?php
include ("middleware/db.php");
$room = $_GET['room'];

$stmt = $conn->prepare("
SELECT serial_no, asset_name
FROM assets
WHERE room_code = ?
");

$stmt->bind_param("s",$room);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while($row = $result->fetch_assoc()){
$data[] = $row;
}

echo json_encode($data);
