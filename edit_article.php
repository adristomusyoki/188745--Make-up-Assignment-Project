<?php
require_once "auth_session.php";
require_once "dbc0nnection.php";

$article_id = intval($_GET['id'] ?? 0);
if ($article_id <= 0) { die("Invalid ID."); }

// Fetch article
$sql = "SELECT * FROM articles WHERE article_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $article_id);
$stmt->execute();
$article = $stmt->get_result()->fetch_assoc();

if (!$article) {
    die("Article not found.");
}

if ($current_user_type === 'Author' && $article['authorId'] != $current_user_id) {
    die("Permission denied.");
}
if ($current_user_type === 'Administrator') {
    $checkUser = $conn->prepare("SELECT UserType FROM users WHERE userId = ?");
    $checkUser->bind_param("i", $article['authorId']);
    $checkUser->execute();
    $uType = $checkUser->get_result()->fetch_assoc();
    if ($uType['UserType'] === 'Super_User') {
        die("Permission denied.");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $full  = $_POST['full_text'];
    $updateSql = "UPDATE articles SET article_title=?, article_full_text=?, article_last_update=NOW() WHERE article_id=?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssi", $title, $full, $article_id);
    if ($updateStmt->execute()) {
        echo "Article updated.";
    } else {
        echo "Update failed.";
    }
}
?>
<form method="post">
    Title: <input type="text" name="title" value="<?= htmlspecialchars($article['article_title']); ?>"><br>
    Content: <textarea name="full_text"><?= htmlspecialchars($article['article_full_text']); ?></textarea><br>
    <input type="submit" value="Update">
</form>
