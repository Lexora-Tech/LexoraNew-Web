<?php
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");
require_once(__DIR__ . "/../../vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!isset($_GET['type']) || !isset($_GET['id'])) {
    header("Location: billing_dashboard.php");
    exit();
}

$type = $_GET['type'];
$id = intval($_GET['id']);
$error = '';
$success = '';

// Get company settings (SMTP)
$cs_q = mysqli_query($conn, "SELECT * FROM company_settings WHERE id=1");
$company = mysqli_fetch_assoc($cs_q);

// Get document & customer info
if ($type === 'quotation') {
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
        // Check SMTP settings
        $smtp_host = $company['smtp_host'] ?? '';
        if (empty($smtp_host)) {
            $error = 'SMTP not configured. Go to Billing Settings (company_settings table) and fill in SMTP details.';
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
                $mail->Body = nl2br($body);

                // Attach PDF
                if ($attach_pdf) {
                    // Generate PDF inline
                    $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
                    $pdf->setPrintHeader(false);
                    $pdf->setPrintFooter(false);
                    $pdf->SetMargins(20, 20, 20);
                    $pdf->AddPage();

                    // Company Header
                    $pdf->SetFont('helvetica', 'B', 20);
                    $pdf->SetTextColor(255, 180, 0);
                    $pdf->Cell(0, 10, $company['company_name'] ?? 'Lexora Tech', 0, 1, 'L');

                    // Doc title
                    $pdf->SetFont('helvetica', 'B', 14);
                    $pdf->SetTextColor(30, 41, 59);
                    $pdf->Cell(85, 8, strtoupper($doc_label), 0, 0, 'L');
                    $pdf->Cell(85, 8, $doc_number, 0, 1, 'R');
                    $pdf->SetDrawColor(255, 180, 0);
                    $pdf->SetLineWidth(0.6);
                    $pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY());
                    $pdf->Ln(6);

                    // Customer
                    $pdf->SetFont('helvetica', 'B', 9);
                    $pdf->SetTextColor(100, 100, 100);
                    $pdf->Cell(85, 5, 'BILL TO', 0, 1, 'L');
                    $pdf->SetFont('helvetica', '', 10);
                    $pdf->SetTextColor(30, 41, 59);
                    $pdf->Cell(0, 5, $doc['customer_name'] ?? 'N/A', 0, 1, 'L');
                    $pdf->Cell(0, 5, $doc['customer_email'] ?? '', 0, 1, 'L');
                    $pdf->Ln(4);

                    // Dates
                    $pdf->SetFont('helvetica', '', 10);
                    $pdf->Cell(0, 5, 'Date: ' . date("M d, Y", strtotime($doc['issue_date'])), 0, 1, 'L');
                    $pdf->Cell(0, 5, 'Status: ' . ucfirst($doc['status']), 0, 1, 'L');
                    $pdf->Ln(6);

                    // Items table
                    $items_q2 = mysqli_query($conn, "SELECT * FROM invoice_items WHERE item_type='$type' AND parent_id=$id ORDER BY sort_order ASC");
                    $pdf->SetFillColor(255, 180, 0);
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetFont('helvetica', 'B', 9);
                    $pdf->Cell(10, 7, '#', 1, 0, 'C', true);
                    $pdf->Cell(70, 7, 'Description', 1, 0, 'L', true);
                    $pdf->Cell(20, 7, 'Qty', 1, 0, 'C', true);
                    $pdf->Cell(25, 7, 'Price', 1, 0, 'R', true);
                    $pdf->Cell(20, 7, 'Tax %', 1, 0, 'C', true);
                    $pdf->Cell(25, 7, 'Total', 1, 1, 'R', true);

                    $pdf->SetFont('helvetica', '', 9);
                    $pdf->SetTextColor(50, 50, 50);
                    $n = 1;
                    while ($it = mysqli_fetch_assoc($items_q2)) {
                        $pdf->Cell(10, 6, $n, 1, 0, 'C');
                        $pdf->Cell(70, 6, $it['description'], 1, 0, 'L');
                        $pdf->Cell(20, 6, number_format($it['quantity'], 2), 1, 0, 'C');
                        $pdf->Cell(25, 6, number_format($it['unit_price'], 2), 1, 0, 'R');
                        $pdf->Cell(20, 6, number_format($it['tax_rate'], 2) . '%', 1, 0, 'C');
                        $pdf->Cell(25, 6, number_format($it['line_total'], 2), 1, 1, 'R');
                        $n++;
                    }

                    $pdf->Ln(4);
                    $pdf->SetFont('helvetica', 'B', 12);
                    $pdf->SetTextColor(255, 180, 0);
                    $pdf->Cell(120, 8, '', 0, 0);
                    $pdf->Cell(25, 8, 'TOTAL:', 0, 0, 'R');
                    $pdf->Cell(25, 8, 'LKR ' . number_format($doc['grand_total'], 2), 0, 1, 'R');

                    // Save to temp file
                    $tempPdf = tempnam(sys_get_temp_dir(), 'lexora_') . '.pdf';
                    $pdf->Output($tempPdf, 'F');
                    $mail->addAttachment($tempPdf, $doc_number . '.pdf', 'base64', 'application/pdf');
                }

                $mail->send();

                // Update status to 'sent'
                if ($type === 'quotation' && $doc['status'] === 'draft') {
                    $conn->query("UPDATE quotations SET status='sent' WHERE id=$id");
                }
                elseif ($type === 'invoice' && $doc['status'] === 'draft') {
                    $conn->query("UPDATE invoices SET status='sent' WHERE id=$id");
                }

                if (isset($tempPdf) && file_exists($tempPdf))
                    unlink($tempPdf);

                $success = 'Email sent successfully!';
            }
            catch (Exception $e) {
                $error = 'Failed to send email: ' . $mail->ErrorInfo;
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
            min-height: 150px;
            resize: vertical
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
                            value="<?= $doc_label?> <?= htmlspecialchars($doc_number)?> from <?= htmlspecialchars($company['company_name'] ?? 'Lexora Tech')?>"
                            required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Message</label>
                        <textarea name="body" class="form-textarea">Dear <?= htmlspecialchars($doc['customer_name'] ?? '')?>,

Please find attached <?= strtolower($doc_label)?> <?= htmlspecialchars($doc_number)?> for your review.

Total Amount: LKR <?= number_format($doc['grand_total'], 2)?>

If you have any questions, please don't hesitate to contact us.

Best regards,
<?= htmlspecialchars($company['company_name'] ?? 'Lexora Tech')?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-group">
                            <input type="checkbox" name="attach_pdf" checked>
                            <span>Attach PDF</span>
                        </label>
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
        const menuToggle = document.getElementById('menuToggle'), sidebar = document.getElementById('sidebar'); if (menuToggle) menuToggle.addEventListener('click', () => sidebar.classList.toggle('active'));
        const themeToggle = document.getElementById("themeToggle"); if (localStorage.getItem("theme") === "dark") { document.body.classList.add("dark"); themeToggle.checked = true; } themeToggle.addEventListener("change", () => { if (themeToggle.checked) { document.body.classList.add("dark"); localStorage.setItem("theme", "dark"); } else { document.body.classList.remove("dark"); localStorage.setItem("theme", "light"); } });
    </script>
</body>

</html>