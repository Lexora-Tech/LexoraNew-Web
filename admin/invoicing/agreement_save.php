<?php
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: agreements.php");
    exit();
}

$id = intval($_POST['id'] ?? 0);
$status = mysqli_real_escape_string($conn, $_POST['status'] ?? 'draft');
$effective_date = mysqli_real_escape_string($conn, $_POST['effective_date'] ?? '');
$project_start_date = mysqli_real_escape_string($conn, $_POST['project_start_date'] ?? '');
$project_end_date = mysqli_real_escape_string($conn, $_POST['project_end_date'] ?? '');
$scope = $_POST['scope_of_services'] ?? '';
$payment_terms_text = $_POST['payment_terms_text'] ?? '';
$late_payment = $_POST['late_payment_policy'] ?? '';
$confidentiality = $_POST['confidentiality_clause'] ?? '';
$ip_clause = $_POST['ip_clause'] ?? '';
$termination = $_POST['termination_clause'] ?? '';
$liability = $_POST['liability_clause'] ?? '';
$governing = $_POST['governing_law'] ?? '';
$dispute = $_POST['dispute_resolution'] ?? '';
$force_majeure = $_POST['force_majeure'] ?? '';
$amendments = $_POST['amendments_clause'] ?? '';
$custom_notes = $_POST['custom_notes'] ?? '';
$client_sig_name = mysqli_real_escape_string($conn, $_POST['client_signature_name'] ?? '');
$company_sig_name = mysqli_real_escape_string($conn, $_POST['company_signatory_name'] ?? '');
$company_sig_title = mysqli_real_escape_string($conn, $_POST['company_signatory_title'] ?? '');

if ($id > 0) {
    $stmt = $conn->prepare("UPDATE service_agreements SET status=?, effective_date=?, project_start_date=?, project_end_date=?, scope_of_services=?, payment_terms_text=?, late_payment_policy=?, confidentiality_clause=?, ip_clause=?, termination_clause=?, liability_clause=?, governing_law=?, dispute_resolution=?, force_majeure=?, amendments_clause=?, custom_notes=?, client_signature_name=?, company_signatory_name=?, company_signatory_title=? WHERE id=?");
    $stmt->bind_param("sssssssssssssssssssi",
        $status, $effective_date, $project_start_date, $project_end_date,
        $scope, $payment_terms_text, $late_payment, $confidentiality,
        $ip_clause, $termination, $liability, $governing,
        $dispute, $force_majeure, $amendments, $custom_notes,
        $client_sig_name, $company_sig_name, $company_sig_title, $id
    );
    $stmt->execute();
    $stmt->close();
    $msg = "Agreement updated successfully";
}
else {
    header("Location: agreements.php?msg=" . urlencode("Invalid agreement"));
    exit();
}

header("Location: agreement_view.php?id=$id&msg=" . urlencode($msg));
exit();
?>