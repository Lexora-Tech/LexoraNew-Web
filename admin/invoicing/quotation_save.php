<?php
include("../../includes/auth.php");
include("../../includes/db.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: quotations.php");
    exit();
}

$customer_id = intval($_POST['customer_id']);
$issue_date = mysqli_real_escape_string($conn, $_POST['issue_date']);
$valid_until = mysqli_real_escape_string($conn, $_POST['valid_until'] ?? '');
$status = mysqli_real_escape_string($conn, $_POST['status']);
$payment_terms = mysqli_real_escape_string($conn, $_POST['payment_terms'] ?? '');
$notes = mysqli_real_escape_string($conn, $_POST['notes'] ?? '');
$subtotal = floatval($_POST['subtotal'] ?? 0);
$tax_amount = floatval($_POST['tax_amount'] ?? 0);
$discount_amount = floatval($_POST['discount_amount'] ?? 0);
$grand_total = floatval($_POST['grand_total'] ?? 0);

if (isset($_POST['id']) && !empty($_POST['id'])) {
    // UPDATE existing quotation
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("UPDATE quotations SET customer_id=?, issue_date=?, valid_until=?, status=?, payment_terms=?, notes=?, subtotal=?, tax_amount=?, discount_amount=?, grand_total=? WHERE id=?");
    $stmt->bind_param("isssssddddi", $customer_id, $issue_date, $valid_until, $status, $payment_terms, $notes, $subtotal, $tax_amount, $discount_amount, $grand_total, $id);
    $stmt->execute();
    $stmt->close();

    // Delete old items and re-insert
    $conn->query("DELETE FROM invoice_items WHERE item_type='quotation' AND parent_id=$id");
}
else {
    // Generate quotation number
    $prefix = 'QUO';
    $dateStr = date('Ymd');
    $countQ = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM quotations WHERE quotation_number LIKE '{$prefix}-{$dateStr}%'");
    $countRow = mysqli_fetch_assoc($countQ);
    $seq = str_pad($countRow['cnt'] + 1, 4, '0', STR_PAD_LEFT);
    $quotation_number = "{$prefix}-{$dateStr}-{$seq}";

    $stmt = $conn->prepare("INSERT INTO quotations (quotation_number, customer_id, status, issue_date, valid_until, subtotal, tax_amount, discount_amount, grand_total, payment_terms, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssdddss", $quotation_number, $customer_id, $status, $issue_date, $valid_until, $subtotal, $tax_amount, $discount_amount, $grand_total, $payment_terms, $notes);
    $stmt->execute();
    $id = $stmt->insert_id;
    $stmt->close();
}

// Insert line items
if (isset($_POST['items']) && is_array($_POST['items'])) {
    $sort = 0;
    foreach ($_POST['items'] as $item) {
        $desc = mysqli_real_escape_string($conn, $item['description'] ?? '');
        $qty = floatval($item['quantity'] ?? 1);
        $price = floatval($item['unit_price'] ?? 0);
        $tax_r = floatval($item['tax_rate'] ?? 0);
        $disc = floatval($item['discount'] ?? 0);
        $line_total = ($qty * $price) + ($qty * $price * $tax_r / 100) - $disc;

        $stmt = $conn->prepare("INSERT INTO invoice_items (item_type, parent_id, description, quantity, unit_price, tax_rate, discount, line_total, sort_order) VALUES ('quotation', ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isddddi", $id, $desc, $qty, $price, $tax_r, $disc, $line_total, $sort);
        $stmt->execute();
        $stmt->close();
        $sort++;
    }
}

$msg = isset($_POST['id']) ? "Quotation updated successfully" : "Quotation created successfully";
header("Location: quotations.php?msg=" . urlencode($msg));
exit();
?>