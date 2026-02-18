<?php
session_start();
require 'db.php';

$user = $_POST['username'];
$pass = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($data && password_verify($pass, $data['password'])) {

    session_regenerate_id(true);

    $_SESSION['user'] = $data['username'];
    $_SESSION['role'] = $data['role'];

    if ($data['role'] == 'admin') {
        header("Location: admin.php");
    } else {
        header("Location: ../main.php");
    }

} else {
    echo "Login ไม่สำเร็จ";
}
