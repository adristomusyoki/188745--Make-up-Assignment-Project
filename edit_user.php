<?php
require 'auth_session.php';
require_once 'classes/user.php';

if ($_SESSION['user']['UserType'] !== 'Super_User') {
    die('Access denied.');
}

$userObj = new User();
$id = (int)($_GET['id'] ?? 0);
$user = $userObj->getById($id);
if (!$user) die('Not found');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'Full_Name' => $_POST['Full_Name'],
        'email' => $_POST['email'],
        'phone_Number' => $_POST['phone_Number'],
        'UserType' => $_POST['UserType'],
        'profile_Image' => $_POST['profile_Image'] ?? $user['profile_Image'],
        'Address' => $_POST['Address']
    ];
    $changePwd = !empty($_POST['Password']);
    if ($changePwd) $data['Password'] = $_POST['Password'];

    if ($userObj->update($id, $data, $changePwd)) {
        header("Location: manage_users.php");
        exit();
    } else {
        $error = "Update failed.";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit User</title>
    </head>
    <body>
<h2>Edit User: <?=htmlspecialchars($user['User_Name'])?></h2>
<form method="POST">
    <label>Full Name</label><input name="Full_Name" value="<?=htmlspecialchars($user['Full_Name'])?>" required><br>
    <label>Email</label><input name="email" type="email" value="<?=htmlspecialchars($user['email'])?>"><br>
    <label>Phone</label><input name="phone_Number" value="<?=htmlspecialchars($user['phone_Number'])?>"><br>
    <label>Password (leave blank to keep)</label><input name="Password" type="password"><br>
    <label>UserType</label>
    <select name="UserType">
        <option value="Administrator" <?= $user['UserType']=='Administrator'?'selected':''?>>Administrator</option>
        <option value="Author" <?= $user['UserType']=='Author'?'selected':''?>>Author</option>
    </select><br>
    <label>Address</label><textarea name="Address"><?=htmlspecialchars($user['Address'])?></textarea><br>
    <button type="submit">Update</button>
</form>
<?php if(!empty($error)) echo "<p>$error</p>"; ?>
</body>
</html>
