 <?php
$host = 'localhost';
$db = 'magaqmco_lexoraadmin';
$user = 'magaqmco_lexora';
$pass = 'Lexora12345@#';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>