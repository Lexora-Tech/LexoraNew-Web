<?php
// 1. Connect to Database
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. Sanitize Basic Inputs
    $name    = $conn->real_escape_string($_POST['name']);
    $email   = $conn->real_escape_string($_POST['email']);
    $phone   = $conn->real_escape_string($_POST['phone']);
    $company = $conn->real_escape_string($_POST['company']);
    $budget  = $conn->real_escape_string($_POST['budget']);
    $message = $conn->real_escape_string($_POST['message']);

    // 3. Handle Services & Custom Inputs
    // We combine checked boxes and typed text into one clean list
    $selected_services = [];

    // Add checked boxes
    if (isset($_POST['services']) && is_array($_POST['services'])) {
        foreach ($_POST['services'] as $service) {
            $selected_services[] = $service;
        }
    }

    // Check for "Other" typed inputs and add them to the list if they exist
    if (!empty($_POST['web_other'])) { $selected_services[] = "Web Custom: " . $_POST['web_other']; }
    if (!empty($_POST['mobile_other'])) { $selected_services[] = "Mobile Custom: " . $_POST['mobile_other']; }
    if (!empty($_POST['pos_other'])) { $selected_services[] = "POS Custom: " . $_POST['pos_other']; }
    if (!empty($_POST['ui_other'])) { $selected_services[] = "UI/UX Custom: " . $_POST['ui_other']; }
    if (!empty($_POST['brand_other'])) { $selected_services[] = "Brand Custom: " . $_POST['brand_other']; }
    if (!empty($_POST['marketing_other'])) { $selected_services[] = "Marketing Custom: " . $_POST['marketing_other']; }

    // Convert array to comma-separated string for Database
    $services_string = implode(", ", $selected_services);
    $services_db_safe = $conn->real_escape_string($services_string);

    // 4. Insert into Database
    $sql = "INSERT INTO quote_requests (name, email, phone, company, budget, services, message) 
            VALUES ('$name', '$email', '$phone', '$company', '$budget', '$services_db_safe', '$message')";

    if ($conn->query($sql) === TRUE) {
        
        // 5. Send Email to Admin (You)
        $to = "praveenlakshan021@gmail.com"; // REPLACE WITH YOUR EMAIL
        $subject = "New Quote Request from " . $name;
        
        // Email Content (HTML)
        $email_message = "
        <html>
        <head>
          <title>New Project Inquiry</title>
        </head>
        <body>
          <h2>New Quote Request</h2>
          <p><strong>Name:</strong> $name</p>
          <p><strong>Email:</strong> $email</p>
          <p><strong>Phone:</strong> $phone</p>
          <p><strong>Company:</strong> $company</p>
          <p><strong>Budget:</strong> $budget</p>
          <hr>
          <h3>Services Requested:</h3>
          <p>$services_string</p>
          <hr>
          <h3>Message:</h3>
          <p>$message</p>
        </body>
        </html>
        ";

        // Headers for HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: website@lexoratech.com" . "\r\n"; // Ideally use a domain email

        // Send
        mail($to, $subject, $email_message, $headers);

        // 6. Redirect to Success Page
        header("Location: thank-you.php");
        exit();

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    // If someone tries to access this file directly without submitting
    header("Location: quote.php");
    exit();
}
?>