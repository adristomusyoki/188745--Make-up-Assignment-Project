<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: sign1n.php");
    exit();
}

$user = $_SESSION['user'];
$role = $user['UserType'];

switch ($role) {
    case 'Super_User':
        include 'super_user.php';
        break;
    case 'Administrator':
        include 'admin.php';
        break;
    case 'Author':
        include 'author.php';
        break;
    default:
        echo "Unauthorized access.";
}
?>
