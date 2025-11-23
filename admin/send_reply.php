<?php
include("../includes/auth.php");
include("../includes/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id = intval($_POST['id']);
    $to_email = $_POST['email'];
    $subject = $_POST['subject'];
    $message_body = $_POST['message'];

    // --- CONFIGURATION ---
    // REPLACE THIS with your actual website URL
    $domain_url = "https://lexoratech.com"; 
    $logo_url = $domain_url . "/img/logo/logo.jpg"; 

    // --- HTML EMAIL TEMPLATE ---
    $final_message = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <style>
            body { margin: 0; padding: 0; background-color: #f4f4f4; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; }
            .wrapper { width: 100%; table-layout: fixed; background-color: #f4f4f4; padding-bottom: 40px; }
            .webkit { max-width: 600px; background-color: #ffffff; margin: 0 auto; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
            .outer { margin: 0 auto; width: 100%; max-width: 600px; }
            
            /* Header */
            .header { background-color: #121212; padding: 30px 20px; text-align: center; border-bottom: 4px solid #ffb400; }
            
            /* Body */
            .content { padding: 40px 30px; color: #333333; line-height: 1.6; font-size: 16px; }
            .content p { margin-bottom: 20px; }
            .content a { color: #ffb400; text-decoration: none; font-weight: bold; }
            
            /* Footer */
            .footer { background-color: #eeeeee; padding: 20px; text-align: center; font-size: 12px; color: #888888; border-top: 1px solid #e0e0e0; }
            .footer a { color: #555555; text-decoration: underline; }
            
            /* Responsive */
            @media screen and (max-width: 600px) {
                .content { padding: 20px; }
            }
        </style>
    </head>
    <body>
        <div class='wrapper'>
            <div class='webkit'>
                <!-- Header with Logo & Text Side-by-Side -->
                <div class='header'>
                    <table align='center' border='0' cellpadding='0' cellspacing='0' style='margin: 0 auto;'>
                        <tr>
                            <td style='vertical-align: middle; padding-right: 15px;'>
                                <img src='$logo_url' alt='Logo' width='50' style='display:block; border:0; height:auto; border-radius:50%;'>
                            </td>
                            <td style='vertical-align: middle; color: #ffffff; font-size: 24px; font-weight: bold; letter-spacing: 1px;'>
                                Lexora Tech
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Main Message Content -->
                <div class='content'>
                    " . nl2br($message_body) . "
                </div>

                <!-- Footer -->
                <div class='footer'>
                    <p>&copy; " . date("Y") . " Lexora Tech. All rights reserved.</p>
                    <p>
                        <a href='$domain_url'>Visit Website</a> | 
                        <a href='mailto:info@lexoratech.com'>Contact Support</a>
                    </p>
                    <p>Gampaha Town, Sri Lanka, 11000</p>
                </div>
            </div>
        </div>
    </body>
    </html>";

    // --- HEADERS ---
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Lexora Tech <info@lexoratech.com>" . "\r\n";
    $headers .= "Reply-To: info@lexoratech.com" . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // --- SEND ---
    if(mail($to_email, $subject, $final_message, $headers)) {
        
        // Update status in database
        $update_sql = "UPDATE quote_requests SET status='replied' WHERE id=$id";
        mysqli_query($conn, $update_sql);
        
        echo "success";
    } else {
        http_response_code(500);
        echo "Server failed to send email.";
    }
}
?>