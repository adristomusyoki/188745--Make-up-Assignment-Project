<?php
require 'auth_session.php';
require_once 'classes/article.php';

$articleObj = new Article();
$rows = $articleObj->getLastSix();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Latest Articles</title>
    </head>
    <body>
<h2>Latest 6 Articles</h2>
<a href="dashboard.php">Back</a><hr>
<?php while($r = $rows->fetch_assoc()): ?>
<article>
    <h3><?=htmlspecialchars($r['article_title'])?></h3>
    <p><em>By <?=htmlspecialchars($r['Full_Name'] ?? 'Unknown')?> on <?=$r['article_created_date']?></em></p>
    <div><?=nl2br(htmlspecialchars(substr($r['article_full_text'],0,500)))?>...</div>
    <hr>
</article>
<?php endwhile; ?>
</body>
</html>
