<?php
require_once "auth_session.php";
require_once "dbc0nnection.php"; // mysqli connection

if (!in_array($current_user_type, ['Administrator', 'Super_User'])) {
    header("Location: dashboard.php");
    exit();
}

$sql = "
SELECT a.article_id, a.article_title, a.article_created_date,
       u.Full_Name AS author_name
FROM articles a
JOIN users u ON a.authorId = u.userId
ORDER BY a.article_created_date DESC
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head><title>Manage Articles</title></head>
<body>
<h2>All Articles</h2>
<table border="1" cellpadding="8">
<tr>
    <th>Title</th>
    <th>Author</th>
    <th>Created</th>
    <th>Actions</th>
</tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($row['article_title']); ?></td>
    <td><?= htmlspecialchars($row['author_name']); ?></td>
    <td><?= $row['article_created_date']; ?></td>
    <td>
        <a href="edit_article.php?id=<?= $row['article_id']; ?>">Edit</a> |
        <a href="delete_article.php?id=<?= $row['article_id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
