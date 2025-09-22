<?php
include("../includes/auth.php");
include("../includes/db.php");

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM blogs WHERE id=$id");
header("Location: dashboard.php");
exit();
?>
