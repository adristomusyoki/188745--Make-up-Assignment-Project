<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="sign1n.css">
</head>
<body>
    <div class="container"> 
        <form method="POST" action="log1n.php">
    <h2>Sign In</h2>
    <label>Username:</label><input type="text" name="username" required>
    <label>Password:</label><input type="password" name="password" required>
    <button type="submit">Login</button>
</form>
</div>
</body>
</html>