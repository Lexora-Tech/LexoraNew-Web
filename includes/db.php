<?php
$host = 'localhost';
$db = 'lexokbxm_admin';
$user = 'lexokbxm_user';
$pass = 'Lexora12345@#';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>