<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header("Location: sign1n.php");
    exit();
}

$current_user_id   = $_SESSION['user_id'];
$current_user_type = $_SESSION['user_type']; // 'Super_User', 'Administrator', 'Author'
?>
