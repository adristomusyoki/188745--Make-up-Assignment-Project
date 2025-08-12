<?php
require 'auth_session.php';
require_once 'classes/user.php';

$userObj = new User();
$uid = $_SESSION['user']['userId'];
$user = $userObj->getById($uid);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'Full_Name' => $_POST['Full_Name'],
        'email' => $_POST['email'],
        'phone_Number' => $_POST['phone_Number'],
        'UserType' => $user['UserType'], // can't change own role here
        'profile_Image' => $_POST['profile_Image'] ?? $user['profile_Image'],
        'Address' => $_POST['Address']
    ];
    $changePwd = !empty($_POST['Password']);
    if ($changePwd) $data['Password'] = $_POST['Password'];

    if ($userObj->update($uid, $data, $changePwd)) {
        // refresh session userdata
        $updated = $userObj->getById($uid);
        unset($updated['Password']);
        $_SESSION['user'] = $updated;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Update failed.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
</head>
<body>
<h2>Update Profile</h2>
<form method="POST">
    <label>Full Name</label><input name="Full_Name" value="<?=htmlspecialchars($user['Full_Name'])?>" required><br>
    <label>Email</label><input name="email" value="<?=htmlspecialchars($user['email'])?>" type="email"><br>
    <label>Phone</label><input name="phone_Number" value="<?=htmlspecialchars($user['phone_Number'])?>"><br>
    <label>New Password (leave blank to keep)</label><input name="Password" type="password"><br>
    <label>Address</label><textarea name="Address"><?=htmlspecialchars($user['Address'])?></textarea><br>
    <button type="submit">Save</button>
</form>
<?php if(!empty($error)) echo "<p>$error</p>"; ?>
</body>
</html>
