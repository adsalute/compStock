<?php
$conn = new mysqli("localhost", "root", "0bo9okdki.o8;k,,nf", "it_stock");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
