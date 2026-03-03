<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");
require_once(__DIR__ . "/../../vendor/autoload.php");
require_once(__DIR__ . "/pdf_builder.php");

if (!isset($_GET['type']) || !isset($_GET['id'])) {
    die("Missing parameters");
}

$type = $_GET['type'];
$id = intval($_GET['id']);

if ($type === 'receipt') {
    $pdf = buildReceiptPDF($conn, $id);
    if (!$pdf)
        die("Payment not found");
    $receipt_no = 'REC-' . str_pad($id, 6, '0', STR_PAD_LEFT);
    if (ob_get_length())
        ob_clean();
    $pdf->Output($receipt_no . '.pdf', 'I');
}
elseif ($type === 'agreement') {
    $pdf = buildAgreementPDF($conn, $id);
    if (!$pdf)
        die("Agreement not found");
    $agr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT agreement_number FROM service_agreements WHERE id=$id"));
    if (ob_get_length())
        ob_clean();
    $pdf->Output(($agr['agreement_number'] ?? 'Agreement') . '.pdf', 'I');
}
else {
    $pdf = buildDocumentPDF($conn, $type, $id);
    if (!$pdf)
        die("Document not found");
    $doc_number = ($type === 'quotation') ? 
        mysqli_fetch_assoc(mysqli_query($conn, "SELECT quotation_number FROM quotations WHERE id=$id"))['quotation_number'] :
        mysqli_fetch_assoc(mysqli_query($conn, "SELECT invoice_number FROM invoices WHERE id=$id"))['invoice_number'];
    if (ob_get_length())
        ob_clean();
    $pdf->Output($doc_number . '.pdf', 'I');
}
?>