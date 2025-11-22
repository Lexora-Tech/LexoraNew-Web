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
        $to = "info@lexoratech.com"; // REPLACE WITH YOUR EMAIL
        $subject = "New Quote Request From " . $name;
        
    // --- Professional Email Template ---
    
    // Get current date/time for the record
    $submission_date = date("F j, Y, g:i a"); 

    $email_message = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>New Lead: $name</title>
        <style>
            /* Reset styles for email clients */
            body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
            table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
            img { -ms-interpolation-mode: bicubic; }
            
            /* General Styles */
            body { margin: 0; padding: 0; width: 100% !important; height: 100% !important; background-color: #f4f4f4; font-family: 'Arial', sans-serif; color: #333333; }
            .email-container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 0px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
            
            /* Typography */
            h1 { font-size: 22px; font-weight: 700; margin: 0; color: #121212; }
            h2 { font-size: 16px; font-weight: 600; margin: 0 0 10px 0; color: #ffb400; text-transform: uppercase; letter-spacing: 1px; }
            p { margin: 0 0 15px 0; line-height: 1.6; font-size: 14px; }
            
            /* Data Tables */
            .data-table { width: 100%; border-collapse: collapse; }
            .data-table td { padding: 12px 0; vertical-align: top; border-bottom: 1px solid #eeeeee; }
            .data-label { width: 35%; font-weight: bold; color: #666666; font-size: 13px; text-transform: uppercase; }
            .data-value { width: 65%; color: #000000; font-size: 15px; font-weight: 500; }
            
            /* Components */
            .budget-tag { display: inline-block; background-color: #121212; color: #ffb400; padding: 4px 10px; border-radius: 4px; font-weight: bold; font-size: 14px; }
            .btn-reply { display: inline-block; padding: 12px 25px; background-color: #ffb400; color: #000000; text-decoration: none; font-weight: bold; border-radius: 4px; margin-top: 20px; }
            
            /* Footer */
            .footer { padding: 30px; text-align: center; font-size: 12px; color: #999999; background-color: #f4f4f4; }
        </style>
    </head>
    <body>

        <div style='display:none;font-size:1px;color:#333333;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;'>
            New quote request from $name ($company). Budget: $budget.
        </div>

        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
            <tr>
                <td align='center' style='padding: 40px 0;'>
                    
                    <table class='email-container' border='0' cellpadding='0' cellspacing='0' width='600'>
                        
                        <tr>
                            <td style='background-color: #121212; padding: 30px; text-align: center; border-bottom: 4px solid #ffb400;'>
                                <h1 style='color: #ffffff; letter-spacing: 2px;'>LEXORA TECH</h1>
                            </td>
                        </tr>

                        <tr>
                            <td style='padding: 40px 30px 20px 30px;'>
                                <p style='font-size: 18px; color: #333;'><strong>New Project Inquiry</strong></p>
                                <p style='color: #666;'>You Have Received A New Lead Via The Website Quote Form. Here Are The Project Details Submitted On $submission_date.</p>
                            </td>
                        </tr>

                        <tr>
                            <td style='padding: 0 30px;'>
                                <h2>Client Details</h2>
                                <table class='data-table' border='0' cellpadding='0' cellspacing='0'>
                                    <tr>
                                        <td class='data-label'>Full Name</td>
                                        <td class='data-value'>$name</td>
                                    </tr>
                                    <tr>
                                        <td class='data-label'>Email</td>
                                        <td class='data-value'><a href='mailto:$email' style='color:#000; text-decoration:none;'>$email</a></td>
                                    </tr>
                                    <tr>
                                        <td class='data-label'>Phone</td>
                                        <td class='data-value'>$phone</td>
                                    </tr>
                                    <tr>
                                        <td class='data-label'>Company</td>
                                        <td class='data-value'>$company</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td style='padding: 30px 30px;'>
                                <h2>Project Scope</h2>
                                <table class='data-table' border='0' cellpadding='0' cellspacing='0'>
                                    <tr>
                                        <td class='data-label' style='border-bottom: none;'>Services</td>
                                        <td class='data-value' style='border-bottom: none; line-height: 1.6;'>$services_string</td>
                                    </tr>
                                    <tr>
                                        <td colspan='2' style='padding-top: 15px; border-bottom: none;'>
                                            <span class='budget-tag'>Budget: $budget</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td style='padding: 0 30px 40px 30px;'>
                                <h2>Message / Notes</h2>
                                <div style='background-color: #f9f9f9; padding: 20px; border-left: 4px solid #ffb400; border-radius: 4px; font-style: italic; color: #555;'>
                                    \"$message\"
                                </div>
                                <div style='text-align: center;'>
                                    <a href='mailto:$email?subject=Re: Project Inquiry - Lexora Tech' class='btn-reply'>Reply To Client</a>
                                </div>
                            </td>
                        </tr>

                    </table>
                    <div class='footer'>
                        <p>&copy; " . date("Y") . " Lexora Tech Internal System.<br>
                        This is an automated notification.</p>
                    </div>

                </td>
            </tr>
        </table>

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