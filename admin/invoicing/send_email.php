<?php
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");
require_once(__DIR__ . "/../../vendor/autoload.php");
require_once(__DIR__ . "/pdf_builder.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_GET['type']) || !isset($_GET['id'])) {
    header("Location: billing_dashboard.php");
    exit();
}

$type = $_GET['type']; // 'quotation', 'invoice', or 'receipt'
$id = intval($_GET['id']);
$error = '';
$success = '';

// Get company settings
$cs_q = mysqli_query($conn, "SELECT * FROM company_settings WHERE id=1");
$company = mysqli_fetch_assoc($cs_q);
if (!$company)
    $company = ['company_name' => 'Lexora Tech', 'company_email' => 'info@lexoratech.com', 'smtp_host' => '', 'smtp_port' => 587, 'smtp_username' => '', 'smtp_password' => '', 'smtp_encryption' => 'tls', 'smtp_from_name' => 'Lexora Tech', 'smtp_from_email' => 'info@lexoratech.com'];

// Get document info
if ($type === 'receipt') {
    $q = mysqli_query($conn, "SELECT p.*, i.invoice_number, i.grand_total, i.amount_paid, c.name as customer_name, c.email as customer_email FROM payments p JOIN invoices i ON p.invoice_id=i.id LEFT JOIN customers c ON i.customer_id=c.id WHERE p.id=$id");
    $doc = mysqli_fetch_assoc($q);
    $doc_number = 'REC-' . str_pad($id, 6, '0', STR_PAD_LEFT);
    $doc_label = 'Payment Receipt';
    $redirect = "invoice_view.php?id=" . ($doc['invoice_id'] ?? '');
}
elseif ($type === 'quotation') {
    $q = mysqli_query($conn, "SELECT q.*, c.name as customer_name, c.email as customer_email FROM quotations q LEFT JOIN customers c ON q.customer_id=c.id WHERE q.id=$id");
    $doc = mysqli_fetch_assoc($q);
    $doc_number = $doc['quotation_number'] ?? '';
    $doc_label = 'Quotation';
    $redirect = "quotation_view.php?id=$id";
}
else {
    $q = mysqli_query($conn, "SELECT i.*, c.name as customer_name, c.email as customer_email FROM invoices i LEFT JOIN customers c ON i.customer_id=c.id WHERE i.id=$id");
    $doc = mysqli_fetch_assoc($q);
    $doc_number = $doc['invoice_number'] ?? '';
    $doc_label = 'Invoice';
    $redirect = "invoice_view.php?id=$id";
}

if (!$doc) {
    header("Location: billing_dashboard.php");
    exit();
}

// Build email defaults
$default_subject = "$doc_label $doc_number from " . ($company['company_name'] ?? 'Lexora Tech');
if ($type === 'receipt') {
    $default_body = "Dear " . ($doc['customer_name'] ?? '') . ",\n\nThank you for your payment. Please find your payment receipt attached.\n\nReceipt: $doc_number\nAmount: LKR " . number_format($doc['amount'], 2) . "\nInvoice: " . ($doc['invoice_number'] ?? '') . "\n\nThank you for your business!\n\nBest regards,\n" . ($company['company_name'] ?? 'Lexora Tech');
}
else {
    $default_body = "Dear " . ($doc['customer_name'] ?? '') . ",\n\nPlease find attached " . strtolower($doc_label) . " $doc_number for your review.\n\nTotal Amount: LKR " . number_format($doc['grand_total'], 2) . "\n\nIf you have any questions, please don't hesitate to contact us.\n\nBest regards,\n" . ($company['company_name'] ?? 'Lexora Tech');
}

// Process sending
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to_email = $_POST['to_email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $body = $_POST['body'] ?? '';
    $attach_pdf = isset($_POST['attach_pdf']);

    if (empty($to_email) || empty($subject)) {
        $error = 'Email and subject are required.';
    }
    else {
        $smtp_host = $company['smtp_host'] ?? '';
        if (empty($smtp_host)) {
            $error = 'SMTP not configured. Edit the company_settings table in phpMyAdmin to add your SMTP details (smtp_host, smtp_port, smtp_username, smtp_password).';
        }
        else {
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = $company['smtp_host'];
                $mail->SMTPAuth = true;
                $mail->Username = $company['smtp_username'];
                $mail->Password = $company['smtp_password'];
                $mail->SMTPSecure = ($company['smtp_encryption'] === 'ssl') ?PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = intval($company['smtp_port'] ?? 587);

                $mail->setFrom($company['smtp_from_email'] ?? $company['company_email'], $company['smtp_from_name'] ?? $company['company_name']);
                $mail->addAddress($to_email);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = nl2br(htmlspecialchars($body));
                $mail->AltBody = $body;

                // Generate & attach PDF using shared builder
                if ($attach_pdf) {
                    if ($type === 'receipt') {
                        $pdf = buildReceiptPDF($conn, $id);
                    }
                    else {
                        $pdf = buildDocumentPDF($conn, $type, $id);
                    }
                    if ($pdf) {
                        $tempPdf = tempnam(sys_get_temp_dir(), 'lexora_') . '.pdf';
                        $pdf->Output($tempPdf, 'F');
                        $mail->addAttachment($tempPdf, $doc_number . '.pdf', 'base64', 'application/pdf');
                    }
                }

                $mail->send();

                // Auto-update status from draft to sent
                if ($type === 'quotation' && ($doc['status'] ?? '') === 'draft') {
                    $conn->query("UPDATE quotations SET status='sent' WHERE id=$id");
                }
                elseif ($type === 'invoice' && ($doc['status'] ?? '') === 'draft') {
                    $conn->query("UPDATE invoices SET status='sent' WHERE id=$id");
                }

                // Cleanup temp PDF
                if (isset($tempPdf) && file_exists($tempPdf))
                    unlink($tempPdf);

                $success = 'Email sent successfully!';
            }
            catch (Exception $e) {
                $error = 'Failed to send: ' . $mail->ErrorInfo;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email | Lexora Admin</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../img/logo/logo.png" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #ffb400;
            --primary-hover: #e5a300;
            --bg-body: #f8f9fa;
            --bg-sidebar: #121212;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --danger: #ef4444;
            --success: #10b981;
            --sidebar-width: 260px;
            --header-height: 70px
        }

        body.dark {
            --bg-body: #0b0b0b;
            --bg-sidebar: #000000;
            --bg-card: #1e1e1e;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border: #333333
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif
        }

        body {
            background: var(--bg-body);
            color: var(--text-main);
            transition: 0.3s ease
        }

        a {
            text-decoration: none;
            color: inherit
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh
        }

        .sidebar {
            width: var(--sidebar-width);
            background: var(--bg-sidebar);
            color: #fff;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            padding: 20px;
            border-right: 1px solid rgba(255, 255, 255, 0.05)
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
            padding: 0 10px
        }

        .brand img {
            height: 32px
        }

        .brand span {
            font-size: 18px;
            font-weight: 700;
            color: #fff
        }

        .menu-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 10px;
            padding-left: 10px;
            font-weight: 600;
            letter-spacing: 1px
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: 8px;
            color: #a0a0a0;
            transition: 0.3s;
            margin-bottom: 5px
        }

        .nav-item:hover,
        .nav-item.active {
            background: rgba(255, 180, 0, 0.1);
            color: var(--primary)
        }

        .nav-item i {
            width: 20px;
            text-align: center;
            font-size: 16px
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1)
        }

        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column
        }

        header {
            height: var(--header-height);
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 90
        }

        .header-left h2 {
            font-size: 20px;
            font-weight: 600
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px
        }

        .avatar {
            width: 35px;
            height: 35px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-weight: bold
        }

        .theme-switch {
            position: relative;
            width: 40px;
            height: 20px;
            cursor: pointer
        }

        .theme-switch input {
            display: none
        }

        .slider {
            position: absolute;
            inset: 0;
            background: #ccc;
            border-radius: 20px;
            transition: .4s
        }

        .slider:before {
            content: "";
            position: absolute;
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background: white;
            border-radius: 50%;
            transition: .4s
        }

        input:checked+.slider {
            background: var(--primary)
        }

        input:checked+.slider:before {
            transform: translateX(20px)
        }

        .content-wrapper {
            padding: 30px;
            max-width: 700px
        }

        .form-container {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 40px
        }

        .form-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border)
        }

        .form-group {
            margin-bottom: 20px
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 8px
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--bg-body);
            color: var(--text-main);
            font-size: 14px;
            outline: none
        }

        .form-input:focus,
        .form-textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 180, 0, 0.1)
        }

        .form-textarea {
            min-height: 180px;
            resize: vertical;
            font-family: 'Plus Jakarta Sans', sans-serif
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px
        }

        .checkbox-group input {
            width: 18px;
            height: 18px;
            accent-color: var(--primary)
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2)
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2)
        }

        .btn-row {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 25px
        }

        .btn-primary {
            background: var(--primary);
            color: #000;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px
        }

        .btn-primary:hover {
            background: var(--primary-hover)
        }

        .btn-secondary {
            background: var(--bg-body);
            color: var(--text-main);
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            border: 1px solid var(--border);
            cursor: pointer
        }

        @media(max-width:900px) {
            .sidebar {
                transform: translateX(-100%)
            }

            .sidebar.active {
                transform: translateX(0)
            }

            .main-content {
                margin-left: 0
            }

            .menu-toggle {
                display: block;
                font-size: 24px;
                cursor: pointer;
                margin-right: 15px
            }
        }

        @media(min-width:901px) {
            .menu-toggle {
                display: none
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <aside class="sidebar" id="sidebar">
            <div class="brand"><img src="../../img/logo/logo.jpg" alt="Logo"><span>Lexora Admin</span></div>
            <div class="menu-label">Main Menu</div>
            <a href="../dashboard.php" class="nav-item"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            <a href="../all_blogs.php" class="nav-item"><i class="fas fa-layer-group"></i> <span>All Blogs</span></a>
            <div class="menu-label" style="margin-top:20px;">Billing</div>
            <a href="billing_dashboard.php" class="nav-item"><i class="fas fa-chart-pie"></i> <span>Overview</span></a>
            <a href="quotations.php" class="nav-item"><i class="fas fa-file-invoice"></i> <span>Quotations</span></a>
            <a href="invoices.php" class="nav-item"><i class="fas fa-file-invoice-dollar"></i> <span>Invoices</span></a>
            <a href="customers.php" class="nav-item"><i class="fas fa-users"></i> <span>Customers</span></a>
            <div class="menu-label" style="margin-top:20px;">System</div>
            <a href="../settings.php" class="nav-item"><i class="fas fa-cog"></i> <span>Settings</span></a>
            <a href="../quote_requests.php" class="nav-item"><i class="fas fa-envelope"></i> <span>Inquiries</span></a>
            <div class="sidebar-footer"><a href="../logout.php" class="nav-item" style="color:var(--danger);"><i
                        class="fas fa-sign-out-alt"></i> <span>Logout</span></a></div>
        </aside>
        <div class="main-content">
            <header>
                <div class="header-left" style="display:flex;align-items:center;"><i class="fas fa-bars menu-toggle"
                        id="menuToggle"></i>
                    <h2>Send
                        <?= $doc_label?> via Email
                    </h2>
                </div>
                <div class="header-right">
                    <label class="theme-switch"><input type="checkbox" id="themeToggle"><span
                            class="slider"></span></label>
                    <div class="avatar">
                        <?= strtoupper(substr($_SESSION['admin'], 0, 1))?>
                    </div>
                </div>
            </header>
            <div class="content-wrapper">
                <?php if ($error): ?>
                <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i>
                    <?= htmlspecialchars($error)?>
                </div>
                <?php
endif; ?>
                <?php if ($success): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle"></i>
                    <?= htmlspecialchars($success)?> <a href="<?= $redirect?>"
                        style="color:var(--primary);font-weight:600;margin-left:10px;">← Back to
                        <?= $doc_label?>
                    </a>
                </div>
                <?php
endif; ?>

                <form action="" method="POST" class="form-container">
                    <div class="form-title"><i class="fas fa-paper-plane"
                            style="color:var(--primary);margin-right:10px;"></i>Send
                        <?= $doc_label?> #
                        <?= htmlspecialchars($doc_number)?>
                    </div>
                    <div class="form-group">
                        <label class="form-label">To Email *</label>
                        <input type="email" name="to_email" class="form-input"
                            value="<?= htmlspecialchars($doc['customer_email'] ?? '')?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subject *</label>
                        <input type="text" name="subject" class="form-input"
                            value="<?= htmlspecialchars($default_subject)?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Message</label>
                        <textarea name="body" class="form-textarea"><?= htmlspecialchars($default_body)?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-group"><input type="checkbox" name="attach_pdf" checked><span>Attach PDF
                                (full document with bank details)</span></label>
                    </div>
                    <div class="btn-row">
                        <a href="<?= $redirect?>" class="btn-secondary">Cancel</a>
                        <button type="submit" class="btn-primary"><i class="fas fa-paper-plane"></i> Send Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
const menuToggle=document.getElementById('menuToggle'),side.getElementById('sidebar');if(menuToggle)menuToggle.addEventListener('click',()=>sidebar.classList.toggle('active'));
const themeToggle=document.getElementById("themeToggle");if(localStorage.getItem("theme")==="dark"){document.body.classList.add("dark");themeToggle.checked=true;}themeToggle.addEventListener("change",()=>{if(themeToggle.checked){document.body.classList.add("dark");localStorage.setItem("theme","dark");}else{document.body.classList.remove("dark");localStorage.setItem("theme","light");}});
    </script>
</body>

</html>