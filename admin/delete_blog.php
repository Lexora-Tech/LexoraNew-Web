<?php
include("../includes/auth.php");
include("../includes/db.php");

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM blogs WHERE id=$id");

// Redirect to dashboard with a flag
header("Location: dashboard.php?deleted=1");
exit();
?>
