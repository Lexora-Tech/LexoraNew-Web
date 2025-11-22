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
        $subject = "New Quote Request From " . $name;
        
        // Email Content (HTML)
       $email_message = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
            .header { background-color: #121212; padding: 30px; text-align: center; border-bottom: 4px solid #ffb400; }
            .header h1 { color: #ffffff; margin: 0; font-size: 24px; letter-spacing: 1px; }
            .content { padding: 30px; color: #333333; line-height: 1.6; }
            .label { font-size: 12px; color: #999999; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; display: block; }
            .value { font-size: 16px; color: #121212; font-weight: 600; margin-bottom: 20px; display: block; }
            .info-grid { display: table; width: 100%; margin-bottom: 20px; }
            .info-row { display: table-row; }
            .info-cell { display: table-cell; width: 50%; padding-bottom: 15px; vertical-align: top; }
            .budget-badge { background-color: #121212; color: #ffb400; padding: 5px 10px; border-radius: 4px; font-size: 14px; font-weight: bold; }
            .message-box { background-color: #f9f9f9; padding: 20px; border-radius: 4px; border-left: 4px solid #ffb400; margin-top: 10px; }
            .services-list { color: #555; font-style: italic; }
            .footer { background-color: #f4f4f4; padding: 20px; text-align: center; font-size: 12px; color: #888888; }
            .btn { display: inline-block; background-color: #ffb400; color: #000000; padding: 12px 25px; text-decoration: none; border-radius: 30px; font-weight: bold; margin-top: 20px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>New Project Inquiry</h1>
            </div>

            <div class='content'>
                
                <p style='font-size: 18px; margin-bottom: 30px;'>
                    You have received a new quote request from <strong>$name</strong>.
                </p>

                <div class='info-grid'>
                    <div class='info-row'>
                        <div class='info-cell'>
                            <span class='label'>Email Address</span>
                            <span class='value'><a href='mailto:$email' style='color: #121212; text-decoration: none;'>$email</a></span>
                        </div>
                        <div class='info-cell'>
                            <span class='label'>Phone Number</span>
                            <span class='value'>$phone</span>
                        </div>
                    </div>
                    <div class='info-row'>
                        <div class='info-cell'>
                            <span class='label'>Company / Org</span>
                            <span class='value'>$company</span>
                        </div>
                        <div class='info-cell'>
                            <span class='label'>Estimated Budget</span>
                            <span class='budget-badge'>$budget</span>
                        </div>
                    </div>
                </div>

                <hr style='border: 0; border-top: 1px solid #eeeeee; margin: 20px 0;'>

                <span class='label'>Services Requested</span>
                <p class='value services-list'>$services_string</p>

                <span class='label'>Project Description</span>
                <div class='message-box'>
                    $message
                </div>

                <div style='text-align: center;'>
                    <a href='mailto:$email?subject=Re: Your Quote Request - Lexora Tech' class='btn'>Reply to Client</a>
                </div>

            </div>

            <div class='footer'>
                <p>&copy; " . date("Y") . " Lexora Tech Website. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ";

        // Headers for HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: no-reply@lexoratech.com" . "\r\n"; // Ideally use a domain email

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