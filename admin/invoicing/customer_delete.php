<?php
include("../../includes/auth.php");
include("../../includes/db.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM customers WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: customers.php?msg=Customer deleted successfully");
}
else {
    header("Location: customers.php");
}
exit();
?>