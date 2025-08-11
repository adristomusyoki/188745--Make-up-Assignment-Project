<?php
require_once __DIR__ . '/../classes/user.php';
require_once __DIR__ . '/../classes/dtbs.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$userObj = new User();
$user = $userObj->getByUsername($username);

if ($user && password_verify($password, $user['Password'])) {
    // update AccessTime
    $db = Database::getConnection();
    $stmt = $db->prepare("UPDATE users SET AccessTime = NOW() WHERE userId = ?");
    $stmt->bind_param("i", $user['userId']);
    $stmt->execute();

    // remove password before storing in session for safety
    unset($user['Password']);
    $_SESSION['user'] = $user;
    header("Location: dashboard.php");
    exit();
} else {
    echo "Invalid username or password. <a href='sign1n.php'>Back</a>";
}
?>

