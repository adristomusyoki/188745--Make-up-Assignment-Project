<?php
require 'auth_session.php';
require_once 'classes/user.php';

if ($_SESSION['user']['UserType'] !== 'Administrator') {
    die('Access denied.');
}

$userObj = new User();
$authors = $userObj->getAuthors();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Manage Authors</title>
    </head>
    <body>
        <h2>Manage Authors</h2>
        <a href="add_author.php">Add Author</a> | <a href="dashboard.php">Back</a>
        <hr>
        <table border="1" cellpadding="6">
<tr><th>ID</th><th>Full Name</th><th>Username</th><th>Email</th><th>Actions</th></tr>
<?php while($row = $authors->fetch_assoc()): ?>
<tr>
    <td><?=htmlspecialchars($row['userId'])?></td>
    <td><?=htmlspecialchars($row['Full_Name'])?></td>
    <td><?=htmlspecialchars($row['User_Name'])?></td>
    <td><?=htmlspecialchars($row['email'])?></td>
    <td>
        <a href="edit_author.php?id=<?=$row['userId']?>">Edit</a> |
        <a href="delete_author.php?id=<?=$row['userId']?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
