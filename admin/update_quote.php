<?php
include("../includes/auth.php");
include("../includes/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $notes = mysqli_real_escape_string($conn, $_POST['admin_notes']);

    $sql = "UPDATE quote_requests SET status='$status', admin_notes='$notes' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        http_response_code(500);
        echo "Error updating record";
    }
}
?>