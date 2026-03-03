<?php
/**
 * Premium PDF Builder — Lexora Tech
 * Clean, professional layout with company logo.
 */

function getLogoPath()
{
    $paths = [
        __DIR__ . '/../../img/logo/logo.jpg',
        __DIR__ . '/../../img/logo/logo.png',
    ];
    foreach ($paths as $p) {
        if (file_exists($p))
            return $p;
    }
    return null;
}

function buildDocumentPDF($conn, $type, $id)
{
    // ─── Fetch document ───
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

    $cur = $doc['currency'] ?? $company['default_currency'] ?? 'LKR';

    // ─── Init PDF ───
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('Lexora Tech');
    $pdf->SetAuthor($company['company_name']);
    $pdf->SetTitle($doc_label . ' ' . $doc_number);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(0, 0, 0);
    $pdf->SetAutoPageBreak(true, 28); // room for 24mm footer bar
    $pdf->AddPage();

    // ━━━━━━ TOP ACCENT LINE ━━━━━━
    $pdf->SetFillColor(255, 180, 0);
    $pdf->Rect(0, 0, 210, 3, 'F');

    // ━━━━━━ HEADER SECTION ━━━━━━
    $logo = getLogoPath();
    $logoW = 15;
    $logoX = 18;
    $logoY = 10;
    $textStartX = 18;

    if ($logo) {
        // Place logo without any border/fill — just the image itself
        $pdf->Image($logo, $logoX, $logoY, $logoW, $logoW, '', '', '', true, 300, '', false, false, 0, 'CM', false, false);
        $textStartX = $logoX + $logoW + 5;
    }

    // Company name only in header (contact details go to footer)
    $pdf->SetXY($textStartX, 12);
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->SetTextColor(30, 30, 30);
    $pdf->Cell(70, 7, $company['company_name'], 0, 1, 'L');
    $pdf->SetX($textStartX);
    $pdf->SetFont('helvetica', '', 8);
    $pdf->SetTextColor(150, 150, 150);
    $pdf->Cell(70, 4, 'Creative Design & Tech Solutions', 0, 1, 'L');

    // ─── Right side: Document type + number ───
    $pdf->SetXY(140, 10);
    $pdf->SetFont('helvetica', 'B', 20);
    $pdf->SetTextColor(255, 180, 0);
    $pdf->Cell(55, 9, $doc_label, 0, 1, 'R');

    $pdf->SetX(140);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetTextColor(80, 80, 80);
    $pdf->Cell(55, 5, $doc_number, 0, 1, 'R');

    // Status pill
    $statusColors = [
        'draft' => [107, 114, 128], 'sent' => [59, 130, 246], 'paid' => [16, 185, 129],
        'overdue' => [239, 68, 68], 'cancelled' => [239, 68, 68], 'partial' => [245, 158, 11],
        'accepted' => [16, 185, 129], 'rejected' => [239, 68, 68], 'converted' => [139, 92, 246]
    ];
    $sc = $statusColors[$doc['status']] ?? [107, 114, 128];
    $statusText = strtoupper($doc['status']);
    $sw = $pdf->GetStringWidth($statusText) + 12;
    $pillX = 195 - $sw;
    $pillY = $pdf->GetY() + 1;
    $pdf->SetFillColor($sc[0], $sc[1], $sc[2]);
    $pdf->RoundedRect($pillX, $pillY, $sw, 6, 3, '1111', 'F');
    $pdf->SetXY($pillX, $pillY);
    $pdf->SetFont('helvetica', 'B', 7.5);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell($sw, 6, $statusText, 0, 1, 'C');

    // ━━━━━━ SEPARATOR ━━━━━━
    $pdf->SetY(35);
    $pdf->SetDrawColor(235, 235, 235);
    $pdf->SetLineWidth(0.3);
    $pdf->Line(18, 35, 192, 35);
    $pdf->Ln(7);

    // ━━━━━━ BILL TO + DOC DETAILS ━━━━━━
    $yInfo = $pdf->GetY();

    // Left — Bill To
    $pdf->SetXY(18, $yInfo);
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->SetTextColor(255, 180, 0);
    $pdf->Cell(80, 4, 'BILL TO', 0, 1, 'L');

    $pdf->SetX(18);
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->SetTextColor(30, 30, 30);
    $pdf->Cell(80, 6, $doc['customer_name'] ?? 'N/A', 0, 1, 'L');

    $pdf->SetFont('helvetica', '', 8.5);
    $pdf->SetTextColor(90, 90, 90);
    $custLines = array_filter([
        $doc['customer_company'] ?? '',
        $doc['customer_email'] ?? '',
        $doc['customer_phone'] ?? ''
    ]);
    foreach ($custLines as $cl) {
        $pdf->SetX(18);
        $pdf->Cell(80, 4.5, $cl, 0, 1, 'L');
    }
    $addr = trim(($doc['customer_address'] ?? '') . ($doc['customer_city'] ? ', ' . $doc['customer_city'] : '') . ($doc['customer_country'] ? ', ' . $doc['customer_country'] : ''), ', ');
    if ($addr) {
        $pdf->SetX(18);
        $pdf->Cell(80, 4.5, $addr, 0, 1, 'L');
    }
    $leftColBottom = $pdf->GetY(); // track left column bottom

    // Right — Document details
    $pdf->SetXY(125, $yInfo);
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->SetTextColor(255, 180, 0);
    $pdf->Cell(67, 4, $doc_label . ' DETAILS', 0, 1, 'L');

    $details = [];
    $details[] = [($type === 'quotation' ? 'Date' : 'Issue Date'), date("M d, Y", strtotime($doc['issue_date']))];
    if ($type === 'quotation' && ($doc['valid_until'] ?? ''))
        $details[] = ['Valid Until', date("M d, Y", strtotime($doc['valid_until']))];
    elseif ($type === 'invoice' && ($doc['due_date'] ?? ''))
        $details[] = ['Due Date', date("M d, Y", strtotime($doc['due_date']))];
    if ($doc['payment_terms'] ?? '')
        $details[] = ['Terms', $doc['payment_terms']];

    foreach ($details as $d) {
        $pdf->SetXY(125, $pdf->GetY());
        $pdf->SetFont('helvetica', '', 8.5);
        $pdf->SetTextColor(130, 130, 130);
        $pdf->Cell(27, 5, $d[0] . ':', 0, 0, 'L');
        $pdf->SetFont('helvetica', 'B', 8.5);
        $pdf->SetTextColor(30, 30, 30);
        $pdf->Cell(40, 5, $d[1], 0, 1, 'L');
    }
    $rightColBottom = $pdf->GetY(); // track right column bottom

    // Move Y past whichever column is taller + generous gap
    $pdf->SetY(max($leftColBottom, $rightColBottom) + 10);

    // ━━━━━━ ITEMS TABLE ━━━━━━
    $tX = 18; // table start X
    $tW = 174; // total table width
    // Column widths:  #   Description  Qty    Price    Tax%   Disc   Total
    $cW = [10, 64, 18, 26, 18, 18, 20];

    // ─── Table header ───
    $pdf->SetFillColor(40, 40, 40);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('helvetica', 'B', 7.5);
    $pdf->SetX($tX);
    $headers = ['#', 'DESCRIPTION', 'QTY', 'PRICE', 'TAX %', 'DISC', 'TOTAL'];
    $aligns = ['C', 'L', 'C', 'R', 'C', 'R', 'R'];
    for ($i = 0; $i < 7; $i++) {
        $pdf->Cell($cW[$i], 8, $headers[$i], 0, 0, $aligns[$i], true);
    }
    $pdf->Ln();

    // Gold under-border
    $pdf->SetFillColor(255, 180, 0);
    $pdf->Rect($tX, $pdf->GetY(), $tW, 0.5, 'F');

    // ─── Table rows ───
    $n = 1;
    foreach ($items as $it) {
        $even = ($n % 2 === 0);
        if ($even) {
            $pdf->SetFillColor(250, 250, 250);
        }
        $pdf->SetX($tX);
        // #
        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetTextColor(160, 160, 160);
        $pdf->Cell($cW[0], 8, $n, 0, 0, 'C', $even);
        // Description
        $pdf->SetTextColor(30, 30, 30);
        $pdf->SetFont('helvetica', '', 8.5);
        $pdf->Cell($cW[1], 8, $it['description'], 0, 0, 'L', $even);
        // Qty
        $pdf->SetTextColor(80, 80, 80);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->Cell($cW[2], 8, number_format($it['quantity'], 2), 0, 0, 'C', $even);
        // Price
        $pdf->Cell($cW[3], 8, number_format($it['unit_price'], 2), 0, 0, 'R', $even);
        // Tax
        $pdf->Cell($cW[4], 8, number_format($it['tax_rate'], 1) . '%', 0, 0, 'C', $even);
        // Discount
        $pdf->Cell($cW[5], 8, number_format($it['discount'], 2), 0, 0, 'R', $even);
        // Total (bold)
        $pdf->SetFont('helvetica', 'B', 8.5);
        $pdf->SetTextColor(30, 30, 30);
        $pdf->Cell($cW[6], 8, number_format($it['line_total'], 2), 0, 1, 'R', $even);

        // Light row separator
        $pdf->SetDrawColor(240, 240, 240);
        $pdf->SetLineWidth(0.2);
        $pdf->Line($tX, $pdf->GetY(), $tX + $tW, $pdf->GetY());
        $n++;
    }

    $pdf->Ln(5);

    // ━━━━━━ TOTALS ━━━━━━
    $tBoxX = 118;
    $lblW = 40;
    $valW = 34;
    $tBoxW = $lblW + $valW;

    // Light background
    $totStartY = $pdf->GetY();
    $totH = ($type === 'invoice') ? 48 : 32;
    $pdf->SetFillColor(250, 250, 250);
    $pdf->RoundedRect($tBoxX, $totStartY, $tBoxW, $totH, 2, '1111', 'F');

    // Subtotal
    $pdf->SetXY($tBoxX + 2, $totStartY + 2);
    $pdf->SetFont('helvetica', '', 8.5);
    $pdf->SetTextColor(130, 130, 130);
    $pdf->Cell($lblW - 2, 6, 'Subtotal', 0, 0, 'R');
    $pdf->SetTextColor(30, 30, 30);
    $pdf->Cell($valW - 2, 6, $cur . ' ' . number_format($doc['subtotal'], 2), 0, 1, 'R');

    // Tax
    $pdf->SetX($tBoxX + 2);
    $pdf->SetTextColor(130, 130, 130);
    $pdf->Cell($lblW - 2, 6, 'Tax', 0, 0, 'R');
    $pdf->SetTextColor(30, 30, 30);
    $pdf->Cell($valW - 2, 6, $cur . ' ' . number_format($doc['tax_amount'], 2), 0, 1, 'R');

    // Discount
    $pdf->SetX($tBoxX + 2);
    $pdf->SetTextColor(130, 130, 130);
    $pdf->Cell($lblW - 2, 6, 'Discount', 0, 0, 'R');
    $pdf->SetTextColor(220, 60, 60);
    $pdf->Cell($valW - 2, 6, '- ' . $cur . ' ' . number_format($doc['discount_amount'], 2), 0, 1, 'R');

    // Gold line
    $lineY = $pdf->GetY() + 1;
    $pdf->SetDrawColor(255, 180, 0);
    $pdf->SetLineWidth(0.6);
    $pdf->Line($tBoxX + 4, $lineY, $tBoxX + $tBoxW - 4, $lineY);
    $pdf->Ln(3);

    // Grand Total
    $pdf->SetX($tBoxX + 2);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->SetTextColor(255, 180, 0);
    $pdf->Cell($lblW - 2, 7, 'TOTAL', 0, 0, 'R');
    $pdf->Cell($valW - 2, 7, $cur . ' ' . number_format($doc['grand_total'], 2), 0, 1, 'R');

    // Invoice paid/balance
    if ($type === 'invoice') {
        $pdf->SetX($tBoxX + 2);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetTextColor(16, 185, 129);
        $pdf->Cell($lblW - 2, 6, 'Paid', 0, 0, 'R');
        $pdf->Cell($valW - 2, 6, $cur . ' ' . number_format($doc['amount_paid'], 2), 0, 1, 'R');

        $bal = $doc['grand_total'] - $doc['amount_paid'];
        $pdf->SetX($tBoxX + 2);
        $pdf->SetFont('helvetica', 'B', 10);
        if ($bal > 0) {
            $pdf->SetTextColor(239, 68, 68);
        }
        else {
            $pdf->SetTextColor(16, 185, 129);
        }
        $pdf->Cell($lblW - 2, 6, 'Balance Due', 0, 0, 'R');
        $pdf->Cell($valW - 2, 6, $cur . ' ' . number_format(max(0, $bal), 2), 0, 1, 'R');
    }

    $pdf->SetY(max($pdf->GetY(), $totStartY + $totH + 3));

    // ━━━━━━ PAYMENT HISTORY (invoice only) ━━━━━━
    if ($type === 'invoice') {
        $pay_q = mysqli_query($conn, "SELECT * FROM payments WHERE invoice_id=" . intval($id) . " ORDER BY payment_date ASC");
        if ($pay_q && mysqli_num_rows($pay_q) > 0) {
            $pdf->Ln(3);
            $pdf->SetX(18);
            $pdf->SetFont('helvetica', 'B', 8);
            $pdf->SetTextColor(255, 180, 0);
            $pdf->Cell(80, 5, 'PAYMENT HISTORY', 0, 1, 'L');
            $pdf->Ln(1);

            // Payment table header
            $phX = 18;
            $phW = [40, 35, 40, 45]; // Date, Amount, Method, Ref
            $pdf->SetX($phX);
            $pdf->SetFillColor(245, 245, 245);
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->SetTextColor(100, 100, 100);
            $pdf->Cell($phW[0], 6, 'DATE', 0, 0, 'L', true);
            $pdf->Cell($phW[1], 6, 'AMOUNT', 0, 0, 'R', true);
            $pdf->Cell($phW[2], 6, 'METHOD', 0, 0, 'C', true);
            $pdf->Cell($phW[3], 6, 'REFERENCE', 0, 1, 'L', true);

            $pdf->SetFont('helvetica', '', 7.5);
            while ($p = mysqli_fetch_assoc($pay_q)) {
                $pdf->SetX($phX);
                $pdf->SetTextColor(80, 80, 80);
                $pdf->Cell($phW[0], 5.5, date("M d, Y", strtotime($p['payment_date'])), 0, 0, 'L');
                $pdf->SetTextColor(16, 185, 129);
                $pdf->SetFont('helvetica', 'B', 7.5);
                $pdf->Cell($phW[1], 5.5, $cur . ' ' . number_format($p['amount'], 2), 0, 0, 'R');
                $pdf->SetFont('helvetica', '', 7.5);
                $pdf->SetTextColor(80, 80, 80);
                $pdf->Cell($phW[2], 5.5, ucfirst(str_replace('_', ' ', $p['payment_method'])), 0, 0, 'C');
                $pdf->Cell($phW[3], 5.5, $p['transaction_id'] ?: '-', 0, 1, 'L');
            }
            $pdf->Ln(3);
        }
    }

    // ━━━━━━ BANK DETAILS ━━━━━━
    $bname = $company['bank_name'] ?? '';
    $bnum = $company['bank_account_number'] ?? '';
    if ($bname || $bnum) {
        $pdf->Ln(2);
        $bkY = $pdf->GetY();
        $pdf->SetFillColor(250, 250, 250);
        $pdf->SetDrawColor(235, 235, 235);

        // Calculate height based on number of bank lines
        $bankRows = [];
        if ($bname)
            $bankRows[] = ['Bank', $bname];
        if ($company['bank_account_name'] ?? '')
            $bankRows[] = ['Account Name', $company['bank_account_name']];
        if ($bnum)
            $bankRows[] = ['Account No', $bnum];
        if ($company['bank_branch'] ?? '')
            $bankRows[] = ['Branch', $company['bank_branch']];
        if ($company['bank_swift'] ?? '')
            $bankRows[] = ['SWIFT Code', $company['bank_swift']];
        $bkH = 8 + (count($bankRows) * 5);

        $pdf->RoundedRect(18, $bkY, 90, $bkH, 2, '1111', 'DF');

        $pdf->SetXY(22, $bkY + 3);
        $pdf->SetFont('helvetica', 'B', 7.5);
        $pdf->SetTextColor(255, 180, 0);
        $pdf->Cell(80, 4, 'BANK DETAILS', 0, 1, 'L');

        $pdf->SetFont('helvetica', '', 8);
        foreach ($bankRows as $br) {
            $pdf->SetX(22);
            $pdf->SetTextColor(130, 130, 130);
            $pdf->Cell(28, 4.5, $br[0], 0, 0, 'L');
            $pdf->SetTextColor(30, 30, 30);
            $pdf->SetFont('helvetica', 'B', 8);
            $pdf->Cell(55, 4.5, $br[1], 0, 1, 'L');
            $pdf->SetFont('helvetica', '', 8);
        }
        $pdf->SetY(max($pdf->GetY(), $bkY + $bkH + 3));
    }

    // ━━━━━━ NOTES ━━━━━━
    if ($doc['notes'] ?? '') {
        $pdf->Ln(2);
        $pdf->SetX(18);
        $pdf->SetFont('helvetica', 'B', 7.5);
        $pdf->SetTextColor(255, 180, 0);
        $pdf->Cell(0, 4, 'NOTES', 0, 1, 'L');
        $pdf->SetX(18);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetTextColor(90, 90, 90);
        $pdf->MultiCell(160, 4, $doc['notes'], 0, 'L');
    }

    // ━━━━━━ FOOTER ━━━━━━
    $footerNote = $company['invoice_footer_note'] ?? '';
    // Dark footer bar — pinned to exact page bottom
    $footH = 22;
    $accentH = 2;
    $pageH = $pdf->getPageHeight();
    $footY = $pageH - $footH - $accentH;

    // If content extends past footer position, add a new page
    if ($pdf->GetY() + 5 > $footY) {
        $pdf->AddPage();
        $footY = $pageH - $footH - $accentH;
    }

    // Dark footer bar
    $pdf->SetFillColor(40, 40, 40);
    $pdf->Rect(0, $footY, 210, $footH, 'F');
    // Gold top border
    $pdf->SetFillColor(255, 180, 0);
    $pdf->Rect(0, $footY, 210, 0.8, 'F');

    // Footer left — company contact
    $pdf->SetXY(18, $footY + 3);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(80, 4, $company['company_name'] ?? 'Lexora Tech', 0, 1, 'L');
    $pdf->SetX(18);
    $pdf->SetFont('helvetica', '', 7);
    $pdf->SetTextColor(180, 180, 180);
    $footParts = array_filter([
        ($company['company_email'] ?? ''),
        ($company['company_phone'] ?? ''),
    ]);
    if ($footParts)
        $pdf->Cell(90, 3.5, implode('  |  ', $footParts), 0, 1, 'L');
    $pdf->SetX(18);
    $footParts2 = array_filter([
        ($company['company_website'] ?? ''),
        ($company['company_address'] ?? ''),
    ]);
    if ($footParts2)
        $pdf->Cell(90, 3.5, implode('  |  ', $footParts2), 0, 1, 'L');

    // Footer right — thank you note
    if ($footerNote) {
        $pdf->SetXY(120, $footY + 6);
        $pdf->SetFont('helvetica', 'I', 7.5);
        $pdf->SetTextColor(200, 200, 200);
        $pdf->MultiCell(72, 3.5, $footerNote, 0, 'R');
    }

    // Bottom gold accent line
    $pdf->SetFillColor(255, 180, 0);
    $pdf->Rect(0, $footY + $footH, 210, $accentH, 'F');

    return $pdf;
}


// ═══════════════════════════════════════════════════
//  PAYMENT RECEIPT PDF
// ═══════════════════════════════════════════════════
function buildReceiptPDF($conn, $payment_id)
{
    $pq = mysqli_query($conn, "SELECT p.*, i.invoice_number, i.grand_total, i.amount_paid, i.currency, i.status as inv_status, c.name as customer_name, c.email as customer_email, c.phone as customer_phone, c.company as customer_company, c.address as customer_address FROM payments p JOIN invoices i ON p.invoice_id=i.id LEFT JOIN customers c ON i.customer_id=c.id WHERE p.id=" . intval($payment_id));
    $pay = mysqli_fetch_assoc($pq);
    if (!$pay)
        return null;

    $cs_q = mysqli_query($conn, "SELECT * FROM company_settings WHERE id=1");
    $company = mysqli_fetch_assoc($cs_q);
    if (!$company)
        $company = ['company_name' => 'Lexora Tech', 'company_email' => 'info@lexoratech.com', 'company_phone' => '', 'company_address' => '', 'company_website' => '', 'invoice_footer_note' => 'Thank you!'];

    $cur = $pay['currency'] ?? $company['default_currency'] ?? 'LKR';
    $rec = 'REC-' . str_pad($payment_id, 6, '0', STR_PAD_LEFT);

    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('Lexora Tech');
    $pdf->SetTitle('Receipt ' . $rec);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(0, 0, 0);
    $pdf->AddPage();

    // ─── Green accent bar ───
    $pdf->SetFillColor(16, 185, 129);
    $pdf->Rect(0, 0, 210, 3, 'F');

    // ─── Logo + Company ───
    $logo = getLogoPath();
    $textStartX = 18;
    if ($logo) {
        $pdf->Image($logo, 18, 10, 15, 15, '', '', '', true, 300, '', false, false, 0, 'CM', false, false);
        $textStartX = 38;
    }
    $pdf->SetXY($textStartX, 11);
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->SetTextColor(30, 30, 30);
    $pdf->Cell(70, 7, $company['company_name'], 0, 1, 'L');
    $pdf->SetX($textStartX);
    $pdf->SetFont('helvetica', '', 7.5);
    $pdf->SetTextColor(130, 130, 130);
    $line = array_filter([$company['company_email'] ?? '', $company['company_phone'] ?? '', $company['company_website'] ?? '']);
    if ($line)
        $pdf->Cell(80, 3.5, implode('  |  ', $line), 0, 1, 'L');

    // ─── Right: RECEIPT title ───
    $pdf->SetXY(140, 10);
    $pdf->SetFont('helvetica', 'B', 20);
    $pdf->SetTextColor(16, 185, 129);
    $pdf->Cell(55, 9, 'RECEIPT', 0, 1, 'R');
    $pdf->SetX(140);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetTextColor(80, 80, 80);
    $pdf->Cell(55, 5, $rec, 0, 1, 'R');

    // Separator
    $pdf->SetY(35);
    $pdf->SetDrawColor(235, 235, 235);
    $pdf->Line(18, 35, 192, 35);
    $pdf->Ln(8);

    // ─── Big amount card ───
    $amtY = $pdf->GetY();
    $pdf->SetFillColor(16, 185, 129);
    $pdf->RoundedRect(18, $amtY, $tW = 174, 20, 3, '1111', 'F');
    $pdf->SetXY(18, $amtY + 2);
    $pdf->SetFont('helvetica', '', 8);
    $pdf->SetTextColor(220, 255, 240);
    $pdf->Cell($tW, 5, 'AMOUNT RECEIVED', 0, 1, 'C');
    $pdf->SetX(18);
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell($tW, 10, $cur . ' ' . number_format($pay['amount'], 2), 0, 1, 'C');
    $pdf->Ln(6);

    // ─── Two columns: Received From + Payment Details ───
    $yS = $pdf->GetY();

    // Left — customer
    $pdf->SetXY(18, $yS);
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->SetTextColor(16, 185, 129);
    $pdf->Cell(80, 4, 'RECEIVED FROM', 0, 1, 'L');
    $pdf->SetX(18);
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->SetTextColor(30, 30, 30);
    $pdf->Cell(80, 6, $pay['customer_name'] ?? 'N/A', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 8.5);
    $pdf->SetTextColor(90, 90, 90);
    foreach (array_filter([$pay['customer_company'] ?? '', $pay['customer_email'] ?? '', $pay['customer_phone'] ?? '']) as $cl) {
        $pdf->SetX(18);
        $pdf->Cell(80, 4.5, $cl, 0, 1, 'L');
    }

    // Right — payment info
    $pdf->SetXY(125, $yS);
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->SetTextColor(16, 185, 129);
    $pdf->Cell(67, 4, 'PAYMENT DETAILS', 0, 1, 'L');

    $pRows = [
        ['Date', date("M d, Y", strtotime($pay['payment_date']))],
        ['Method', ucfirst(str_replace('_', ' ', $pay['payment_method']))],
        ['Invoice', $pay['invoice_number']],
    ];
    if ($pay['transaction_id'] ?? '')
        $pRows[] = ['Reference', $pay['transaction_id']];

    foreach ($pRows as $pr) {
        $pdf->SetXY(125, $pdf->GetY());
        $pdf->SetFont('helvetica', '', 8.5);
        $pdf->SetTextColor(130, 130, 130);
        $pdf->Cell(25, 5, $pr[0] . ':', 0, 0, 'L');
        $pdf->SetFont('helvetica', 'B', 8.5);
        $pdf->SetTextColor(30, 30, 30);
        $pdf->Cell(42, 5, $pr[1], 0, 1, 'L');
    }

    $pdf->Ln(8);

    // ─── Invoice Summary ───
    $pdf->SetX(18);
    $pdf->SetFont('helvetica', 'B', 7.5);
    $pdf->SetTextColor(16, 185, 129);
    $pdf->Cell(0, 4, 'INVOICE SUMMARY', 0, 1, 'L');
    $pdf->Ln(2);

    $sY = $pdf->GetY();
    $pdf->SetFillColor(250, 250, 250);
    $pdf->SetDrawColor(235, 235, 235);
    $pdf->RoundedRect(18, $sY, 174, 24, 2, '1111', 'DF');

    $balance = $pay['grand_total'] - $pay['amount_paid'];
    $sumItems = [
        ['Invoice Total', $cur . ' ' . number_format($pay['grand_total'], 2), [30, 30, 30]],
        ['Total Paid', $cur . ' ' . number_format($pay['amount_paid'], 2), [16, 185, 129]],
        ['Balance Due', $cur . ' ' . number_format(max(0, $balance), 2), $balance > 0 ? [239, 68, 68] : [16, 185, 129]],
    ];

    $cellW = 58;
    foreach ($sumItems as $i => $si) {
        $x = 18 + ($i * $cellW);
        $pdf->SetXY($x, $sY + 3);
        $pdf->SetFont('helvetica', '', 7.5);
        $pdf->SetTextColor(130, 130, 130);
        $pdf->Cell($cellW, 4, $si[0], 0, 0, 'C');
        $pdf->SetXY($x, $sY + 9);
        $pdf->SetFont('helvetica', 'B', 13);
        $pdf->SetTextColor($si[2][0], $si[2][1], $si[2][2]);
        $pdf->Cell($cellW, 8, $si[1], 0, 0, 'C');
    }

    $pdf->SetY($sY + 28);

    // ─── Notes ───
    if ($pay['notes'] ?? '') {
        $pdf->SetX(18);
        $pdf->SetFont('helvetica', 'B', 7.5);
        $pdf->SetTextColor(16, 185, 129);
        $pdf->Cell(0, 4, 'NOTES', 0, 1, 'L');
        $pdf->SetX(18);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetTextColor(90, 90, 90);
        $pdf->MultiCell(160, 4, $pay['notes'], 0, 'L');
    }

    // ─── Footer bar (pinned to bottom) ───
    $footH = 22;
    $accentH = 2;
    $pageH = $pdf->getPageHeight();
    $footY = $pageH - $footH - $accentH;
    if ($pdf->GetY() + 5 > $footY) {
        $pdf->AddPage();
        $footY = $pageH - $footH - $accentH;
    }
    $pdf->SetFillColor(40, 40, 40);
    $pdf->Rect(0, $footY, 210, $footH, 'F');
    $pdf->SetFillColor(16, 185, 129);
    $pdf->Rect(0, $footY, 210, 0.8, 'F');
    $pdf->SetXY(18, $footY + 3);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(80, 4, $company['company_name'] ?? 'Lexora Tech', 0, 1, 'L');
    $pdf->SetX(18);
    $pdf->SetFont('helvetica', '', 7);
    $pdf->SetTextColor(180, 180, 180);
    $fp = array_filter([($company['company_email']??''), ($company['company_phone']??'')]);
    if ($fp) $pdf->Cell(90, 3.5, implode('  |  ', $fp), 0, 1, 'L');
    $pdf->SetX(18);
    $fp2 = array_filter([($company['company_website']??''), ($company['company_address']??'')]);
    if ($fp2) $pdf->Cell(90, 3.5, implode('  |  ', $fp2), 0, 1, 'L');
    $fnote = $company['invoice_footer_note'] ?? 'Thank you for your payment!';
    $pdf->SetXY(120, $footY + 6);
    $pdf->SetFont('helvetica', 'I', 7.5);
    $pdf->SetTextColor(200, 200, 200);
    $pdf->MultiCell(72, 3.5, $fnote, 0, 'R');
    $pdf->SetFillColor(16, 185, 129);
    $pdf->Rect(0, $footY + $footH, 210, $accentH, 'F');

    return $pdf;
}



// ═══════════════════════════════════════════════════
// SERVICE AGREEMENT PDF
// ═══════════════════════════════════════════════════
function buildAgreementPDF($conn, $agreement_id) {
$aq = mysqli_query($conn, "SELECT a.*, c.name as customer_name, c.email as customer_email, c.phone as customer_phone,
c.company as customer_company, c.address as customer_address, c.city as customer_city, c.country as customer_country,
i.invoice_number, i.grand_total, i.currency FROM service_agreements a LEFT JOIN customers c ON a.customer_id=c.id LEFT
JOIN invoices i ON a.invoice_id=i.id WHERE a.id=" . intval($agreement_id));
$agr = mysqli_fetch_assoc($aq);
if (!$agr) return null;

$cs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM company_settings WHERE id=1"));
if (!$cs) $cs = ['company_name'=>'Lexora
Tech','company_email'=>'','company_phone'=>'','company_address'=>'','company_website'=>'','invoice_footer_note'=>''];

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator('Lexora Tech');
$pdf->SetTitle('Agreement ' . $agr['agreement_number']);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(0, 0, 0);
$pdf->SetAutoPageBreak(true, 30);
$pdf->AddPage();

// ─── Gold accent top ───
$pdf->SetFillColor(255, 180, 0);
$pdf->Rect(0, 0, 210, 3, 'F');

// ─── Dark header section ───
$pdf->SetFillColor(30, 30, 30);
$pdf->Rect(0, 3, 210, 35, 'F');

$logo = getLogoPath();
if ($logo) {
$pdf->Image($logo, 18, 8, 14, 14, '', '', '', true, 300, '', false, false, 0, 'CM', false, false);
}

$pdf->SetXY(18, 12);
$pdf->SetFont('helvetica', 'B', 20);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(174, 10, 'SERVICE AGREEMENT', 0, 1, 'C');
$pdf->SetX(18);
$pdf->SetFont('helvetica', '', 10);
$pdf->SetTextColor(255, 180, 0);
$pdf->Cell(174, 5, $agr['agreement_number'], 0, 1, 'C');

// Gold accent under header
$pdf->SetFillColor(255, 180, 0);
$pdf->Rect(0, 38, 210, 1.5, 'F');

$pdf->SetY(46);
$m = 22; // left margin for text

// ─── Effective date ───
$pdf->SetX($m);
$pdf->SetFont('helvetica', '', 9);
$pdf->SetTextColor(60, 60, 60);
$effDate = $agr['effective_date'] ? date("F d, Y", strtotime($agr['effective_date'])) : '_______________';
$pdf->MultiCell(166, 5, 'This Service Agreement (the "Agreement") is entered into as of ' . $effDate . ' (the "Effective
Date") between the following parties:', 0, 'L');
$pdf->Ln(4);

// ─── Parties ───
$sNum = 1;
$pdf->SetX($m);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetTextColor(255, 180, 0);
$pdf->Cell(166, 6, $sNum . '. PARTIES', 0, 1, 'L');
$pdf->SetDrawColor(255, 180, 0);
$pdf->SetLineWidth(0.4);
$pdf->Line($m, $pdf->GetY(), $m + 30, $pdf->GetY());
$pdf->Ln(4);

// Provider
$pdf->SetX($m);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->SetTextColor(130, 130, 130);
$pdf->Cell(80, 4, 'SERVICE PROVIDER', 0, 1, 'L');
$pdf->SetX($m);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetTextColor(30, 30, 30);
$pdf->Cell(80, 5, $cs['company_name'], 0, 1, 'L');
$pdf->SetFont('helvetica', '', 8.5);
$pdf->SetTextColor(80, 80, 80);
foreach (array_filter([$cs['company_email']??'', $cs['company_phone']??'', $cs['company_address']??'']) as $l) {
$pdf->SetX($m); $pdf->Cell(80, 4, $l, 0, 1, 'L');
}
$pdf->Ln(3);

// Client
$pdf->SetX($m);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->SetTextColor(130, 130, 130);
$pdf->Cell(80, 4, 'CLIENT', 0, 1, 'L');
$pdf->SetX($m);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetTextColor(30, 30, 30);
$pdf->Cell(80, 5, $agr['customer_name'] ?? '', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 8.5);
$pdf->SetTextColor(80, 80, 80);
$custLines = array_filter([$agr['customer_company']??'', $agr['customer_email']??'', $agr['customer_phone']??'']);
$addr = trim(($agr['customer_address']??'') . ($agr['customer_city']?', '.$agr['customer_city']:'') .
($agr['customer_country']?', '.$agr['customer_country']:''), ', ');
if ($addr) $custLines[] = $addr;
foreach ($custLines as $l) { $pdf->SetX($m); $pdf->Cell(80, 4, $l, 0, 1, 'L'); }
$pdf->Ln(5);

// ─── Helper to render sections ───
$sections = [];
$sNum++;
if ($agr['scope_of_services']) $sections[] = [$sNum++, 'SCOPE OF SERVICES', $agr['scope_of_services']];

// Timeline
$timeline = 'Project Start Date: ' . ($agr['project_start_date'] ? date("F d, Y", strtotime($agr['project_start_date']))
: 'TBD');
$timeline .= "\nProject End Date: " . ($agr['project_end_date'] ? date("F d, Y", strtotime($agr['project_end_date'])) :
'TBD');
$sections[] = [$sNum++, 'PROJECT TIMELINE', $timeline];

if ($agr['payment_terms_text']) $sections[] = [$sNum++, 'PAYMENT TERMS', $agr['payment_terms_text']];
if ($agr['late_payment_policy']) $sections[] = [$sNum++, 'LATE PAYMENT POLICY', $agr['late_payment_policy']];
if ($agr['confidentiality_clause']) $sections[] = [$sNum++, 'CONFIDENTIALITY', $agr['confidentiality_clause']];
if ($agr['ip_clause']) $sections[] = [$sNum++, 'INTELLECTUAL PROPERTY', $agr['ip_clause']];
if ($agr['termination_clause']) $sections[] = [$sNum++, 'TERMINATION', $agr['termination_clause']];
if ($agr['liability_clause']) $sections[] = [$sNum++, 'LIMITATION OF LIABILITY', $agr['liability_clause']];
if ($agr['governing_law']) $sections[] = [$sNum++, 'GOVERNING LAW', $agr['governing_law']];
if ($agr['dispute_resolution']) $sections[] = [$sNum++, 'DISPUTE RESOLUTION', $agr['dispute_resolution']];
if ($agr['force_majeure']) $sections[] = [$sNum++, 'FORCE MAJEURE', $agr['force_majeure']];
if ($agr['amendments_clause']) $sections[] = [$sNum++, 'AMENDMENTS', $agr['amendments_clause']];
if ($agr['custom_notes']) $sections[] = [$sNum++, 'ADDITIONAL NOTES', $agr['custom_notes']];

foreach ($sections as $sec) {
$pdf->SetX($m);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetTextColor(255, 180, 0);
$pdf->Cell(166, 6, $sec[0] . '. ' . $sec[1], 0, 1, 'L');
$pdf->SetDrawColor(255, 180, 0);
$pdf->SetLineWidth(0.4);
$pdf->Line($m, $pdf->GetY(), $m + 30, $pdf->GetY());
$pdf->Ln(3);
$pdf->SetX($m);
$pdf->SetFont('helvetica', '', 9);
$pdf->SetTextColor(60, 60, 60);
$pdf->MultiCell(166, 5, $sec[2], 0, 'L');
$pdf->Ln(4);
}

// ─── Signatures ───
$pdf->Ln(5);
$pdf->SetX($m);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetTextColor(255, 180, 0);
$pdf->Cell(166, 6, 'SIGNATURES', 0, 1, 'L');
$pdf->SetDrawColor(255, 180, 0);
$pdf->Line($m, $pdf->GetY(), $m + 30, $pdf->GetY());
$pdf->Ln(3);
$pdf->SetX($m);
$pdf->SetFont('helvetica', '', 9);
$pdf->SetTextColor(60, 60, 60);
$pdf->MultiCell(166, 5, 'IN WITNESS WHEREOF, the parties have executed this Agreement as of the Effective Date.', 0,
'L');
$pdf->Ln(15);

// Provider signature
$sigY = $pdf->GetY();
$pdf->SetDrawColor(30, 30, 30);
$pdf->SetLineWidth(0.5);
$pdf->Line($m, $sigY, $m + 70, $sigY);
$pdf->SetXY($m, $sigY + 2);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->SetTextColor(30, 30, 30);
$pdf->Cell(70, 4, $agr['company_signatory_name'] ?? $cs['company_name'], 0, 1, 'L');
$pdf->SetX($m);
$pdf->SetFont('helvetica', '', 8);
$pdf->SetTextColor(130, 130, 130);
$pdf->Cell(70, 4, ($agr['company_signatory_title'] ?? 'Director') . ', ' . $cs['company_name'], 0, 1, 'L');

// Client signature
$pdf->Line(120, $sigY, 190, $sigY);
$pdf->SetXY(120, $sigY + 2);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->SetTextColor(30, 30, 30);
$pdf->Cell(70, 4, $agr['client_signature_name'] ?: ($agr['customer_name'] ?? ''), 0, 1, 'L');
$pdf->SetXY(120, $pdf->GetY());
$pdf->SetFont('helvetica', '', 8);
$pdf->SetTextColor(130, 130, 130);
$clientLabel = 'Client';
if ($agr['customer_company']) $clientLabel .= ', ' . $agr['customer_company'];
$pdf->Cell(70, 4, $clientLabel, 0, 1, 'L');

$pdf->Ln(5);
$pdf->SetX($m);
$pdf->SetFont('helvetica', '', 8);
$pdf->SetTextColor(130, 130, 130);
$pdf->Cell(80, 4, 'Date: _______________', 0, 0, 'L');
$pdf->Cell(86, 4, 'Date: _______________', 0, 1, 'L');

// ─── Footer (pinned to bottom) ───
$footH = 22;
$accentH = 2;
$pageH = $pdf->getPageHeight();
$footY = $pageH - $footH - $accentH;
if ($pdf->GetY() + 5 > $footY) {
$pdf->AddPage();
$footY = $pageH - $footH - $accentH;
}
$pdf->SetFillColor(40, 40, 40);
$pdf->Rect(0, $footY, 210, $footH, 'F');
$pdf->SetFillColor(255, 180, 0);
$pdf->Rect(0, $footY, 210, 0.8, 'F');
$pdf->SetXY(18, $footY + 3);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(80, 4, $cs['company_name'] ?? 'Lexora Tech', 0, 1, 'L');
$pdf->SetX(18);
$pdf->SetFont('helvetica', '', 7);
$pdf->SetTextColor(180, 180, 180);
$fp = array_filter([($cs['company_email']??''), ($cs['company_phone']??'')]);
if ($fp) $pdf->Cell(90, 3.5, implode(' | ', $fp), 0, 1, 'L');
$pdf->SetX(18);
$fp2 = array_filter([($cs['company_website']??''), ($cs['company_address']??'')]);
if ($fp2) $pdf->Cell(90, 3.5, implode(' | ', $fp2), 0, 1, 'L');
$fnote = $cs['invoice_footer_note'] ?? '';
if ($fnote) {
$pdf->SetXY(120, $footY + 6);
$pdf->SetFont('helvetica', 'I', 7.5);
$pdf->SetTextColor(200, 200, 200);
$pdf->MultiCell(72, 3.5, $fnote, 0, 'R');
}
$pdf->SetFillColor(255, 180, 0);
$pdf->Rect(0, $footY + $footH, 210, $accentH, 'F');

return $pdf;
}
?>