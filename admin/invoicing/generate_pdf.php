<?php
include("../../includes/auth.php");
include("../../includes/db.php");
require_once("../../vendor/autoload.php");

if (!isset($_GET['type']) || !isset($_GET['id'])) {
    die("Missing parameters");
}

$type = $_GET['type']; // 'quotation' or 'invoice'
$id = intval($_GET['id']);

// Fetch data based on type
if ($type === 'quotation') {
    $q = mysqli_query($conn, "SELECT q.*, c.name as customer_name, c.email as customer_email, c.phone as customer_phone, c.company as customer_company, c.address as customer_address, c.city as customer_city, c.country as customer_country FROM quotations q LEFT JOIN customers c ON q.customer_id = c.id WHERE q.id=$id");
    $doc = mysqli_fetch_assoc($q);
    if (!$doc)
        die("Quotation not found");
    $doc_number = $doc['quotation_number'];
    $doc_type_label = 'QUOTATION';
    $items_q = mysqli_query($conn, "SELECT * FROM invoice_items WHERE item_type='quotation' AND parent_id=$id ORDER BY sort_order ASC");
}
else {
    $q = mysqli_query($conn, "SELECT i.*, c.name as customer_name, c.email as customer_email, c.phone as customer_phone, c.company as customer_company, c.address as customer_address, c.city as customer_city, c.country as customer_country FROM invoices i LEFT JOIN customers c ON i.customer_id = c.id WHERE i.id=$id");
    $doc = mysqli_fetch_assoc($q);
    if (!$doc)
        die("Invoice not found");
    $doc_number = $doc['invoice_number'];
    $doc_type_label = 'INVOICE';
    $items_q = mysqli_query($conn, "SELECT * FROM invoice_items WHERE item_type='invoice' AND parent_id=$id ORDER BY sort_order ASC");
}

$items = [];
while ($it = mysqli_fetch_assoc($items_q))
    $items[] = $it;

// Get company settings
$cs_q = mysqli_query($conn, "SELECT * FROM company_settings WHERE id=1");
$company = mysqli_fetch_assoc($cs_q);
if (!$company)
    $company = ['company_name' => 'Lexora Tech', 'company_email' => 'info@lexoratech.com', 'company_phone' => '', 'company_address' => '', 'company_website' => 'https://lexoratech.com', 'bank_name' => '', 'bank_account_name' => '', 'bank_account_number' => '', 'bank_branch' => '', 'invoice_footer_note' => 'Thank you for your business!'];

// Generate PDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator('Lexora Tech');
$pdf->SetAuthor($company['company_name']);
$pdf->SetTitle($doc_type_label . ' ' . $doc_number);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(20, 20, 20);
$pdf->AddPage();

// ---- HEADER ----
$pdf->SetFont('helvetica', 'B', 22);
$pdf->SetTextColor(255, 180, 0);
$pdf->Cell(0, 10, $company['company_name'], 0, 1, 'L');
$pdf->SetFont('helvetica', '', 9);
$pdf->SetTextColor(100, 100, 100);
$website = $company['company_website'] ?? '';
$email = $company['company_email'] ?? '';
$phone = $company['company_phone'] ?? '';
$address = $company['company_address'] ?? '';
$headerInfo = [];
if ($website)
    $headerInfo[] = $website;
if ($email)
    $headerInfo[] = $email;
if ($phone)
    $headerInfo[] = $phone;
if ($address)
    $headerInfo[] = $address;
$pdf->Cell(0, 5, implode(' | ', $headerInfo), 0, 1, 'L');
$pdf->Ln(5);

// Doc Type Header
$pdf->SetFont('helvetica', 'B', 16);
$pdf->SetTextColor(30, 41, 59);
$pdf->Cell(85, 10, $doc_type_label, 0, 0, 'L');
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(85, 10, $doc_number, 0, 1, 'R');

$pdf->SetDrawColor(255, 180, 0);
$pdf->SetLineWidth(0.8);
$pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY());
$pdf->Ln(8);

// ---- BILL TO & DOC INFO ----
$pdf->SetFont('helvetica', 'B', 9);
$pdf->SetTextColor(100, 100, 100);
$pdf->Cell(85, 5, 'BILL TO', 0, 0, 'L');
$pdf->Cell(85, 5, strtoupper($doc_type_label) . ' DETAILS', 0, 1, 'R');
$pdf->SetFont('helvetica', 'B', 11);
$pdf->SetTextColor(30, 41, 59);
$cust_name = $doc['customer_name'] ?? 'N/A';
$pdf->Cell(85, 6, $cust_name, 0, 0, 'L');

$date_label = ($type === 'quotation') ? 'Date: ' : 'Issue Date: ';
$issue_date = date("M d, Y", strtotime($doc['issue_date']));
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(85, 6, $date_label . $issue_date, 0, 1, 'R');

$pdf->SetFont('helvetica', '', 10);
$pdf->SetTextColor(80, 80, 80);
if ($doc['customer_email']) {
    $pdf->Cell(85, 5, $doc['customer_email'], 0, 0, 'L');
}
else {
    $pdf->Cell(85, 5, '', 0, 0, 'L');
}

if ($type === 'quotation') {
    $valid = $doc['valid_until'] ? date("M d, Y", strtotime($doc['valid_until'])) : '-';
    $pdf->Cell(85, 5, 'Valid Until: ' . $valid, 0, 1, 'R');
}
else {
    $due = $doc['due_date'] ? date("M d, Y", strtotime($doc['due_date'])) : '-';
    $pdf->Cell(85, 5, 'Due Date: ' . $due, 0, 1, 'R');
}

if ($doc['customer_phone']) {
    $pdf->Cell(85, 5, $doc['customer_phone'], 0, 0, 'L');
}
else {
    $pdf->Cell(85, 5, '', 0, 0, 'L');
}
$pdf->Cell(85, 5, 'Status: ' . ucfirst($doc['status']), 0, 1, 'R');

$custAddr = ($doc['customer_address'] ?? '') . ($doc['customer_city'] ? ', ' . $doc['customer_city'] : '') . ($doc['customer_country'] ? ', ' . $doc['customer_country'] : '');
if ($custAddr) {
    $pdf->Cell(85, 5, $custAddr, 0, 1, 'L');
}

$pdf->Ln(8);

// ---- ITEMS TABLE ----
$pdf->SetFillColor(255, 180, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', 'B', 9);
$headerFill = true;
$pdf->Cell(10, 8, '#', 1, 0, 'C', $headerFill);
$pdf->Cell(60, 8, 'Description', 1, 0, 'L', $headerFill);
$pdf->Cell(20, 8, 'Qty', 1, 0, 'C', $headerFill);
$pdf->Cell(25, 8, 'Price', 1, 0, 'R', $headerFill);
$pdf->Cell(18, 8, 'Tax %', 1, 0, 'C', $headerFill);
$pdf->Cell(20, 8, 'Disc', 1, 0, 'R', $headerFill);
$pdf->Cell(27, 8, 'Total', 1, 1, 'R', $headerFill);

$pdf->SetFont('helvetica', '', 9);
$pdf->SetTextColor(50, 50, 50);
$n = 1;
foreach ($items as $it) {
    $bg = ($n % 2 === 0);
    if ($bg)
        $pdf->SetFillColor(248, 249, 250);
    $pdf->Cell(10, 7, $n, 1, 0, 'C', $bg);
    $pdf->Cell(60, 7, $it['description'], 1, 0, 'L', $bg);
    $pdf->Cell(20, 7, number_format($it['quantity'], 2), 1, 0, 'C', $bg);
    $pdf->Cell(25, 7, number_format($it['unit_price'], 2), 1, 0, 'R', $bg);
    $pdf->Cell(18, 7, number_format($it['tax_rate'], 2) . '%', 1, 0, 'C', $bg);
    $pdf->Cell(20, 7, number_format($it['discount'], 2), 1, 0, 'R', $bg);
    $pdf->Cell(27, 7, number_format($it['line_total'], 2), 1, 1, 'R', $bg);
    $n++;
}

$pdf->Ln(5);

// ---- TOTALS ----
$totalsX = 115;
$pdf->SetFont('helvetica', '', 10);
$pdf->SetTextColor(80, 80, 80);

$pdf->Cell($totalsX, 6, '', 0, 0);
$pdf->Cell(30, 6, 'Subtotal:', 0, 0, 'R');
$pdf->Cell(25, 6, 'LKR ' . number_format($doc['subtotal'], 2), 0, 1, 'R');

$pdf->Cell($totalsX, 6, '', 0, 0);
$pdf->Cell(30, 6, 'Tax:', 0, 0, 'R');
$pdf->Cell(25, 6, 'LKR ' . number_format($doc['tax_amount'], 2), 0, 1, 'R');

$pdf->Cell($totalsX, 6, '', 0, 0);
$pdf->Cell(30, 6, 'Discount:', 0, 0, 'R');
$pdf->Cell(25, 6, '- LKR ' . number_format($doc['discount_amount'], 2), 0, 1, 'R');

// Grand Total
$pdf->SetDrawColor(255, 180, 0);
$pdf->SetLineWidth(0.5);
$pdf->Line($totalsX, $pdf->GetY() + 1, 190, $pdf->GetY() + 1);
$pdf->Ln(2);
$pdf->SetFont('helvetica', 'B', 13);
$pdf->SetTextColor(255, 180, 0);
$pdf->Cell($totalsX, 8, '', 0, 0);
$pdf->Cell(30, 8, 'TOTAL:', 0, 0, 'R');
$pdf->Cell(25, 8, 'LKR ' . number_format($doc['grand_total'], 2), 0, 1, 'R');

// Balance for invoices
if ($type === 'invoice') {
    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetTextColor(16, 185, 129);
    $pdf->Cell($totalsX, 6, '', 0, 0);
    $pdf->Cell(30, 6, 'Paid:', 0, 0, 'R');
    $pdf->Cell(25, 6, 'LKR ' . number_format($doc['amount_paid'], 2), 0, 1, 'R');

    $balance = $doc['grand_total'] - $doc['amount_paid'];
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->SetTextColor(239, 68, 68);
    $pdf->Cell($totalsX, 7, '', 0, 0);
    $pdf->Cell(30, 7, 'Balance:', 0, 0, 'R');
    $pdf->Cell(25, 7, 'LKR ' . number_format($balance, 2), 0, 1, 'R');
}

// ---- BANK DETAILS ----
if ($company['bank_name'] || $company['bank_account_number']) {
    $pdf->Ln(10);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetTextColor(30, 41, 59);
    $pdf->Cell(0, 6, 'BANK DETAILS', 0, 1, 'L');
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->SetLineWidth(0.3);
    $pdf->Line(20, $pdf->GetY(), 100, $pdf->GetY());
    $pdf->Ln(2);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->SetTextColor(80, 80, 80);
    if ($company['bank_name'])
        $pdf->Cell(0, 5, 'Bank: ' . $company['bank_name'], 0, 1);
    if ($company['bank_account_name'])
        $pdf->Cell(0, 5, 'Account Name: ' . $company['bank_account_name'], 0, 1);
    if ($company['bank_account_number'])
        $pdf->Cell(0, 5, 'Account No: ' . $company['bank_account_number'], 0, 1);
    if ($company['bank_branch'])
        $pdf->Cell(0, 5, 'Branch: ' . $company['bank_branch'], 0, 1);
    if ($company['bank_swift'] ?? '')
        $pdf->Cell(0, 5, 'SWIFT: ' . $company['bank_swift'], 0, 1);
}

// ---- NOTES ----
if ($doc['notes']) {
    $pdf->Ln(8);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetTextColor(30, 41, 59);
    $pdf->Cell(0, 6, 'NOTES', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 9);
    $pdf->SetTextColor(80, 80, 80);
    $pdf->MultiCell(0, 5, $doc['notes'], 0, 'L');
}

// ---- FOOTER ----
$footerNote = $company['invoice_footer_note'] ?? '';
if ($footerNote) {
    $pdf->Ln(10);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->SetLineWidth(0.3);
    $pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY());
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'I', 9);
    $pdf->SetTextColor(150, 150, 150);
    $pdf->MultiCell(0, 5, $footerNote, 0, 'C');
}

// Output
$pdf->Output($doc_number . '.pdf', 'I');
?>