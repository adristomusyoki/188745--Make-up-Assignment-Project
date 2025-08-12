<?php
require 'auth_session.php';
require_once 'classes/user.php';

if ($_SESSION['user']['UserType'] !== 'Super_User') {
    die('Access denied.');
}

$userObj = new User();
$users = $userObj->getAll(true); 

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Manage Users</title>
    </head>
    <body>
<h2>Manage Users</h2>
<a href="add_user.php">Add User</a> | <a href="dashboard.php">Back</a><hr>

<table border="1" cellpadding="6">
<tr><th>ID</th><th>Full Name</th><th>Username</th><th>Email</th><th>UserType</th><th>Actions</th></tr>
<?php while($row = $users->fetch_assoc()): ?>
<tr>
    <td><?=htmlspecialchars($row['userId'])?></td>
    <td><?=htmlspecialchars($row['Full_Name'])?></td>
    <td><?=htmlspecialchars($row['User_Name'])?></td>
    <td><?=htmlspecialchars($row['email'])?></td>
    <td><?=htmlspecialchars($row['UserType'])?></td>
    <td>
        <a href="edit_user.php?id=<?=$row['userId']?>">Edit</a> |
        <a href="delete_user.php?id=<?=$row['userId']?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
