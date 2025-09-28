<?php
$host = 'localhost';
$db = 'blog_system';
$user = 'root';
$pass = 'JapL050514';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>