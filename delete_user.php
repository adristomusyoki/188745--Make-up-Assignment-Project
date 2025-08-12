<?php
require 'auth_session.php';
require_once 'classes/user.php';

if ($_SESSION['user']['UserType'] !== 'Super_User') {
    die('Access denied.');
}
$id = (int)($_GET['id'] ?? 0);
if ($id === $_SESSION['user']['userId']) {
    die('Cannot delete yourself.');
}
$userObj = new User();
$userObj->delete($id);
header("Location: manage_users.php");
exit();
?>
