<?php
require_once "auth_session.php";
require_once "dbc0nnection.php";

$article_id = intval($_GET['id'] ?? 0);
if ($article_id <= 0) { die("Invalid ID."); }

// Fetch article to check ownership
$stmt = $conn->prepare("SELECT authorId FROM articles WHERE article_id = ?");
$stmt->bind_param("i", $article_id);
$stmt->execute();
$article = $stmt->get_result()->fetch_assoc();
if (!$article) { die("Not found."); }

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

$del = $conn->prepare("DELETE FROM articles WHERE article_id = ?");
$del->bind_param("i", $article_id);
if ($del->execute()) {
    header("Location: manage_articles.php");
} else {
    echo "Delete failed.";
}
?>
