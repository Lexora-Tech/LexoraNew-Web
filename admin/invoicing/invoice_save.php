<?php
include("../../includes/auth.php");
include("../../includes/db.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: invoices.php");
    exit();
}

$customer_id = intval($_POST['customer_id']);
$issue_date = mysqli_real_escape_string($conn, $_POST['issue_date']);
$due_date = mysqli_real_escape_string($conn, $_POST['due_date'] ?? '');
$status = mysqli_real_escape_string($conn, $_POST['status']);
$payment_terms = mysqli_real_escape_string($conn, $_POST['payment_terms'] ?? '');
$notes = mysqli_real_escape_string($conn, $_POST['notes'] ?? '');
$subtotal = floatval($_POST['subtotal'] ?? 0);
$tax_amount = floatval($_POST['tax_amount'] ?? 0);
$discount_amount = floatval($_POST['discount_amount'] ?? 0);
$grand_total = floatval($_POST['grand_total'] ?? 0);
$amount_paid = floatval($_POST['amount_paid'] ?? 0);

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("UPDATE invoices SET customer_id=?, issue_date=?, due_date=?, status=?, payment_terms=?, notes=?, subtotal=?, tax_amount=?, discount_amount=?, grand_total=?, amount_paid=? WHERE id=?");
    $stmt->bind_param("isssssdddddi", $customer_id, $issue_date, $due_date, $status, $payment_terms, $notes, $subtotal, $tax_amount, $discount_amount, $grand_total, $amount_paid, $id);
    $stmt->execute();
    $stmt->close();
    $conn->query("DELETE FROM invoice_items WHERE item_type='invoice' AND parent_id=$id");
}
else {
    $prefix = 'INV';
    $dateStr = date('Ymd');
    $countQ = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM invoices WHERE invoice_number LIKE '{$prefix}-{$dateStr}%'");
    $countRow = mysqli_fetch_assoc($countQ);
    $seq = str_pad($countRow['cnt'] + 1, 4, '0', STR_PAD_LEFT);
    $invoice_number = "{$prefix}-{$dateStr}-{$seq}";

    $stmt = $conn->prepare("INSERT INTO invoices (invoice_number, customer_id, status, issue_date, due_date, subtotal, tax_amount, discount_amount, grand_total, amount_paid, payment_terms, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssdddddss", $invoice_number, $customer_id, $status, $issue_date, $due_date, $subtotal, $tax_amount, $discount_amount, $grand_total, $amount_paid, $payment_terms, $notes);
    $stmt->execute();
    $id = $stmt->insert_id;
    $stmt->close();
}

if (isset($_POST['items']) && is_array($_POST['items'])) {
    $sort = 0;
    foreach ($_POST['items'] as $item) {
        $desc = mysqli_real_escape_string($conn, $item['description'] ?? '');
        $qty = floatval($item['quantity'] ?? 1);
        $price = floatval($item['unit_price'] ?? 0);
        $tax_r = floatval($item['tax_rate'] ?? 0);
        $disc = floatval($item['discount'] ?? 0);
        $line_total = ($qty * $price) + ($qty * $price * $tax_r / 100) - $disc;

        $stmt = $conn->prepare("INSERT INTO invoice_items (item_type, parent_id, description, quantity, unit_price, tax_rate, discount, line_total, sort_order) VALUES ('invoice', ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isdddddi", $id, $desc, $qty, $price, $tax_r, $disc, $line_total, $sort);
        $stmt->execute();
        $stmt->close();
        $sort++;
    }
}

$msg = isset($_POST['id']) ? "Invoice updated successfully" : "Invoice created successfully";
header("Location: invoices.php?msg=" . urlencode($msg));
exit();
?>