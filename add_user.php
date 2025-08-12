<?php
require 'auth_session.php';
require_once 'classes/user.php';

if ($_SESSION['user']['UserType'] !== 'Super_User') {
    die('Access denied.');
}

$userObj = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'Full_Name' => $_POST['Full_Name'],
        'email' => $_POST['email'],
        'phone_Number' => $_POST['phone_Number'],
        'User_Name' => $_POST['User_Name'],
        'Password' => $_POST['Password'],
        'UserType' => $_POST['UserType'],
        'profile_Image' => $_POST['profile_Image'] ?? 'default.png',
        'Address' => $_POST['Address']
    ];
    if ($userObj->create($data)) {
        header("Location: manage_users.php");
        exit();
    } else {
        $error = "Create failed.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
</head>
<body>
<h2>Add User</h2>
<form method="POST">
    <label>Full Name</label><input name="Full_Name" required><br>
    <label>Email</label><input name="email" type="email" required><br>
    <label>Phone</label><input name="phone_Number"><br>
    <label>Username</label><input name="User_Name" required><br>
    <label>Password</label><input name="Password" type="password" required><br>
    <label>UserType</label>
    <select name="UserType">
        <option value="Administrator">Administrator</option>
        <option value="Author">Author</option>
    </select><br>
    <label>Address</label><textarea name="Address"></textarea><br>
    <button type="submit">Add</button>
</form>
<?php if(!empty($error)) echo "<p>$error</p>"; ?>
</body>
</html>
