<?php
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");

if (!isset($_GET['id'])) {
    header("Location: quotations.php");
    exit();
}
$quo_id = intval($_GET['id']);

// Get quotation data
$q = mysqli_query($conn, "SELECT * FROM quotations WHERE id=$quo_id");
$quotation = mysqli_fetch_assoc($q);
if (!$quotation) {
    header("Location: quotations.php");
    exit();
}

// Generate invoice number
$prefix = 'INV';
$dateStr = date('Ymd');
$countQ = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM invoices WHERE invoice_number LIKE '{$prefix}-{$dateStr}%'");
$countRow = mysqli_fetch_assoc($countQ);
$seq = str_pad($countRow['cnt'] + 1, 4, '0', STR_PAD_LEFT);
$invoice_number = "{$prefix}-{$dateStr}-{$seq}";

// Create invoice from quotation
$stmt = $conn->prepare("INSERT INTO invoices (invoice_number, quotation_id, customer_id, status, issue_date, due_date, subtotal, tax_amount, discount_amount, grand_total, currency, payment_terms, notes) VALUES (?, ?, ?, 'draft', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("siiddddsss",
    $invoice_number, $quo_id, $quotation['customer_id'],
    $quotation['subtotal'], $quotation['tax_amount'], $quotation['discount_amount'], $quotation['grand_total'],
    $quotation['currency'], $quotation['payment_terms'], $quotation['notes']
);
$stmt->execute();
$inv_id = $stmt->insert_id;
$stmt->close();

// Copy line items
$items_q = mysqli_query($conn, "SELECT * FROM invoice_items WHERE item_type='quotation' AND parent_id=$quo_id ORDER BY sort_order ASC");
while ($it = mysqli_fetch_assoc($items_q)) {
    $stmt = $conn->prepare("INSERT INTO invoice_items (item_type, parent_id, description, quantity, unit_price, tax_rate, discount, line_total, sort_order) VALUES ('invoice', ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isdddddi", $inv_id, $it['description'], $it['quantity'], $it['unit_price'], $it['tax_rate'], $it['discount'], $it['line_total'], $it['sort_order']);
    $stmt->execute();
    $stmt->close();
}

// Mark quotation as converted
$conn->query("UPDATE quotations SET status='converted' WHERE id=$quo_id");

header("Location: invoices.php?msg=" . urlencode("Invoice $invoice_number created from quotation"));
exit();
?>