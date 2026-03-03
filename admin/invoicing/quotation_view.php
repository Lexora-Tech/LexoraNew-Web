<?php
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");

if (!isset($_GET['id'])) {
    header("Location: quotations.php");
    exit();
}
$id = intval($_GET['id']);
$q = mysqli_query($conn, "SELECT q.*, c.name as customer_name, c.email as customer_email, c.phone as customer_phone, c.company as customer_company, c.address as customer_address, c.city as customer_city, c.country as customer_country FROM quotations q LEFT JOIN customers c ON q.customer_id = c.id WHERE q.id=$id");
$quotation = mysqli_fetch_assoc($q);
if (!$quotation) {
    header("Location: quotations.php");
    exit();
}

$items = [];
$items_q = mysqli_query($conn, "SELECT * FROM invoice_items WHERE item_type='quotation' AND parent_id=$id ORDER BY sort_order ASC");
while ($it = mysqli_fetch_assoc($items_q))
    $items[] = $it;

function format_currency($a)
{
    return 'LKR ' . number_format($a, 2);
}
function getStatusBadge($s)
{
    $c = ['draft' => 'background:rgba(107,114,128,0.1);color:#6b7280;', 'sent' => 'background:rgba(59,130,246,0.1);color:#3b82f6;', 'accepted' => 'background:rgba(16,185,129,0.1);color:#10b981;', 'rejected' => 'background:rgba(239,68,68,0.1);color:#ef4444;', 'converted' => 'background:rgba(139,92,246,0.1);color:#8b5cf6;', 'cancelled' => 'background:rgba(239,68,68,0.1);color:#ef4444;'];
    $st = $c[$s] ?? '';
    return '<span style="padding:5px 14px;border-radius:20px;font-size:13px;font-weight:600;' . $st . '">' . ucfirst($s) . '</span>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation
        <?= htmlspecialchars($quotation['quotation_number'])?> | Lexora Admin
    </title>
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
            max-width: 1000px
        }

        .doc-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02)
        }

        .doc-header {
            padding: 30px 40px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px
        }

        .doc-brand h1 {
            font-size: 26px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 4px
        }

        .doc-brand p {
            font-size: 13px;
            color: var(--text-muted)
        }

        .doc-meta {
            text-align: right
        }

        .doc-meta h2 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 8px
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            padding: 30px 40px;
            border-bottom: 1px solid var(--border)
        }

        .info-block h4 {
            font-size: 12px;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 10px;
            letter-spacing: 0.5px
        }

        .info-block p {
            font-size: 14px;
            margin-bottom: 4px
        }

        .items-table {
            width: 100%;
            border-collapse: collapse
        }

        .items-table th {
            text-align: left;
            padding: 14px 24px;
            font-size: 12px;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 600;
            border-bottom: 2px solid var(--border);
            background: rgba(0, 0, 0, 0.02)
        }

        .items-table td {
            padding: 14px 24px;
            border-bottom: 1px solid var(--border);
            font-size: 14px
        }

        .items-table .text-right {
            text-align: right
        }

        .totals {
            padding: 20px 40px;
            display: flex;
            justify-content: flex-end
        }

        .totals-box {
            width: 300px
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
            color: var(--text-muted)
        }

        .total-row.grand {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
            border-top: 2px solid var(--border);
            padding-top: 12px;
            margin-top: 8px
        }

        .total-row.grand span:last-child {
            color: var(--text-main)
        }

        .doc-footer {
            padding: 20px 40px;
            border-top: 1px solid var(--border);
            background: rgba(0, 0, 0, 0.02)
        }

        .doc-footer p {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.6
        }

        .action-bar {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: wrap
        }

        .btn-action {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
            cursor: pointer;
            border: none
        }

        .btn-action.primary {
            background: var(--primary);
            color: #000
        }

        .btn-action.primary:hover {
            background: var(--primary-hover)
        }

        .btn-action.outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-main)
        }

        .btn-action.outline:hover {
            border-color: var(--primary);
            color: var(--primary)
        }

        .btn-action.success {
            background: var(--success);
            color: #fff
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

            .info-grid {
                grid-template-columns: 1fr
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
            <a href="../add_blog.php" class="nav-item"><i class="fas fa-plus-circle"></i> <span>Add New</span></a>
            <div class="menu-label" style="margin-top:20px;">Billing</div>
            <a href="billing_dashboard.php" class="nav-item"><i class="fas fa-chart-pie"></i> <span>Overview</span></a>
            <a href="quotations.php" class="nav-item active"><i class="fas fa-file-invoice"></i>
                <span>Quotations</span></a>
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
                    <h2>Quotation Details</h2>
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
                <div class="doc-card">
                    <div class="doc-header">
                        <div class="doc-brand">
                            <h1>LEXORA TECH</h1>
                            <p>Creative Design & Tech Solutions</p>
                        </div>
                        <div class="doc-meta">
                            <h2>
                                <?= htmlspecialchars($quotation['quotation_number'])?>
                            </h2>
                            <?= getStatusBadge($quotation['status'])?>
                        </div>
                    </div>
                    <div class="info-grid">
                        <div class="info-block">
                            <h4>Bill To</h4>
                            <p><strong>
                                    <?= htmlspecialchars($quotation['customer_name'] ?? '')?>
                                </strong></p>
                            <p>
                                <?= htmlspecialchars($quotation['customer_email'] ?? '')?>
                            </p>
                            <p>
                                <?= htmlspecialchars($quotation['customer_phone'] ?? '')?>
                            </p>
                            <p>
                                <?= htmlspecialchars($quotation['customer_company'] ?? '')?>
                            </p>
                            <p>
                                <?= htmlspecialchars(($quotation['customer_address'] ?? '') . ($quotation['customer_city'] ? ' , ' . $quotation['customer_city'] : '') . ($quotation['customer_country'] ? ' , ' . $quotation['customer_country'] : ''))?>
                            </p>
                        </div>
                        <div class="info-block" style="text-align:right;">
                            <h4>Quotation Info</h4>
                            <p><strong>Date:</strong>
                                <?= date("M d, Y", strtotime($quotation['issue_date']))?>
                            </p>
                            <p><strong>Valid Until:</strong>
                                <?= $quotation['valid_until'] ? date("M d, Y", strtotime($quotation['valid_until'])) : '-'?>
                            </p>
                            <?php if ($quotation['payment_terms']): ?>
                            <p><strong>Terms:</strong>
                                <?= htmlspecialchars($quotation['payment_terms'])?>
                            </p>
                            <?php
endif; ?>
                        </div>
                    </div>

                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th class="text-right">Qty</th>
                                <th class="text-right">Price</th>
                                <th class="text-right">Tax %</th>
                                <th class="text-right">Discount</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $n = 1;
foreach ($items as $it): ?>
                            <tr>
                                <td>
                                    <?= $n++?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($it['description'])?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($it['quantity'], 2)?>
                                </td>
                                <td class="text-right">
                                    <?= format_currency($it['unit_price'])?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($it['tax_rate'], 2)?>%
                                </td>
                                <td class="text-right">
                                    <?= format_currency($it['discount'])?>
                                </td>
                                <td class="text-right"><strong>
                                        <?= format_currency($it['line_total'])?>
                                    </strong></td>
                            </tr>
                            <?php
endforeach; ?>
                        </tbody>
                    </table>

                    <div class="totals">
                        <div class="totals-box">
                            <div class="total-row"><span>Subtotal</span><span>
                                    <?= format_currency($quotation['subtotal'])?>
                                </span></div>
                            <div class="total-row"><span>Tax</span><span>
                                    <?= format_currency($quotation['tax_amount'])?>
                                </span></div>
                            <div class="total-row"><span>Discount</span><span>-
                                    <?= format_currency($quotation['discount_amount'])?>
                                </span></div>
                            <div class="total-row grand"><span>Grand Total</span><span>
                                    <?= format_currency($quotation['grand_total'])?>
                                </span></div>
                        </div>
                    </div>

                    <?php if ($quotation['notes']): ?>
                    <div class="doc-footer">
                        <p><strong>Notes:</strong>
                            <?= nl2br(htmlspecialchars($quotation['notes']))?>
                        </p>
                    </div>
                    <?php
endif; ?>
                </div>

                <div class="action-bar">
                    <a href="quotation_form.php?id=<?= $id?>" class="btn-action primary"><i class="fas fa-pen"></i>
                        Edit</a>
                    <a href="generate_pdf.php?type=quotation&id=<?= $id?>" class="btn-action outline"
                        target="_blank"><i class="fas fa-file-pdf"></i> Download PDF</a>
                    <a href="send_email.php?type=quotation&id=<?= $id?>" class="btn-action outline"><i
                            class="fas fa-paper-plane"></i> Send Email</a>
                    <?php if ($quotation['status'] !== 'converted'): ?>
                    <a href="convert_to_invoice.php?id=<?= $id?>" class="btn-action success"
                        onclick="return confirm('Convert to Invoice?')"><i class="fas fa-exchange-alt"></i> Convert to
                        Invoice</a>
                    <?php
endif; ?>
                    <a href="quotations.php" class="btn-action outline"><i class="fas fa-arrow-left"></i> Back</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        const menuToggle = document.getElementById('menuToggle'), sidebar = document.getElementById('sidebar');
        if (menuToggle) menuToggle.addEventListener('click', () => sidebar.classList.toggle('active'));
        const themeToggle = document.getElementById("themeToggle");
        if (localStorage.getItem("theme") === "dark") { document.body.classList.add("dark"); themeToggle.checked = true; }
        themeToggle.addEventListener("change", () => { if (themeToggle.checked) { document.body.classList.add("dark"); localStorage.setItem("theme", "dark"); } else { document.body.classList.remove("dark"); localStorage.setItem("theme", "light"); } });
    </script>
</body>

</html>