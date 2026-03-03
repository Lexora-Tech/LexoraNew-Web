<?php
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    header("Location: agreements.php");
    exit();
}

$agr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT a.*, c.name as customer_name, c.company as customer_company, c.email as customer_email, c.phone as customer_phone, c.address as customer_address, c.city as customer_city, c.country as customer_country, i.invoice_number, i.grand_total, i.currency FROM service_agreements a LEFT JOIN customers c ON a.customer_id=c.id LEFT JOIN invoices i ON a.invoice_id=i.id WHERE a.id=$id"));
if (!$agr) {
    header("Location: agreements.php?msg=" . urlencode("Not found"));
    exit();
}

$cs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM company_settings WHERE id=1"));
if (!$cs)
    $cs = ['company_name' => 'Lexora Tech', 'company_email' => '', 'company_phone' => '', 'company_address' => '', 'company_website' => ''];
$msg = $_GET['msg'] ?? '';
$custAddr = trim(($agr['customer_address'] ?? '') . ($agr['customer_city'] ? ', ' . $agr['customer_city'] : '') . ($agr['customer_country'] ? ', ' . $agr['customer_country'] : ''), ', ');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Agreement
        <?= htmlspecialchars($agr['agreement_number'])?> — Lexora Admin
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-primary)
        }

        :root {
            --bg-body: #f4f4f5;
            --bg-card: #fff;
            --bg-sidebar: #121212;
            --text-primary: #1a1a1a;
            --text-secondary: #6b7280;
            --border: #e5e7eb;
            --primary: #ffb400;
            --success: #10b981;
            --danger: #ef4444;
            --sidebar-width: 260px
        }

        @media(prefers-color-scheme:dark) {
            :root {
                --bg-body: #0a0a0a;
                --bg-card: #1a1a1a;
                --bg-sidebar: #000;
                --text-primary: #f5f5f5;
                --text-secondary: #9ca3af;
                --border: #2d2d2d
            }
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh
        }

        .sidebar {
            width: var(--sidebar-width);
            background: var(--bg-sidebar);
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
            margin-bottom: 10px
        }

        .brand img {
            width: 36px;
            height: 36px;
            border-radius: 8px
        }

        .brand span {
            color: #fff;
            font-weight: 700;
            font-size: 15px
        }

        .menu-label {
            color: rgba(255, 255, 255, .4);
            font-size: 11px;
            font-weight: 600;
            padding: 12px 20px 6px;
            text-transform: uppercase;
            letter-spacing: 1px
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            color: rgba(255, 255, 255, .65);
            text-decoration: none;
            font-size: 13.5px;
            transition: all .2s
        }

        .nav-item:hover,
        .nav-item.active {
            background: rgba(255, 180, 0, .12);
            color: #ffb400
        }

        .nav-item i {
            width: 18px;
            text-align: center
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, .1)
        }

        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 30px
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px
        }

        .btn {
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .2s;
            border: none;
            cursor: pointer
        }

        .btn-primary {
            background: var(--primary);
            color: #000
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-primary)
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary)
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 13px;
            background: rgba(16, 185, 129, .12);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, .2)
        }

        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase
        }

        .badge-draft {
            background: rgba(107, 114, 128, .15);
            color: #6b7280
        }

        .badge-sent {
            background: rgba(59, 130, 246, .15);
            color: #3b82f6
        }

        .badge-signed {
            background: rgba(16, 185, 129, .15);
            color: #10b981
        }

        .badge-cancelled {
            background: rgba(239, 68, 68, .15);
            color: #ef4444
        }

        /* Legal document styles */
        .legal-doc {
            background: var(--bg-card);
            border-radius: 12px;
            border: 1px solid var(--border);
            max-width: 800px;
            margin: 0 auto;
            overflow: hidden
        }

        .legal-header {
            background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
            color: #fff;
            padding: 40px;
            text-align: center;
            position: relative
        }

        .legal-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary)
        }

        .legal-header h1 {
            font-size: 24px;
            letter-spacing: 3px;
            margin-bottom: 8px
        }

        .legal-header .agr-num {
            font-size: 13px;
            color: var(--primary);
            letter-spacing: 1px
        }

        .legal-body {
            padding: 40px
        }

        .legal-section {
            margin-bottom: 28px
        }

        .legal-section h3 {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--primary);
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 2px solid var(--primary);
            display: inline-block
        }

        .legal-text {
            font-size: 13.5px;
            line-height: 1.8;
            color: var(--text-primary);
            white-space: pre-wrap
        }

        .parties-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin: 16px 0
        }

        .party-box {
            padding: 16px;
            border: 1px solid var(--border);
            border-radius: 8px
        }

        .party-box h4 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--primary);
            margin-bottom: 8px
        }

        .party-box p {
            font-size: 13px;
            line-height: 1.6;
            color: var(--text-secondary)
        }

        .sig-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 40px
        }

        .sig-box {
            text-align: center;
            padding-top: 20px
        }

        .sig-line {
            border-top: 2px solid var(--text-primary);
            margin: 40px 20px 8px;
            padding-top: 8px
        }

        .sig-label {
            font-size: 12px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: .5px
        }

        .sig-name {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 2px
        }

        .menu-toggle {
            display: none;
            font-size: 20px;
            cursor: pointer;
            color: var(--text-primary);
            margin-right: 15px
        }

        @media(max-width:900px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform .3s
            }

            .sidebar.active {
                transform: translateX(0)
            }

            .main-content {
                margin-left: 0
            }

            .menu-toggle {
                display: block
            }

            .parties-grid,
            .sig-grid {
                grid-template-columns: 1fr
            }
        }

        @media print {

            .sidebar,
            .no-print {
                display: none !important
            }

            .main-content {
                margin: 0 !important;
                padding: 10px !important
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
            <a href="../add_blog.php" class="nav-item"><i class="fas fa-plus-circle"></i> <span>Add New</span></a>
            <div class="menu-label" style="margin-top:20px;">Billing</div>
            <a href="billing_dashboard.php" class="nav-item"><i class="fas fa-chart-pie"></i> <span>Overview</span></a>
            <a href="quotations.php" class="nav-item"><i class="fas fa-file-invoice"></i> <span>Quotations</span></a>
            <a href="invoices.php" class="nav-item"><i class="fas fa-file-invoice-dollar"></i> <span>Invoices</span></a>
            <a href="agreements.php" class="nav-item active"><i class="fas fa-file-contract"></i>
                <span>Agreements</span></a>
            <a href="customers.php" class="nav-item"><i class="fas fa-users"></i> <span>Customers</span></a>
            <div class="menu-label" style="margin-top:20px;">System</div>
            <a href="../settings.php" class="nav-item"><i class="fas fa-cog"></i> <span>Settings</span></a>
            <a href="../quote_requests.php" class="nav-item"><i class="fas fa-envelope"></i> <span>Inquiries</span></a>
            <div class="sidebar-footer"><a href="../logout.php" class="nav-item" style="color:var(--danger);"><i
                        class="fas fa-sign-out-alt"></i> <span>Logout</span></a></div>
        </aside>
        <div class="main-content">
            <header class="no-print">
                <div style="display:flex;align-items:center;">
                    <i class="fas fa-bars menu-toggle" id="menuToggle"></i>
                    <h2>
                        <?= htmlspecialchars($agr['agreement_number'])?>
                    </h2>
                    <span class="badge badge-<?= $agr['status']?>" style="margin-left:12px;">
                        <?= ucfirst($agr['status'])?>
                    </span>
                </div>
                <div style="display:flex;gap:10px;">
                    <a href="agreement_form.php?id=<?= $id?>" class="btn btn-outline"><i class="fas fa-pen"></i>
                        Edit</a>
                    <a href="generate_pdf.php?type=agreement&id=<?= $id?>" class="btn btn-outline" target="_blank"><i
                            class="fas fa-file-pdf"></i> PDF</a>
                    <a href="send_email.php?type=agreement&id=<?= $id?>" class="btn btn-primary"><i
                            class="fas fa-paper-plane"></i> Send</a>
                    <button onclick="window.print()" class="btn btn-outline"><i class="fas fa-print"></i> Print</button>
                </div>
            </header>
            <?php if ($msg): ?>
            <div class="alert no-print">
                <?= htmlspecialchars($msg)?>
            </div>
            <?php
endif; ?>

            <div class="legal-doc">
                <div class="legal-header">
                    <h1>SERVICE AGREEMENT</h1>
                    <div class="agr-num">
                        <?= htmlspecialchars($agr['agreement_number'])?>
                    </div>
                </div>
                <div class="legal-body">
                    <!-- Effective Date -->
                    <div class="legal-section">
                        <p class="legal-text">This Service Agreement (the "Agreement") is entered into as of <strong>
                                <?= $agr['effective_date'] ? date("F d, Y", strtotime($agr['effective_date'])) : '_______________'?>
                            </strong> (the "Effective Date").</p>
                    </div>

                    <!-- Parties -->
                    <div class="legal-section">
                        <h3>1. Parties</h3>
                        <div class="parties-grid">
                            <div class="party-box">
                                <h4>Service Provider</h4>
                                <p><strong>
                                        <?= htmlspecialchars($cs['company_name'])?>
                                    </strong><br>
                                    <?= htmlspecialchars($cs['company_email'] ?? '')?><br>
                                    <?= htmlspecialchars($cs['company_phone'] ?? '')?><br>
                                    <?= htmlspecialchars($cs['company_address'] ?? '')?>
                                </p>
                            </div>
                            <div class="party-box">
                                <h4>Client</h4>
                                <p><strong>
                                        <?= htmlspecialchars($agr['customer_name'] ?? '')?>
                                    </strong><br>
                                    <?php if ($agr['customer_company']): ?>
                                    <?= htmlspecialchars($agr['customer_company'])?><br>
                                    <?php
endif; ?>
                                    <?= htmlspecialchars($agr['customer_email'] ?? '')?><br>
                                    <?= htmlspecialchars($agr['customer_phone'] ?? '')?><br>
                                    <?= htmlspecialchars($custAddr)?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Scope -->
                    <?php if ($agr['scope_of_services']): ?>
                    <div class="legal-section">
                        <h3>2. Scope of Services</h3>
                        <p class="legal-text">
                            <?= htmlspecialchars($agr['scope_of_services'])?>
                        </p>
                    </div>
                    <?php
endif; ?>

                    <!-- Timeline -->
                    <div class="legal-section">
                        <h3>3. Project Timeline</h3>
                        <p class="legal-text">Start Date: <strong>
                                <?= $agr['project_start_date'] ? date("F d, Y", strtotime($agr['project_start_date'])) : 'TBD'?>
                            </strong>
                            End Date: <strong>
                                <?= $agr['project_end_date'] ? date("F d, Y", strtotime($agr['project_end_date'])) : 'TBD'?>
                            </strong></p>
                    </div>

                    <!-- Payment Terms -->
                    <?php if ($agr['payment_terms_text']): ?>
                    <div class="legal-section">
                        <h3>4. Payment Terms</h3>
                        <p class="legal-text">
                            <?= htmlspecialchars($agr['payment_terms_text'])?>
                        </p>
                    </div>
                    <?php
endif; ?>

                    <?php
$sections = [
    [5, 'Late Payment Policy', $agr['late_payment_policy']],
    [6, 'Confidentiality', $agr['confidentiality_clause']],
    [7, 'Intellectual Property', $agr['ip_clause']],
    [8, 'Termination', $agr['termination_clause']],
    [9, 'Limitation of Liability', $agr['liability_clause']],
    [10, 'Governing Law', $agr['governing_law']],
    [11, 'Dispute Resolution', $agr['dispute_resolution']],
    [12, 'Force Majeure', $agr['force_majeure']],
    [13, 'Amendments', $agr['amendments_clause']],
];
foreach ($sections as $sec):
    if (!$sec[2])
        continue;
?>
                    <div class="legal-section">
                        <h3>
                            <?= $sec[0]?>.
                            <?= $sec[1]?>
                        </h3>
                        <p class="legal-text">
                            <?= htmlspecialchars($sec[2])?>
                        </p>
                    </div>
                    <?php
endforeach; ?>

                    <?php if ($agr['custom_notes']): ?>
                    <div class="legal-section">
                        <h3>14. Additional Notes</h3>
                        <p class="legal-text">
                            <?= htmlspecialchars($agr['custom_notes'])?>
                        </p>
                    </div>
                    <?php
endif; ?>

                    <!-- Signatures -->
                    <div class="legal-section">
                        <h3>Signatures</h3>
                        <p class="legal-text" style="margin-bottom:10px;">IN WITNESS WHEREOF, the parties have executed
                            this Agreement as of the Effective Date.</p>
                        <div class="sig-grid">
                            <div class="sig-box">
                                <div class="sig-line"></div>
                                <div class="sig-name">
                                    <?= htmlspecialchars($agr['company_signatory_name'] ?? $cs['company_name'])?>
                                </div>
                                <div class="sig-label">
                                    <?= htmlspecialchars($agr['company_signatory_title'] ?? 'Director')?>,
                                    <?= htmlspecialchars($cs['company_name'])?>
                                </div>
                            </div>
                            <div class="sig-box">
                                <div class="sig-line"></div>
                                <div class="sig-name">
                                    <?= htmlspecialchars($agr['client_signature_name'] ?: ($agr['customer_name'] ?? ''))?>
                                </div>
                                <div class="sig-label">Client
                                    <?= $agr['customer_company'] ? ', ' . htmlspecialchars($agr['customer_company']) : ''?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const menuToggle = document.getElementById('menuToggle'), sidebar = document.getElementById('sidebar');
        if (menuToggle) menuToggle.addEventListener('click', () => sidebar.classList.toggle('active'));
    </script>
</body>

</html>