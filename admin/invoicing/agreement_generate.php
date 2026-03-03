<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
 * Auto-generate a Service Agreement from an Invoice
 * Creates a draft agreement pre-filled with invoice data + default clause templates
 */
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");

$invoice_id = intval($_GET['invoice_id'] ?? 0);
if (!$invoice_id) {
    header("Location: invoices.php?msg=" . urlencode("Invalid invoice ID"));
    exit();
}

// Check if agreement already exists for this invoice
$chk = mysqli_query($conn, "SELECT id FROM service_agreements WHERE invoice_id=$invoice_id");
if ($chk && mysqli_num_rows($chk) > 0) {
    $existing = mysqli_fetch_assoc($chk);
    header("Location: agreement_form.php?id=" . $existing['id'] . "&msg=" . urlencode("Agreement already exists for this invoice"));
    exit();
}

// Fetch invoice + customer data
$inv = mysqli_fetch_assoc(mysqli_query($conn, "SELECT i.*, c.name as customer_name, c.email as customer_email, c.phone as customer_phone, c.company as customer_company, c.address as customer_address, c.city as customer_city, c.country as customer_country FROM invoices i LEFT JOIN customers c ON i.customer_id=c.id WHERE i.id=$invoice_id"));
if (!$inv) {
    header("Location: invoices.php?msg=" . urlencode("Invoice not found"));
    exit();
}

// Build scope of services from invoice items
$items_q = mysqli_query($conn, "SELECT * FROM invoice_items WHERE item_type='invoice' AND parent_id=$invoice_id ORDER BY sort_order ASC");
$scopeLines = [];
$n = 1;
while ($it = mysqli_fetch_assoc($items_q)) {
    $cur = $inv['currency'] ?? 'LKR';
    $scopeLines[] = "$n. " . $it['description'] . " - Qty: " . number_format($it['quantity'], 2) . " x " . $cur . " " . number_format($it['unit_price'], 2);
    $n++;
}
$scope = implode("\n", $scopeLines);

// Build payment terms text
$payTerms = "Total Project Cost: " . ($inv['currency'] ?? 'LKR') . " " . number_format($inv['grand_total'], 2) . "\n";
if ($inv['tax_amount'] > 0)
    $payTerms .= "Tax: " . ($inv['currency'] ?? 'LKR') . " " . number_format($inv['tax_amount'], 2) . "\n";
if ($inv['discount_amount'] > 0)
    $payTerms .= "Discount: " . ($inv['currency'] ?? 'LKR') . " " . number_format($inv['discount_amount'], 2) . "\n";
$payTerms .= "\nPayment Terms: " . ($inv['payment_terms'] ?: 'As per invoice');
$payTerms .= "\nDue Date: " . ($inv['due_date'] ? date("F d, Y", strtotime($inv['due_date'])) : 'As per invoice');

// Fetch default clause templates
$defaults = [];
$tq = mysqli_query($conn, "SELECT clause_key, clause_content FROM agreement_templates WHERE is_default=1");
if ($tq) {
    while ($t = mysqli_fetch_assoc($tq)) {
        $defaults[$t['clause_key']] = $t['clause_content'];
    }
}

// Generate agreement number
$dateStr = date('Ymd');
$cntQ = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM service_agreements WHERE agreement_number LIKE 'AGR-{$dateStr}%'");
$cntR = mysqli_fetch_assoc($cntQ);
$seq = str_pad(($cntR['cnt'] ?? 0) + 1, 4, '0', STR_PAD_LEFT);
$agreement_number = "AGR-{$dateStr}-{$seq}";

// Fetch company settings for signatory
$cs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM company_settings WHERE id=1"));

// Prepare all variables (bind_param requires variables by reference)
$effective = $inv['issue_date'] ?? date('Y-m-d');
$startDate = $inv['issue_date'] ?? date('Y-m-d');
$endDate = $inv['due_date'] ?: date('Y-m-d', strtotime('+3 months'));
$compName = $cs['company_name'] ?? 'Lexora Tech';
$compTitle = 'Director';
$custId = intval($inv['customer_id']);
$d_late = isset($defaults['late_payment_policy']) ? $defaults['late_payment_policy'] : '';
$d_conf = isset($defaults['confidentiality_clause']) ? $defaults['confidentiality_clause'] : '';
$d_ip = isset($defaults['ip_clause']) ? $defaults['ip_clause'] : '';
$d_term = isset($defaults['termination_clause']) ? $defaults['termination_clause'] : '';
$d_liab = isset($defaults['liability_clause']) ? $defaults['liability_clause'] : '';
$d_gov = isset($defaults['governing_law']) ? $defaults['governing_law'] : '';
$d_disp = isset($defaults['dispute_resolution']) ? $defaults['dispute_resolution'] : '';
$d_force = isset($defaults['force_majeure']) ? $defaults['force_majeure'] : '';
$d_amend = isset($defaults['amendments_clause']) ? $defaults['amendments_clause'] : '';

// Insert draft agreement
$stmt = $conn->prepare("INSERT INTO service_agreements (agreement_number, invoice_id, customer_id, status, effective_date, project_start_date, project_end_date, scope_of_services, payment_terms_text, late_payment_policy, confidentiality_clause, ip_clause, termination_clause, liability_clause, governing_law, dispute_resolution, force_majeure, amendments_clause, company_signatory_name, company_signatory_title) VALUES (?, ?, ?, 'draft', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("siissssssssssssssss",
    $agreement_number,
    $invoice_id,
    $custId,
    $effective,
    $startDate,
    $endDate,
    $scope,
    $payTerms,
    $d_late,
    $d_conf,
    $d_ip,
    $d_term,
    $d_liab,
    $d_gov,
    $d_disp,
    $d_force,
    $d_amend,
    $compName,
    $compTitle
);
$stmt->execute();
$newId = $stmt->insert_id;
$stmt->close();

header("Location: agreement_form.php?id=$newId&msg=" . urlencode("Agreement $agreement_number generated! Edit and save below."));
exit();
?>