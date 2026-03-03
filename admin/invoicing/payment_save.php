<?php
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: invoices.php");
    exit();
}

$invoice_id = intval($_POST['invoice_id']);
$amount = floatval($_POST['amount']);
$payment_date = mysqli_real_escape_string($conn, $_POST['payment_date']);
$payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
$transaction_id = mysqli_real_escape_string($conn, $_POST['transaction_id'] ?? '');
$notes = mysqli_real_escape_string($conn, $_POST['notes'] ?? '');

// Validate invoice exists
$inv = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM invoices WHERE id=$invoice_id"));
if (!$inv) {
    header("Location: invoices.php");
    exit();
}

// Insert payment record
$stmt = $conn->prepare("INSERT INTO payments (invoice_id, amount, payment_date, payment_method, transaction_id, notes) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("idssss", $invoice_id, $amount, $payment_date, $payment_method, $transaction_id, $notes);
$stmt->execute();
$payment_id = $stmt->insert_id;
$stmt->close();

// Recalculate total paid from all payments
$paid_q = mysqli_query($conn, "SELECT SUM(amount) as total_paid FROM payments WHERE invoice_id=$invoice_id");
$total_paid = floatval(mysqli_fetch_assoc($paid_q)['total_paid'] ?? 0);

// Update invoice amount_paid
$conn->query("UPDATE invoices SET amount_paid=$total_paid WHERE id=$invoice_id");

// Auto-determine status based on payment
$grand_total = floatval($inv['grand_total']);
if ($total_paid >= $grand_total) {
    $new_status = 'paid';
}
elseif ($total_paid > 0) {
    $new_status = 'partial';
}
else {
    $new_status = $inv['status']; // keep existing
}

// Only update status if it makes sense (don't override cancelled)
if ($inv['status'] !== 'cancelled') {
    $conn->query("UPDATE invoices SET status='$new_status' WHERE id=$invoice_id");
}

$msg = "Payment of LKR " . number_format($amount, 2) . " recorded";
if ($new_status === 'paid') {
    $msg .= " — Invoice fully paid!";
}
elseif ($new_status === 'partial') {
    $remaining = $grand_total - $total_paid;
    $msg .= " — Balance remaining: LKR " . number_format($remaining, 2);
}

header("Location: add_payment.php?invoice_id=$invoice_id&msg=" . urlencode($msg));
exit();
?>