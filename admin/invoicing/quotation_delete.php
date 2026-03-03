<?php
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM invoice_items WHERE item_type='quotation' AND parent_id=$id");
    $stmt = $conn->prepare("DELETE FROM quotations WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: quotations.php?msg=" . urlencode("Quotation deleted"));
}
else {
    header("Location: quotations.php");
}
exit();
?>