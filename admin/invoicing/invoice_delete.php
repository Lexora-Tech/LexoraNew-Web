<?php
include("../../includes/auth.php");
include("../../includes/db.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM invoice_items WHERE item_type='invoice' AND parent_id=$id");
    $stmt = $conn->prepare("DELETE FROM invoices WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: invoices.php?msg=" . urlencode("Invoice deleted"));
}
else {
    header("Location: invoices.php");
}
exit();
?>