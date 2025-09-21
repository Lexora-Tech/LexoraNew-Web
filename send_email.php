<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]); 
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    $to = "contact@lexoratech.com"; // domain email
    $subject = "New Form Submission from $name";
    $headers = "From: no-reply@lexoratech.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body = "
        <h2>New Contact Form Submission</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Message:</strong> $message</p>
    ";

    if (mail($to, $subject, $body, $headers)) {
        // Redirect after success
        header("Location: index.html");
        exit();
    } else {
        // Redirect after failure
        header("Location: index.html?status=error");
        exit();
    }
} else {
    echo "Invalid request.";
}