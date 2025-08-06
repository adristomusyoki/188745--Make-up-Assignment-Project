<?php
require_once 'constant.php';

$mysqli = new mysqli(HOST_NAME, DB_USER, DB_PASSWORD, DB_NAME);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
