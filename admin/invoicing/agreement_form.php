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
    header("Location: agreements.php?msg=" . urlencode("Agreement not found"));
    exit();
}
$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Edit Agreement
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

        header h2 {
            font-size: 22px;
            font-weight: 700
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

        .btn-primary:hover {
            filter: brightness(1.1)
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

        .card {
            background: var(--bg-card);
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 24px;
            margin-bottom: 20px
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 20px
        }

        .info-item label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--text-secondary);
            margin-bottom: 4px
        }

        .info-item .val {
            font-size: 14px;
            font-weight: 600
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px
        }

        .form-group {
            margin-bottom: 16px
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .5px
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            background: var(--bg-body);
            color: var(--text-primary);
            font-family: inherit
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical
        }

        .clause-section {
            border: 1px solid var(--border);
            border-radius: 10px;
            margin-bottom: 12px;
            overflow: hidden;
            transition: all .3s
        }

        .clause-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 18px;
            cursor: pointer;
            background: var(--bg-body);
            font-weight: 600;
            font-size: 13.5px;
            transition: all .2s
        }

        .clause-header:hover {
            background: rgba(255, 180, 0, .06)
        }

        .clause-header .num {
            background: var(--primary);
            color: #000;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            margin-right: 10px
        }

        .clause-header .left {
            display: flex;
            align-items: center
        }

        .clause-header i.arrow {
            transition: transform .3s;
            font-size: 12px;
            color: var(--text-secondary)
        }

        .clause-body {
            padding: 0 18px;
            max-height: 0;
            overflow: hidden;
            transition: max-height .4s ease, padding .3s
        }

        .clause-section.open .clause-body {
            max-height: 500px;
            padding: 0 18px 18px
        }

        .clause-section.open .arrow {
            transform: rotate(180deg)
        }

        .actions-bar {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border)
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

            .form-grid {
                grid-template-columns: 1fr
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
            <header>
                <div style="display:flex;align-items:center;">
                    <i class="fas fa-bars menu-toggle" id="menuToggle"></i>
                    <h2><i class="fas fa-file-contract" style="color:var(--primary);margin-right:8px;"></i> Edit
                        Agreement</h2>
                </div>
                <div style="display:flex;gap:10px;">
                    <a href="agreement_view.php?id=<?= $id?>" class="btn btn-outline"><i class="fas fa-eye"></i>
                        Preview</a>
                    <a href="generate_pdf.php?type=agreement&id=<?= $id?>" class="btn btn-outline" target="_blank"><i
                            class="fas fa-file-pdf"></i> PDF</a>
                </div>
            </header>
            <?php if ($msg): ?>
            <div class="alert">
                <?= htmlspecialchars($msg)?>
            </div>
            <?php
endif; ?>

            <!-- Reference Info -->
            <div class="card">
                <div class="info-grid">
                    <div class="info-item"><label>Agreement #</label>
                        <div class="val" style="color:var(--primary)">
                            <?= htmlspecialchars($agr['agreement_number'])?>
                        </div>
                    </div>
                    <div class="info-item"><label>Customer</label>
                        <div class="val">
                            <?= htmlspecialchars($agr['customer_name'] ?? 'N/A')?>
                        </div>
                    </div>
                    <div class="info-item"><label>Invoice</label>
                        <div class="val"><a href="invoice_view.php?id=<?= $agr['invoice_id']?>"
                                style="color:var(--primary)">
                                <?= htmlspecialchars($agr['invoice_number'] ?? '')?>
                            </a></div>
                    </div>
                    <div class="info-item"><label>Total</label>
                        <div class="val">
                            <?=($agr['currency'] ?? 'LKR') . ' ' . number_format($agr['grand_total'] ?? 0, 2)?>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="agreement_save.php">
                <input type="hidden" name="id" value="<?= $id?>">

                <!-- Dates & Status -->
                <div class="card">
                    <h3 style="font-size:15px;margin-bottom:16px;"><i class="fas fa-calendar"
                            style="color:var(--primary);margin-right:6px;"></i> Dates & Status</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status">
                                <?php foreach (['draft', 'sent', 'signed', 'cancelled'] as $s): ?>
                                <option value="<?= $s?>" <?=$agr['status'] === $s ? 'selected' : ''?>>
                                    <?= ucfirst($s)?>
                                </option>
                                <?php
endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group"><label>Effective Date</label><input type="date" name="effective_date"
                                value="<?= $agr['effective_date']?>"></div>
                        <div class="form-group"><label>Project Start Date</label><input type="date"
                                name="project_start_date" value="<?= $agr['project_start_date']?>"></div>
                        <div class="form-group"><label>Project End Date</label><input type="date"
                                name="project_end_date" value="<?= $agr['project_end_date']?>"></div>
                    </div>
                </div>

                <!-- Scope & Payment -->
                <div class="card">
                    <h3 style="font-size:15px;margin-bottom:16px;"><i class="fas fa-tasks"
                            style="color:var(--primary);margin-right:6px;"></i> Scope & Payment</h3>
                    <div class="form-group">
                        <label>Scope of Services</label>
                        <textarea name="scope_of_services"
                            rows="5"><?= htmlspecialchars($agr['scope_of_services'] ?? '')?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Payment Terms</label>
                        <textarea name="payment_terms_text"
                            rows="4"><?= htmlspecialchars($agr['payment_terms_text'] ?? '')?></textarea>
                    </div>
                </div>

                <!-- Legal Clauses (collapsible) -->
                <div class="card">
                    <h3 style="font-size:15px;margin-bottom:16px;"><i class="fas fa-gavel"
                            style="color:var(--primary);margin-right:6px;"></i> Legal Clauses</h3>
                    <?php
$clauses = [
    ['Late Payment Policy', 'late_payment_policy', 'fas fa-clock'],
    ['Confidentiality', 'confidentiality_clause', 'fas fa-lock'],
    ['Intellectual Property', 'ip_clause', 'fas fa-lightbulb'],
    ['Termination', 'termination_clause', 'fas fa-ban'],
    ['Limitation of Liability', 'liability_clause', 'fas fa-shield-alt'],
    ['Governing Law', 'governing_law', 'fas fa-balance-scale'],
    ['Dispute Resolution', 'dispute_resolution', 'fas fa-handshake'],
    ['Force Majeure', 'force_majeure', 'fas fa-bolt'],
    ['Amendments', 'amendments_clause', 'fas fa-edit'],
];
$num = 1;
foreach ($clauses as $c):
?>
                    <div class="clause-section">
                        <div class="clause-header" onclick="this.parentElement.classList.toggle('open')">
                            <div class="left"><span class="num">
                                    <?= $num?>
                                </span>
                                <?= $c[0]?>
                            </div>
                            <i class="fas fa-chevron-down arrow"></i>
                        </div>
                        <div class="clause-body">
                            <textarea name="<?= $c[1]?>" rows="4"
                                style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:8px;font-size:13px;background:var(--bg-body);color:var(--text-primary);font-family:inherit;resize:vertical;"><?= htmlspecialchars($agr[$c[1]] ?? '')?></textarea>
                        </div>
                    </div>
                    <?php $num++;
endforeach; ?>
                </div>

                <!-- Signatures -->
                <div class="card">
                    <h3 style="font-size:15px;margin-bottom:16px;"><i class="fas fa-signature"
                            style="color:var(--primary);margin-right:6px;"></i> Signatures</h3>
                    <div class="form-grid">
                        <div class="form-group"><label>Company Signatory Name</label><input type="text"
                                name="company_signatory_name"
                                value="<?= htmlspecialchars($agr['company_signatory_name'] ?? '')?>"></div>
                        <div class="form-group"><label>Company Signatory Title</label><input type="text"
                                name="company_signatory_title"
                                value="<?= htmlspecialchars($agr['company_signatory_title'] ?? '')?>"></div>
                        <div class="form-group"><label>Client Signature Name</label><input type="text"
                                name="client_signature_name"
                                value="<?= htmlspecialchars($agr['client_signature_name'] ?? '')?>"></div>
                    </div>
                </div>

                <!-- Custom Notes -->
                <div class="card">
                    <div class="form-group" style="margin-bottom:0;">
                        <label>Custom Notes</label>
                        <textarea name="custom_notes"
                            rows="3"><?= htmlspecialchars($agr['custom_notes'] ?? '')?></textarea>
                    </div>
                </div>

                <div class="actions-bar">
                    <a href="agreements.php" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Agreement</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        const menuToggle = document.getElementById('menuToggle'), sidebar = document.getElementById('sidebar');
        if (menuToggle) menuToggle.addEventListener('click', () => sidebar.classList.toggle('active'));
    </script>
</body>

</html>