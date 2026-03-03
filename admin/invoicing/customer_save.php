<?php
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
    $company = mysqli_real_escape_string($conn, $_POST['company'] ?? '');
    $address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
    $city = mysqli_real_escape_string($conn, $_POST['city'] ?? '');
    $country = mysqli_real_escape_string($conn, $_POST['country'] ?? '');
    $tax_id = mysqli_real_escape_string($conn, $_POST['tax_id'] ?? '');
    $notes = mysqli_real_escape_string($conn, $_POST['notes'] ?? '');

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("UPDATE customers SET name=?, email=?, phone=?, company=?, address=?, city=?, country=?, tax_id=?, notes=? WHERE id=?");
        $stmt->bind_param("sssssssssi", $name, $email, $phone, $company, $address, $city, $country, $tax_id, $notes, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: customers.php?msg=Customer updated successfully");
    }
    else {
        $stmt = $conn->prepare("INSERT INTO customers (name, email, phone, company, address, city, country, tax_id, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $name, $email, $phone, $company, $address, $city, $country, $tax_id, $notes);
        $stmt->execute();
        $stmt->close();
        header("Location: customers.php?msg=Customer added successfully");
    }
    exit();
}

header("Location: customers.php");
exit();
?>