<?php
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");

$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    $conn->query("DELETE FROM service_agreements WHERE id=$id");
}
header("Location: agreements.php?msg=" . urlencode("Agreement deleted"));
exit();
?>