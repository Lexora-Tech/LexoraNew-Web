<?php
/**
 * Premium PDF Builder for Lexora Tech
 * Generates professional quotation/invoice PDFs and payment receipts
 * with company logo, elegant layout, and complete details.
 */

function getLogoPath()
{
    $paths = [
        __DIR__ . '/../../img/logo/logo.png',
        __DIR__ . '/../../img/logo/logo.jpg',
    ];
    foreach ($paths as $p) {
        if (file_exists($p))
            return $p;
    }
    return null;
}

function buildDocumentPDF($conn, $type, $id)
{
    // ─── Fetch data ───
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

    $cs_q = mysqli_query($conn, "SELECT * FROM company_settings WHERE id=1");
    $company = mysqli_fetch_assoc($cs_q);
    if (!$company)
        $company = ['company_name' => 'Lexora Tech', 'company_email' => 'info@lexoratech.com', 'company_phone' => '', 'company_address' => '', 'company_website' => 'https://lexoratech.com', 'bank_name' => '', 'bank_account_name' => '', 'bank_account_number' => '', 'bank_branch' => '', 'bank_swift' => '', 'invoice_footer_note' => 'Thank you for your business!'];

    $currency = $doc['currency'] ?? $company['default_currency'] ?? 'LKR';

    // ─── Create PDF ───
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('Lexora Tech');
    $pdf->SetAuthor($company['company_name']);
    $pdf->SetTitle($doc_label . ' ' . $doc_number);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(0, 0, 0);
    $pdf->SetAutoPageBreak(true, 25);
    $pdf->AddPage();

    // ═══════════════════════════════════════════
    //  GOLD ACCENT BAR AT TOP
    // ═══════════════════════════════════════════
    $pdf->SetFillColor(255, 180, 0);
    $pdf->Rect(0, 0, 210, 4, 'F');

    // ═══════════════════════════════════════════
    //  HEADER: Logo + Company Info + Doc Number
    // ═══════════════════════════════════════════
    $pdf->SetY(12);
    $logo = getLogoPath();
    if ($logo) {
        $pdf->Image($logo, 15, 10, 20, 20, '', '', '', true, 300, '', false, false, 0);
    }

    // Company name next to logo
    $pdf->SetXY($logo ? 38 : 15, 12);
    $pdf->SetFont('helvetica', 'B', 18);
    $pdf->SetTextColor(26, 26, 26);
    $pdf->Cell(80, 8, $company['company_name'], 0, 1, 'L');

    // Company contact line
    $pdf->SetX($logo ? 38 : 15);
    $pdf->SetFont('helvetica', '', 8);
    $pdf->SetTextColor(120, 120, 120);
    $contactParts = array_filter([
        $company['company_email'] ?? '',
        $company['company_phone'] ?? '',
        $company['company_website'] ?? ''
    ]);
    $pdf->Cell(80, 4, implode('  •  ', $contactParts), 0, 1, 'L');

    if ($company['company_address'] ?? '') {
        $pdf->SetX($logo ? 38 : 15);
        $pdf->Cell(80, 4, $company['company_address'], 0, 1, 'L');
    }

    // Document type badge (right side)
    $pdf->SetXY(130, 12);
    $pdf->SetFont('helvetica', 'B', 22);
    $pdf->SetTextColor(255, 180, 0);
    $pdf->Cell(65, 10, $doc_label, 0, 1, 'R');
    $pdf->SetX(130);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetTextColor(80, 80, 80);
    $pdf->Cell(65, 6, '#' . $doc_number, 0, 1, 'R');

    // Status badge
    $statusColors = [
        'draft' => [107, 114, 128], 'sent' => [59, 130, 246], 'paid' => [16, 185, 129],
        'overdue' => [239, 68, 68], 'cancelled' => [239, 68, 68], 'partial' => [245, 158, 11],
        'accepted' => [16, 185, 129], 'rejected' => [239, 68, 68], 'converted' => [139, 92, 246]
    ];
    $sc = $statusColors[$doc['status']] ?? [107, 114, 128];
    $pdf->SetX(130);
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->SetTextColor($sc[0], $sc[1], $sc[2]);
    $statusText = strtoupper($doc['status']);
    $sw = $pdf->GetStringWidth($statusText) + 14;
    $pdf->SetFillColor($sc[0], $sc[1], $sc[2]);
    $pdf->SetAlpha(0.12);
    $pdf->RoundedRect(195 - $sw, $pdf->GetY(), $sw, 7, 2, '1111', 'F');
    $pdf->SetAlpha(1);
    $pdf->Cell(65, 7, $statusText, 0, 1, 'R');

    // ─── Divider ───
    $pdf->SetY(42);
    $pdf->SetDrawColor(230, 230, 230);
    $pdf->SetLineWidth(0.3);
    $pdf->Line(15, 42, 195, 42);
    $pdf->Ln(6);

    // ═══════════════════════════════════════════
    //  BILL TO + DOCUMENT DETAILS (2 columns)
    // ═══════════════════════════════════════════
    $yStart = $pdf->GetY();

    // Left column — Bill To
    $pdf->SetXY(15, $yStart);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetTextColor(255, 180, 0);
    $pdf->Cell(80, 5, 'BILL TO', 0, 1, 'L');
    $pdf->SetX(15);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->SetTextColor(26, 26, 26);
    $pdf->Cell(80, 6, $doc['customer_name'] ?? 'N/A', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 9);
    $pdf->SetTextColor(80, 80, 80);
    if ($doc['customer_company'] ?? '') {
        $pdf->SetX(15);
        $pdf->Cell(80, 5, $doc['customer_company'], 0, 1, 'L');
    }
    if ($doc['customer_email'] ?? '') {
        $pdf->SetX(15);
        $pdf->Cell(80, 5, $doc['customer_email'], 0, 1, 'L');
    }
    if ($doc['customer_phone'] ?? '') {
        $pdf->SetX(15);
        $pdf->Cell(80, 5, $doc['customer_phone'], 0, 1, 'L');
    }
    $addr = trim(($doc['customer_address'] ?? '') . ($doc['customer_city'] ? ', ' . $doc['customer_city'] : '') . ($doc['customer_country'] ? ', ' . $doc['customer_country'] : ''), ', ');
    if ($addr) {
        $pdf->SetX(15);
        $pdf->Cell(80, 5, $addr, 0, 1, 'L');
    }

    // Right column — Doc details
    $pdf->SetXY(120, $yStart);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetTextColor(255, 180, 0);
    $pdf->Cell(75, 5, strtoupper($doc_label) . ' DETAILS', 0, 1, 'L');

    $detailRows = [];
    $detailRows[] = [($type === 'quotation' ? 'Date' : 'Issue Date'), date("M d, Y", strtotime($doc['issue_date']))];
    if ($type === 'quotation' && ($doc['valid_until'] ?? '')) {
        $detailRows[] = ['Valid Until', date("M d, Y", strtotime($doc['valid_until']))];
    }
    elseif ($type === 'invoice' && ($doc['due_date'] ?? '')) {
        $detailRows[] = ['Due Date', date("M d, Y", strtotime($doc['due_date']))];
    }
    if ($doc['payment_terms'] ?? '') {
        $detailRows[] = ['Terms', $doc['payment_terms']];
    }

    foreach ($detailRows as $dr) {
        $pdf->SetXY(120, $pdf->GetY());
        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetTextColor(120, 120, 120);
        $pdf->Cell(30, 5, $dr[0] . ':', 0, 0, 'L');
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetTextColor(26, 26, 26);
        $pdf->Cell(45, 5, $dr[1], 0, 1, 'L');
    }

    $pdf->Ln(8);

    // ═══════════════════════════════════════════
    //  ITEMS TABLE
    // ═══════════════════════════════════════════
    $colW = [10, 65, 18, 25, 15, 18, 25]; // #, Desc, Qty, Price, Tax%, Disc, Total
    $tableX = 15;

    // Table header
    $pdf->SetFillColor(26, 26, 26);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetX($tableX);
    $headers = ['#', 'DESCRIPTION', 'QTY', 'PRICE', 'TAX %', 'DISC', 'TOTAL'];
    $aligns = ['C', 'L', 'C', 'R', 'C', 'R', 'R'];
    for ($i = 0; $i < count($headers); $i++) {
        $pdf->Cell($colW[$i], 9, $headers[$i], 0, 0, $aligns[$i], true);
    }
    $pdf->Ln();

    // Gold underline
    $pdf->SetFillColor(255, 180, 0);
    $pdf->Rect($tableX, $pdf->GetY(), array_sum($colW), 0.6, 'F');
    $pdf->Ln(0.6);

    // Table rows
    $pdf->SetFont('helvetica', '', 9);
    $n = 1;
    foreach ($items as $it) {
        $isEven = ($n % 2 === 0);
        if ($isEven) {
            $pdf->SetFillColor(249, 249, 249);
        }

        $pdf->SetX($tableX);
        $pdf->SetTextColor(120, 120, 120);
        $pdf->Cell($colW[0], 8, $n, 0, 0, 'C', $isEven);
        $pdf->SetTextColor(26, 26, 26);
        $pdf->Cell($colW[1], 8, $it['description'], 0, 0, 'L', $isEven);
        $pdf->SetTextColor(80, 80, 80);
        $pdf->Cell($colW[2], 8, number_format($it['quantity'], 2), 0, 0, 'C', $isEven);
        $pdf->Cell($colW[3], 8, number_format($it['unit_price'], 2), 0, 0, 'R', $isEven);
        $pdf->Cell($colW[4], 8, number_format($it['tax_rate'], 1) . '%', 0, 0, 'C', $isEven);
        $pdf->Cell($colW[5], 8, number_format($it['discount'], 2), 0, 0, 'R', $isEven);
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetTextColor(26, 26, 26);
        $pdf->Cell($colW[6], 8, number_format($it['line_total'], 2), 0, 1, 'R', $isEven);
        $pdf->SetFont('helvetica', '', 9);

        // Row separator
        $pdf->SetDrawColor(240, 240, 240);
        $pdf->Line($tableX, $pdf->GetY(), $tableX + array_sum($colW), $pdf->GetY());
        $n++;
    }

    $pdf->Ln(4);

    // ═══════════════════════════════════════════
    //  TOTALS SECTION (elegant right-aligned box)
    // ═══════════════════════════════════════════
    $totX = 120;
    $valX = 165;
    $totW = 42;
    $lblW = 45;

    // Background box for totals
    $pdf->SetFillColor(249, 249, 249);
    $boxH = ($type === 'invoice') ? 52 : 34;
    $pdf->RoundedRect($totX - 2, $pdf->GetY(), $lblW + $totW + 4, $boxH, 3, '1111', 'F');

    // Subtotal
    $pdf->SetX($totX);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->SetTextColor(120, 120, 120);
    $pdf->Cell($lblW, 7, 'Subtotal', 0, 0, 'R');
    $pdf->SetTextColor(26, 26, 26);
    $pdf->Cell($totW, 7, $currency . ' ' . number_format($doc['subtotal'], 2), 0, 1, 'R');

    // Tax
    $pdf->SetX($totX);
    $pdf->SetTextColor(120, 120, 120);
    $pdf->Cell($lblW, 7, 'Tax', 0, 0, 'R');
    $pdf->SetTextColor(26, 26, 26);
    $pdf->Cell($totW, 7, $currency . ' ' . number_format($doc['tax_amount'], 2), 0, 1, 'R');

    // Discount
    $pdf->SetX($totX);
    $pdf->SetTextColor(120, 120, 120);
    $pdf->Cell($lblW, 7, 'Discount', 0, 0, 'R');
    $pdf->SetTextColor(239, 68, 68);
    $pdf->Cell($totW, 7, '- ' . $currency . ' ' . number_format($doc['discount_amount'], 2), 0, 1, 'R');

    // Gold divider before grand total
    $pdf->SetDrawColor(255, 180, 0);
    $pdf->SetLineWidth(0.6);
    $pdf->Line($totX, $pdf->GetY() + 1, $totX + $lblW + $totW, $pdf->GetY() + 1);
    $pdf->Ln(3);

    // Grand Total
    $pdf->SetX($totX);
    $pdf->SetFont('helvetica', 'B', 13);
    $pdf->SetTextColor(255, 180, 0);
    $pdf->Cell($lblW, 9, 'TOTAL', 0, 0, 'R');
    $pdf->Cell($totW, 9, $currency . ' ' . number_format($doc['grand_total'], 2), 0, 1, 'R');

    // Invoice: Paid + Balance
    if ($type === 'invoice') {
        $pdf->SetX($totX);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetTextColor(16, 185, 129);
        $pdf->Cell($lblW, 7, 'Amount Paid', 0, 0, 'R');
        $pdf->Cell($totW, 7, $currency . ' ' . number_format($doc['amount_paid'], 2), 0, 1, 'R');

        $balance = $doc['grand_total'] - $doc['amount_paid'];
        $pdf->SetX($totX);
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->SetTextColor($balance > 0 ? 239 : 16, $balance > 0 ? 68 : 185, $balance > 0 ? 68 : 129);
        $pdf->Cell($lblW, 7, 'Balance Due', 0, 0, 'R');
        $pdf->Cell($totW, 7, $currency . ' ' . number_format(max(0, $balance), 2), 0, 1, 'R');
    }

    $pdf->Ln(6);

    // ═══════════════════════════════════════════
    //  PAYMENT HISTORY (invoices only)
    // ═══════════════════════════════════════════
    if ($type === 'invoice') {
        $pay_q = mysqli_query($conn, "SELECT * FROM payments WHERE invoice_id=" . intval($id) . " ORDER BY payment_date ASC");
        if ($pay_q && mysqli_num_rows($pay_q) > 0) {
            $pdf->SetX(15);
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->SetTextColor(255, 180, 0);
            $pdf->Cell(10, 5, '', 0, 0); // icon space
            $pdf->Cell(60, 5, 'PAYMENT HISTORY', 0, 1, 'L');
            $pdf->Ln(2);

            // Mini table
            $pdf->SetX(15);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->SetTextColor(80, 80, 80);
            $pdf->Cell(35, 6, '  DATE', 0, 0, 'L', true);
            $pdf->Cell(35, 6, 'AMOUNT', 0, 0, 'R', true);
            $pdf->Cell(35, 6, 'METHOD', 0, 0, 'C', true);
            $pdf->Cell(55, 6, 'REFERENCE', 0, 1, 'L', true);

            $pdf->SetFont('helvetica', '', 8);
            $pdf->SetTextColor(60, 60, 60);
            while ($p = mysqli_fetch_assoc($pay_q)) {
                $pdf->SetX(15);
                $pdf->Cell(35, 5, '  ' . date("M d, Y", strtotime($p['payment_date'])), 0, 0, 'L');
                $pdf->SetTextColor(16, 185, 129);
                $pdf->SetFont('helvetica', 'B', 8);
                $pdf->Cell(35, 5, $currency . ' ' . number_format($p['amount'], 2), 0, 0, 'R');
                $pdf->SetFont('helvetica', '', 8);
                $pdf->SetTextColor(60, 60, 60);
                $pdf->Cell(35, 5, ucfirst(str_replace('_', ' ', $p['payment_method'])), 0, 0, 'C');
                $pdf->Cell(55, 5, $p['transaction_id'] ?: '-', 0, 1, 'L');
            }
            $pdf->Ln(4);
        }
    }

    // ═══════════════════════════════════════════
    //  BANK DETAILS (elegant card)
    // ═══════════════════════════════════════════
    $bname = $company['bank_name'] ?? '';
    $bnum = $company['bank_account_number'] ?? '';
    if ($bname || $bnum) {
        $pdf->SetX(15);
        $bankY = $pdf->GetY();
        $pdf->SetFillColor(249, 249, 249);
        $pdf->RoundedRect(15, $bankY, 85, 36, 3, '1111', 'F');

        $pdf->SetXY(20, $bankY + 3);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetTextColor(255, 180, 0);
        $pdf->Cell(75, 5, 'BANK DETAILS', 0, 1, 'L');

        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetTextColor(60, 60, 60);
        $bankLines = [];
        if ($bname)
            $bankLines[] = ['Bank', $bname];
        if ($company['bank_account_name'] ?? '')
            $bankLines[] = ['Account', $company['bank_account_name']];
        if ($bnum)
            $bankLines[] = ['Account No', $bnum];
        if ($company['bank_branch'] ?? '')
            $bankLines[] = ['Branch', $company['bank_branch']];
        if ($company['bank_swift'] ?? '')
            $bankLines[] = ['SWIFT', $company['bank_swift']];

        foreach ($bankLines as $bl) {
            $pdf->SetX(20);
            $pdf->SetTextColor(120, 120, 120);
            $pdf->Cell(25, 4.5, $bl[0] . ':', 0, 0, 'L');
            $pdf->SetTextColor(26, 26, 26);
            $pdf->SetFont('helvetica', 'B', 8);
            $pdf->Cell(50, 4.5, $bl[1], 0, 1, 'L');
            $pdf->SetFont('helvetica', '', 8);
        }
        $pdf->Ln(max(0, ($bankY + 38) - $pdf->GetY()));
    }

    // ═══════════════════════════════════════════
    //  NOTES
    // ═══════════════════════════════════════════
    if ($doc['notes'] ?? '') {
        $pdf->Ln(2);
        $pdf->SetX(15);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetTextColor(255, 180, 0);
        $pdf->Cell(0, 5, 'NOTES', 0, 1, 'L');
        $pdf->SetX(15);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetTextColor(80, 80, 80);
        $pdf->MultiCell(165, 4, $doc['notes'], 0, 'L');
    }

    // ═══════════════════════════════════════════
    //  FOOTER BAR
    // ═══════════════════════════════════════════
    $footerNote = $company['invoice_footer_note'] ?? '';
    if ($footerNote) {
        $pdf->Ln(8);
        $pdf->SetDrawColor(230, 230, 230);
        $pdf->SetLineWidth(0.3);
        $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
        $pdf->Ln(4);
        $pdf->SetFont('helvetica', 'I', 8);
        $pdf->SetTextColor(160, 160, 160);
        $pdf->MultiCell(0, 4, $footerNote, 0, 'C');
    }

    // Bottom accent bar
    $pageH = $pdf->getPageHeight();
    $pdf->SetFillColor(255, 180, 0);
    $pdf->Rect(0, $pageH - 3, 210, 3, 'F');

    return $pdf;
}


/**
 * ═══════════════════════════════════════════
 *  PAYMENT RECEIPT PDF
 * ═══════════════════════════════════════════
 */
function buildReceiptPDF($conn, $payment_id)
{
    $pq = mysqli_query($conn, "SELECT p.*, i.invoice_number, i.grand_total, i.amount_paid, i.currency, i.status as inv_status, c.name as customer_name, c.email as customer_email, c.phone as customer_phone, c.company as customer_company, c.address as customer_address FROM payments p JOIN invoices i ON p.invoice_id=i.id LEFT JOIN customers c ON i.customer_id=c.id WHERE p.id=" . intval($payment_id));
    $pay = mysqli_fetch_assoc($pq);
    if (!$pay)
        return null;

    $cs_q = mysqli_query($conn, "SELECT * FROM company_settings WHERE id=1");
    $company = mysqli_fetch_assoc($cs_q);
    if (!$company)
        $company = ['company_name' => 'Lexora Tech', 'company_email' => 'info@lexoratech.com', 'company_phone' => '', 'company_address' => '', 'company_website' => 'https://lexoratech.com', 'invoice_footer_note' => 'Thank you!'];

    $currency = $pay['currency'] ?? $company['default_currency'] ?? 'LKR';
    $receipt_no = 'REC-' . str_pad($payment_id, 6, '0', STR_PAD_LEFT);

    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('Lexora Tech');
    $pdf->SetTitle('Receipt ' . $receipt_no);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(0, 0, 0);
    $pdf->AddPage();

    // ─── Green accent bar ───
    $pdf->SetFillColor(16, 185, 129);
    $pdf->Rect(0, 0, 210, 4, 'F');

    // ─── Logo + Company ───
    $pdf->SetY(12);
    $logo = getLogoPath();
    if ($logo) {
        $pdf->Image($logo, 15, 10, 20, 20, '', '', '', true, 300, '', false, false, 0);
    }
    $pdf->SetXY($logo ? 38 : 15, 12);
    $pdf->SetFont('helvetica', 'B', 18);
    $pdf->SetTextColor(26, 26, 26);
    $pdf->Cell(80, 8, $company['company_name'], 0, 1, 'L');
    $pdf->SetX($logo ? 38 : 15);
    $pdf->SetFont('helvetica', '', 8);
    $pdf->SetTextColor(120, 120, 120);
    $contactParts = array_filter([$company['company_email'] ?? '', $company['company_phone'] ?? '', $company['company_website'] ?? '']);
    $pdf->Cell(80, 4, implode('  •  ', $contactParts), 0, 1, 'L');

    // ─── PAYMENT RECEIPT title ───
    $pdf->SetXY(130, 12);
    $pdf->SetFont('helvetica', 'B', 20);
    $pdf->SetTextColor(16, 185, 129);
    $pdf->Cell(65, 10, 'RECEIPT', 0, 1, 'R');
    $pdf->SetX(130);
    $pdf->SetFont('helvetica', '', 11);
    $pdf->SetTextColor(80, 80, 80);
    $pdf->Cell(65, 6, '#' . $receipt_no, 0, 1, 'R');

    // Divider
    $pdf->SetY(42);
    $pdf->SetDrawColor(230, 230, 230);
    $pdf->Line(15, 42, 195, 42);
    $pdf->Ln(8);

    // ─── Big green amount box ───
    $pdf->SetFillColor(16, 185, 129);
    $amtY = $pdf->GetY();
    $pdf->RoundedRect(15, $amtY, 180, 22, 4, '1111', 'F');
    $pdf->SetXY(15, $amtY + 2);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(180, 6, 'AMOUNT RECEIVED', 0, 1, 'C');
    $pdf->SetX(15);
    $pdf->SetFont('helvetica', 'B', 18);
    $pdf->Cell(180, 10, $currency . ' ' . number_format($pay['amount'], 2), 0, 1, 'C');
    $pdf->Ln(8);

    // ─── Two-column details ───
    $yStart = $pdf->GetY();

    // Left — Received From
    $pdf->SetXY(15, $yStart);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetTextColor(16, 185, 129);
    $pdf->Cell(80, 5, 'RECEIVED FROM', 0, 1, 'L');
    $pdf->SetX(15);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->SetTextColor(26, 26, 26);
    $pdf->Cell(80, 6, $pay['customer_name'] ?? 'N/A', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 9);
    $pdf->SetTextColor(80, 80, 80);
    if ($pay['customer_company'] ?? '') {
        $pdf->SetX(15);
        $pdf->Cell(80, 5, $pay['customer_company'], 0, 1, 'L');
    }
    if ($pay['customer_email'] ?? '') {
        $pdf->SetX(15);
        $pdf->Cell(80, 5, $pay['customer_email'], 0, 1, 'L');
    }
    if ($pay['customer_phone'] ?? '') {
        $pdf->SetX(15);
        $pdf->Cell(80, 5, $pay['customer_phone'], 0, 1, 'L');
    }

    // Right — Payment Details
    $pdf->SetXY(120, $yStart);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetTextColor(16, 185, 129);
    $pdf->Cell(75, 5, 'PAYMENT DETAILS', 0, 1, 'L');

    $pDetails = [
        ['Date', date("M d, Y", strtotime($pay['payment_date']))],
        ['Method', ucfirst(str_replace('_', ' ', $pay['payment_method']))],
        ['Invoice', $pay['invoice_number']],
    ];
    if ($pay['transaction_id'] ?? '')
        $pDetails[] = ['Reference', $pay['transaction_id']];

    foreach ($pDetails as $pd) {
        $pdf->SetXY(120, $pdf->GetY());
        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetTextColor(120, 120, 120);
        $pdf->Cell(28, 5, $pd[0] . ':', 0, 0, 'L');
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetTextColor(26, 26, 26);
        $pdf->Cell(47, 5, $pd[1], 0, 1, 'L');
    }

    $pdf->Ln(10);

    // ─── Invoice Summary ───
    $pdf->SetX(15);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetTextColor(16, 185, 129);
    $pdf->Cell(0, 5, 'INVOICE SUMMARY', 0, 1, 'L');
    $pdf->Ln(2);

    $sumY = $pdf->GetY();
    $pdf->SetFillColor(249, 249, 249);
    $pdf->RoundedRect(15, $sumY, 180, 28, 3, '1111', 'F');

    $sumData = [
        ['Invoice Total', $currency . ' ' . number_format($pay['grand_total'], 2), [26, 26, 26]],
        ['Total Paid', $currency . ' ' . number_format($pay['amount_paid'], 2), [16, 185, 129]],
    ];
    $balance = $pay['grand_total'] - $pay['amount_paid'];
    $sumData[] = ['Balance Due', $currency . ' ' . number_format(max(0, $balance), 2), $balance > 0 ? [239, 68, 68] : [16, 185, 129]];

    $cellW = 60;
    $pdf->SetXY(15, $sumY + 3);
    foreach ($sumData as $i => $sd) {
        $x = 15 + ($i * $cellW);
        $pdf->SetXY($x, $sumY + 4);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetTextColor(120, 120, 120);
        $pdf->Cell($cellW, 5, $sd[0], 0, 1, 'C');
        $pdf->SetXY($x, $sumY + 10);
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->SetTextColor($sd[2][0], $sd[2][1], $sd[2][2]);
        $pdf->Cell($cellW, 8, $sd[1], 0, 1, 'C');
    }

    $pdf->SetY($sumY + 30);

    // ─── Notes ───
    if ($pay['notes'] ?? '') {
        $pdf->SetX(15);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetTextColor(16, 185, 129);
        $pdf->Cell(0, 5, 'NOTES', 0, 1, 'L');
        $pdf->SetX(15);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetTextColor(80, 80, 80);
        $pdf->MultiCell(165, 4, $pay['notes'], 0, 'L');
    }

    // ─── Footer ───
    $pdf->Ln(15);
    $pdf->SetDrawColor(230, 230, 230);
    $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
    $pdf->Ln(4);
    $pdf->SetFont('helvetica', 'I', 8);
    $pdf->SetTextColor(160, 160, 160);
    $pdf->MultiCell(0, 4, $company['invoice_footer_note'] ?? 'Thank you for your payment!', 0, 'C');

    // Bottom accent
    $pageH = $pdf->getPageHeight();
    $pdf->SetFillColor(16, 185, 129);
    $pdf->Rect(0, $pageH - 3, 210, 3, 'F');

    return $pdf;
}
?>