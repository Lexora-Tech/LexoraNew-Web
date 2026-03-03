<?php
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");

if (!isset($_GET['id'])) {
    header("Location: invoices.php");
    exit();
}
$payment_id = intval($_GET['id']);
$invoice_id = intval($_GET['invoice_id'] ?? 0);

// Get payment to know the invoice
if (!$invoice_id) {
    $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT invoice_id FROM payments WHERE id=$payment_id"));
    $invoice_id = $p ? intval($p['invoice_id']) : 0;
}

// Delete payment
$stmt = $conn->prepare("DELETE FROM payments WHERE id=?");
$stmt->bind_param("i", $payment_id);
$stmt->execute();
$stmt->close();

// Recalculate total paid
if ($invoice_id) {
    $paid_q = mysqli_query($conn, "SELECT SUM(amount) as total_paid FROM payments WHERE invoice_id=$invoice_id");
    $total_paid = floatval(mysqli_fetch_assoc($paid_q)['total_paid'] ?? 0);
    $conn->query("UPDATE invoices SET amount_paid=$total_paid WHERE id=$invoice_id");

    // Recalculate status
    $inv = mysqli_fetch_assoc(mysqli_query($conn, "SELECT grand_total, status FROM invoices WHERE id=$invoice_id"));
    if ($inv && $inv['status'] !== 'cancelled') {
        if ($total_paid >= floatval($inv['grand_total'])) {
            $conn->query("UPDATE invoices SET status='paid' WHERE id=$invoice_id");
        }
        elseif ($total_paid > 0) {
            $conn->query("UPDATE invoices SET status='partial' WHERE id=$invoice_id");
        }
        else {
            $conn->query("UPDATE invoices SET status='sent' WHERE id=$invoice_id");
        }
    }
    header("Location: add_payment.php?invoice_id=$invoice_id&msg=" . urlencode("Payment deleted"));
}
else {
    header("Location: invoices.php?msg=" . urlencode("Payment deleted"));
}
exit();
?>