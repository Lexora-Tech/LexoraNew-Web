 <?php
$host = 'localhost';
$db = 'lexokbxm_admin';
$user = 'root';
$pass = 'ThikkaMac12345@#';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>