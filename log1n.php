<?php
require_once 'dbc0nnection.php';
session_start();

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    echo "Please provide both username and password.";
    exit();
}

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $mysqli->prepare("SELECT * FROM users WHERE User_Name = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['Password'])) {
    $_SESSION['user'] = $user;
    header("Location: dashboard.php");
    exit();
} else {
    echo "Invalid credentials.";
}
?>
