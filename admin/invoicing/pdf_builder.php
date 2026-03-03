<?php
/**
 * Shared PDF Builder for Quotations, Invoices, and Payment Receipts.
 * Usage:
 *   require_once(__DIR__ . '/pdf_builder.php');
 *   $pdf = buildDocumentPDF($conn, 'invoice', $id);     // or 'quotation'
 *   $pdf->Output('filename.pdf', 'I');                   // display in browser
 *   $pdf->Output('/tmp/file.pdf', 'F');                   // save to file
 *
 *   $pdf = buildReceiptPDF($conn, $payment_id);
 *   $pdf->Output('receipt.pdf', 'I');
 */

function buildDocumentPDF($conn, $type, $id)
{
    // Fetch document
    if ($type === 'quotation') {
        $q = mysqli_query($conn, "SELECT q.*, c.name as customer_name, c.email as customer_email, c.phone as customer_phone, c.company as customer_company, c.address as customer_address, c.city as customer_city, c.country as customer_country FROM quotations q LEFT JOIN customers c ON q.customer_id=c.id WHERE q.id=" . intval($id));
        $doc = mysqli_fetch_assoc($q);
        if (!$doc)
            return null;
        $doc_number = $doc['quotation_number'];
        $doc_label = 'QUOTATION';
        $items_q = mysqli_query($conn, "SELECT * FROM invoice_items WHERE item_type='quotation' AND parent_id=" . intval($id) . " ORDER BY sort_order ASC");
    }
    else {
        $q = mysqli_query($conn, "SELECT i.*, c.name as customer_name, c.email as customer_email, c.phone as customer_phone, c.company as customer_company, c.address as customer_address, c.city as customer_city, c.country as customer_country FROM invoices i LEFT JOIN customers c ON i.customer_id=c.id WHERE i.id=" . intval($id));
        $doc = mysqli_fetch_assoc($q);
        if (!$doc)
            return null;
        $doc_number = $doc['invoice_number'];
        $doc_label = 'INVOICE';
        $items_q = mysqli_query($conn, "SELECT * FROM invoice_items WHERE item_type='invoice' AND parent_id=" . intval($id) . " ORDER BY sort_order ASC");
    }

    $items = [];
    while ($it = mysqli_fetch_assoc($items_q))
        $items[] = $it;

    // Get company settings
    $cs_q = mysqli_query($conn, "SELECT * FROM company_settings WHERE id=1");
    $company = mysqli_fetch_assoc($cs_q);
    if (!$company)
        $company = ['company_name' => 'Lexora Tech', 'company_email' => 'info@lexoratech.com', 'company_phone' => '', 'company_address' => '', 'company_website' => 'https://lexoratech.com', 'bank_name' => '', 'bank_account_name' => '', 'bank_account_number' => '', 'bank_branch' => '', 'bank_swift' => '', 'invoice_footer_note' => 'Thank you for your business!'];

    // Build PDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('Lexora Tech');
    $pdf->SetAuthor($company['company_name']);
    $pdf->SetTitle($doc_label . ' ' . $doc_number);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(20, 20, 20);
    $pdf->AddPage();

    // ---- COMPANY HEADER ----
    $pdf->SetFont('helvetica', 'B', 22);
    $pdf->SetTextColor(255, 180, 0);
    $pdf->Cell(0, 10, $company['company_name'], 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 9);
    $pdf->SetTextColor(100, 100, 100);
    $headerInfo = array_filter([$company['company_website'] ?? '', $company['company_email'] ?? '', $company['company_phone'] ?? '', $company['company_address'] ?? '']);
    if ($headerInfo)
        $pdf->Cell(0, 5, implode(' | ', $headerInfo), 0, 1, 'L');
    $pdf->Ln(5);

    // ---- DOC TYPE HEADER ----
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->SetTextColor(30, 41, 59);
    $pdf->Cell(85, 10, $doc_label, 0, 0, 'L');
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
    $pdf->Cell(85, 5, $doc_label . ' DETAILS', 0, 1, 'R');

    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->SetTextColor(30, 41, 59);
    $pdf->Cell(85, 6, $doc['customer_name'] ?? 'N/A', 0, 0, 'L');
    $dateLabel = ($type === 'quotation') ? 'Date: ' : 'Issue Date: ';
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(85, 6, $dateLabel . date("M d, Y", strtotime($doc['issue_date'])), 0, 1, 'R');

    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetTextColor(80, 80, 80);
    $pdf->Cell(85, 5, $doc['customer_email'] ?? '', 0, 0, 'L');
    if ($type === 'quotation') {
        $valid = $doc['valid_until'] ? date("M d, Y", strtotime($doc['valid_until'])) : '-';
        $pdf->Cell(85, 5, 'Valid Until: ' . $valid, 0, 1, 'R');
    }
    else {
        $due = $doc['due_date'] ? date("M d, Y", strtotime($doc['due_date'])) : '-';
        $pdf->Cell(85, 5, 'Due Date: ' . $due, 0, 1, 'R');
    }

    $pdf->Cell(85, 5, $doc['customer_phone'] ?? '', 0, 0, 'L');
    $pdf->Cell(85, 5, 'Status: ' . ucfirst($doc['status']), 0, 1, 'R');

    $custAddr = ($doc['customer_address'] ?? '') . ($doc['customer_city'] ? ', ' . $doc['customer_city'] : '') . ($doc['customer_country'] ? ', ' . $doc['customer_country'] : '');
    if (trim($custAddr, ', '))
        $pdf->Cell(85, 5, $custAddr, 0, 1, 'L');
    $pdf->Ln(8);

    // ---- ITEMS TABLE ----
    $pdf->SetFillColor(255, 180, 0);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->Cell(10, 8, '#', 1, 0, 'C', true);
    $pdf->Cell(60, 8, 'Description', 1, 0, 'L', true);
    $pdf->Cell(20, 8, 'Qty', 1, 0, 'C', true);
    $pdf->Cell(25, 8, 'Price', 1, 0, 'R', true);
    $pdf->Cell(18, 8, 'Tax %', 1, 0, 'C', true);
    $pdf->Cell(20, 8, 'Disc', 1, 0, 'R', true);
    $pdf->Cell(27, 8, 'Total', 1, 1, 'R', true);

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
    $totX = 115;
    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetTextColor(80, 80, 80);
    $pdf->Cell($totX, 6, '', 0, 0);
    $pdf->Cell(30, 6, 'Subtotal:', 0, 0, 'R');
    $pdf->Cell(25, 6, 'LKR ' . number_format($doc['subtotal'], 2), 0, 1, 'R');
    $pdf->Cell($totX, 6, '', 0, 0);
    $pdf->Cell(30, 6, 'Tax:', 0, 0, 'R');
    $pdf->Cell(25, 6, 'LKR ' . number_format($doc['tax_amount'], 2), 0, 1, 'R');
    $pdf->Cell($totX, 6, '', 0, 0);
    $pdf->Cell(30, 6, 'Discount:', 0, 0, 'R');
    $pdf->Cell(25, 6, '- LKR ' . number_format($doc['discount_amount'], 2), 0, 1, 'R');

    $pdf->SetDrawColor(255, 180, 0);
    $pdf->SetLineWidth(0.5);
    $pdf->Line($totX, $pdf->GetY() + 1, 190, $pdf->GetY() + 1);
    $pdf->Ln(2);
    $pdf->SetFont('helvetica', 'B', 13);
    $pdf->SetTextColor(255, 180, 0);
    $pdf->Cell($totX, 8, '', 0, 0);
    $pdf->Cell(30, 8, 'TOTAL:', 0, 0, 'R');
    $pdf->Cell(25, 8, 'LKR ' . number_format($doc['grand_total'], 2), 0, 1, 'R');

    // Balance for invoices
    if ($type === 'invoice') {
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetTextColor(16, 185, 129);
        $pdf->Cell($totX, 6, '', 0, 0);
        $pdf->Cell(30, 6, 'Paid:', 0, 0, 'R');
        $pdf->Cell(25, 6, 'LKR ' . number_format($doc['amount_paid'], 2), 0, 1, 'R');
        $balance = $doc['grand_total'] - $doc['amount_paid'];
        if ($balance > 0) {
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->SetTextColor(239, 68, 68);
            $pdf->Cell($totX, 7, '', 0, 0);
            $pdf->Cell(30, 7, 'Balance:', 0, 0, 'R');
            $pdf->Cell(25, 7, 'LKR ' . number_format($balance, 2), 0, 1, 'R');
        }
    }

    // ---- BANK DETAILS ----
    $bname = $company['bank_name'] ?? '';
    $bnum = $company['bank_account_number'] ?? '';
    if ($bname || $bnum) {
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
        if ($bname)
            $pdf->Cell(0, 5, 'Bank: ' . $bname, 0, 1);
        if ($company['bank_account_name'] ?? '')
            $pdf->Cell(0, 5, 'Account Name: ' . $company['bank_account_name'], 0, 1);
        if ($bnum)
            $pdf->Cell(0, 5, 'Account No: ' . $bnum, 0, 1);
        if ($company['bank_branch'] ?? '')
            $pdf->Cell(0, 5, 'Branch: ' . $company['bank_branch'], 0, 1);
        if ($company['bank_swift'] ?? '')
            $pdf->Cell(0, 5, 'SWIFT: ' . $company['bank_swift'], 0, 1);
    }

    // ---- PAYMENT HISTORY (for invoices) ----
    if ($type === 'invoice') {
        $pay_q = mysqli_query($conn, "SELECT * FROM payments WHERE invoice_id=" . intval($id) . " ORDER BY payment_date ASC");
        if ($pay_q && mysqli_num_rows($pay_q) > 0) {
            $pdf->Ln(8);
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->SetTextColor(30, 41, 59);
            $pdf->Cell(0, 6, 'PAYMENT HISTORY', 0, 1, 'L');
            $pdf->SetDrawColor(200, 200, 200);
            $pdf->Line(20, $pdf->GetY(), 140, $pdf->GetY());
            $pdf->Ln(2);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetFont('helvetica', 'B', 8);
            $pdf->Cell(35, 6, 'Date', 1, 0, 'L', true);
            $pdf->Cell(30, 6, 'Amount', 1, 0, 'R', true);
            $pdf->Cell(30, 6, 'Method', 1, 0, 'C', true);
            $pdf->Cell(45, 6, 'Reference', 1, 1, 'L', true);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->SetTextColor(60, 60, 60);
            while ($p = mysqli_fetch_assoc($pay_q)) {
                $pdf->Cell(35, 5, date("M d, Y", strtotime($p['payment_date'])), 1, 0, 'L');
                $pdf->Cell(30, 5, 'LKR ' . number_format($p['amount'], 2), 1, 0, 'R');
                $pdf->Cell(30, 5, ucfirst(str_replace('_', ' ', $p['payment_method'])), 1, 0, 'C');
                $pdf->Cell(45, 5, $p['transaction_id'] ?? '-', 1, 1, 'L');
            }
        }
    }

    // ---- NOTES ----
    if ($doc['notes'] ?? '') {
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

    return $pdf;
}

/**
 * Build a Payment Receipt PDF
 */
function buildReceiptPDF($conn, $payment_id)
{
    $pq = mysqli_query($conn, "SELECT p.*, i.invoice_number, i.grand_total, i.amount_paid, i.status as inv_status, c.name as customer_name, c.email as customer_email, c.phone as customer_phone, c.company as customer_company, c.address as customer_address FROM payments p JOIN invoices i ON p.invoice_id=i.id LEFT JOIN customers c ON i.customer_id=c.id WHERE p.id=" . intval($payment_id));
    $pay = mysqli_fetch_assoc($pq);
    if (!$pay)
        return null;

    $cs_q = mysqli_query($conn, "SELECT * FROM company_settings WHERE id=1");
    $company = mysqli_fetch_assoc($cs_q);
    if (!$company)
        $company = ['company_name' => 'Lexora Tech', 'company_email' => 'info@lexoratech.com', 'company_phone' => '', 'company_address' => '', 'company_website' => 'https://lexoratech.com', 'invoice_footer_note' => 'Thank you for your payment!'];

    $receipt_no = 'REC-' . str_pad($payment_id, 6, '0', STR_PAD_LEFT);

    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('Lexora Tech');
    $pdf->SetTitle('Payment Receipt ' . $receipt_no);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(20, 20, 20);
    $pdf->AddPage();

    // Header
    $pdf->SetFont('helvetica', 'B', 22);
    $pdf->SetTextColor(255, 180, 0);
    $pdf->Cell(0, 10, $company['company_name'], 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 9);
    $pdf->SetTextColor(100, 100, 100);
    $headerInfo = array_filter([$company['company_website'] ?? '', $company['company_email'] ?? '', $company['company_phone'] ?? '']);
    if ($headerInfo)
        $pdf->Cell(0, 5, implode(' | ', $headerInfo), 0, 1, 'L');
    $pdf->Ln(5);

    // Title
    $pdf->SetFont('helvetica', 'B', 18);
    $pdf->SetTextColor(16, 185, 129);
    $pdf->Cell(0, 10, 'PAYMENT RECEIPT', 0, 1, 'C');
    $pdf->SetDrawColor(16, 185, 129);
    $pdf->SetLineWidth(0.8);
    $pdf->Line(60, $pdf->GetY(), 150, $pdf->GetY());
    $pdf->Ln(8);

    // Receipt info box
    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetTextColor(80, 80, 80);
    $pdf->Cell(45, 7, 'Receipt Number:', 0, 0, 'R');
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetTextColor(30, 41, 59);
    $pdf->Cell(0, 7, $receipt_no, 0, 1, 'L');

    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetTextColor(80, 80, 80);
    $pdf->Cell(45, 7, 'Payment Date:', 0, 0, 'R');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetTextColor(30, 41, 59);
    $pdf->Cell(0, 7, date("M d, Y", strtotime($pay['payment_date'])), 0, 1, 'L');

    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetTextColor(80, 80, 80);
    $pdf->Cell(45, 7, 'Invoice:', 0, 0, 'R');
    $pdf->SetTextColor(30, 41, 59);
    $pdf->Cell(0, 7, $pay['invoice_number'], 0, 1, 'L');

    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetTextColor(80, 80, 80);
    $pdf->Cell(45, 7, 'Payment Method:', 0, 0, 'R');
    $pdf->SetTextColor(30, 41, 59);
    $pdf->Cell(0, 7, ucfirst(str_replace('_', ' ', $pay['payment_method'])), 0, 1, 'L');

    if ($pay['transaction_id']) {
        $pdf->SetTextColor(80, 80, 80);
        $pdf->Cell(45, 7, 'Reference:', 0, 0, 'R');
        $pdf->SetTextColor(30, 41, 59);
        $pdf->Cell(0, 7, $pay['transaction_id'], 0, 1, 'L');
    }
    $pdf->Ln(6);

    // Customer
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->SetTextColor(100, 100, 100);
    $pdf->Cell(0, 5, 'RECEIVED FROM', 0, 1, 'L');
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->SetTextColor(30, 41, 59);
    $pdf->Cell(0, 6, $pay['customer_name'] ?? 'N/A', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetTextColor(80, 80, 80);
    if ($pay['customer_email'])
        $pdf->Cell(0, 5, $pay['customer_email'], 0, 1, 'L');
    if ($pay['customer_phone'])
        $pdf->Cell(0, 5, $pay['customer_phone'], 0, 1, 'L');
    $pdf->Ln(8);

    // Amount box
    $pdf->SetFillColor(16, 185, 129);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 14, 'Amount Received: LKR ' . number_format($pay['amount'], 2), 0, 1, 'C', true);
    $pdf->Ln(8);

    // Summary
    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetTextColor(80, 80, 80);
    $pdf->Cell(85, 7, 'Invoice Total:', 0, 0, 'R');
    $pdf->Cell(85, 7, 'LKR ' . number_format($pay['grand_total'], 2), 0, 1, 'L');
    $pdf->Cell(85, 7, 'Total Paid:', 0, 0, 'R');
    $pdf->SetTextColor(16, 185, 129);
    $pdf->Cell(85, 7, 'LKR ' . number_format($pay['amount_paid'], 2), 0, 1, 'L');
    $balance = $pay['grand_total'] - $pay['amount_paid'];
    $pdf->SetTextColor($balance > 0 ? 239 : 16, $balance > 0 ? 68 : 185, $balance > 0 ? 68 : 129);
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->Cell(85, 7, 'Balance Due:', 0, 0, 'R');
    $pdf->Cell(85, 7, 'LKR ' . number_format(max(0, $balance), 2), 0, 1, 'L');

    // Notes
    if ($pay['notes'] ?? '') {
        $pdf->Ln(8);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetTextColor(30, 41, 59);
        $pdf->Cell(0, 6, 'NOTES', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetTextColor(80, 80, 80);
        $pdf->MultiCell(0, 5, $pay['notes'], 0, 'L');
    }

    // Footer
    $pdf->Ln(15);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY());
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'I', 9);
    $pdf->SetTextColor(150, 150, 150);
    $pdf->MultiCell(0, 5, $company['invoice_footer_note'] ?? 'Thank you for your payment!', 0, 'C');

    return $pdf;
}
?>