<?php
require 'auth_session.php';
require_once 'classes/article.php';

if ($_SESSION['user']['UserType'] !== 'Author') {
    die('Access denied.');
}

$articleObj = new Article();
$articles = $articleObj->getAllByAuthor($_SESSION['user']['userId']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Articles</title>
</head>
<body>
<h2>My Articles</h2>
<a href="add_article.php">Add Article</a> | <a href="dashboard.php">Back</a><hr>
<table border="1" cellpadding="6">
<tr><th>ID</th><th>Title</th><th>Created</th><th>Display</th><th>Actions</th></tr>
<?php while($r = $articles->fetch_assoc()): ?>
<tr>
    <td><?=$r['articleId']?></td>
    <td><?=htmlspecialchars($r['article_title'])?></td>
    <td><?=$r['article_created_date']?></td>
    <td><?=$r['article_display']?></td>
    <td>
        <a href="edit_article.php?id=<?=$r['articleId']?>">Edit</a> |
        <a href="delete_article.php?id=<?=$r['articleId']?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
