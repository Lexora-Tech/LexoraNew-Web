<?php
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");

if (!isset($_GET['invoice_id'])) {
    header("Location: invoices.php");
    exit();
}
$invoice_id = intval($_GET['invoice_id']);

$inv = mysqli_fetch_assoc(mysqli_query($conn, "SELECT i.*, c.name as customer_name FROM invoices i LEFT JOIN customers c ON i.customer_id=c.id WHERE i.id=$invoice_id"));
if (!$inv) {
    header("Location: invoices.php");
    exit();
}

$balance = $inv['grand_total'] - $inv['amount_paid'];

// Get existing payments
$payments = [];
$pay_q = mysqli_query($conn, "SELECT * FROM payments WHERE invoice_id=$invoice_id ORDER BY payment_date DESC");
while ($p = mysqli_fetch_assoc($pay_q))
    $payments[] = $p;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Payment | Lexora Admin</title>
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
            max-width: 800px
        }

        .info-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px
        }

        .info-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            text-align: center
        }

        .info-card .label {
            font-size: 12px;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 8px
        }

        .info-card .value {
            font-size: 22px;
            font-weight: 700
        }

        .info-card .value.total {
            color: var(--primary)
        }

        .info-card .value.paid {
            color: var(--success)
        }

        .info-card .value.balance {
            color: var(--danger)
        }

        .form-container {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 35px
        }

        .form-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border)
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px
        }

        .form-group {
            margin-bottom: 5px
        }

        .form-group.full {
            grid-column: span 2
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 8px
        }

        .form-input,
        .form-select,
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
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 180, 0, 0.1)
        }

        .form-textarea {
            min-height: 70px;
            resize: vertical
        }

        .form-select {
            cursor: pointer;
            appearance: auto
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

        .btn-success {
            background: var(--success);
            color: #fff;
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

        .btn-success:hover {
            opacity: 0.9
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

        .btn-full {
            background: var(--success);
            color: #fff;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            margin-left: 10px
        }

        .btn-full:hover {
            opacity: 0.9
        }

        .history {
            margin-top: 30px
        }

        .history h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px
        }

        .payment-list {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden
        }

        .payment-row {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
            gap: 15px
        }

        .payment-row:last-child {
            border-bottom: none
        }

        .pay-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0
        }

        .pay-info {
            flex: 1
        }

        .pay-info strong {
            display: block;
            font-size: 14px;
            margin-bottom: 2px
        }

        .pay-info span {
            font-size: 12px;
            color: var(--text-muted)
        }

        .pay-amount {
            font-size: 16px;
            font-weight: 700;
            color: var(--success)
        }

        .pay-actions {
            display: flex;
            gap: 6px
        }

        .btn-sm {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            color: var(--text-muted);
            background: var(--bg-card);
            cursor: pointer;
            font-size: 13px;
            transition: 0.2s
        }

        .btn-sm:hover {
            color: var(--primary);
            border-color: var(--primary)
        }

        .empty-state {
            padding: 30px;
            text-align: center;
            color: var(--text-muted)
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2)
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

            .info-cards {
                grid-template-columns: 1fr
            }

            .form-grid {
                grid-template-columns: 1fr
            }

            .form-group.full {
                grid-column: span 1
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
            <a href="invoices.php" class="nav-item active"><i class="fas fa-file-invoice-dollar"></i>
                <span>Invoices</span></a>
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
                    <h2>Record Payment —
                        <?= htmlspecialchars($inv['invoice_number'])?>
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
                <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle"></i>
                    <?= htmlspecialchars($_GET['msg'])?>
                </div>
                <?php
endif; ?>

                <div class="info-cards">
                    <div class="info-card">
                        <div class="label">Invoice Total</div>
                        <div class="value total">LKR
                            <?= number_format($inv['grand_total'], 2)?>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="label">Total Paid</div>
                        <div class="value paid">LKR
                            <?= number_format($inv['amount_paid'], 2)?>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="label">Balance Due</div>
                        <div class="value balance">LKR
                            <?= number_format(max(0, $balance), 2)?>
                        </div>
                    </div>
                </div>

                <form action="payment_save.php" method="POST" class="form-container">
                    <div class="form-title"><i class="fas fa-money-bill-wave"
                            style="color:var(--success);margin-right:10px;"></i>Add Payment for
                        <?= htmlspecialchars($inv['customer_name'] ?? '')?>
                    </div>
                    <input type="hidden" name="invoice_id" value="<?= $invoice_id?>">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Amount (LKR) *</label>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <input type="number" name="amount" id="payAmount" class="form-input" step="0.01"
                                    min="0.01" max="<?= $balance?>" value="<?= number_format($balance, 2, '.', '')?>"
                                    required>
                                <button type="button" class="btn-full"
                                    onclick="document.getElementById('payAmount').value='<?= number_format($balance, 2, '.', '')?>'">Full</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Payment Date *</label>
                            <input type="date" name="payment_date" class="form-input" value="<?= date('Y-m-d')?>"
                                required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" class="form-select">
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="cash">Cash</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="cheque">Cheque</option>
                                <option value="paypal">PayPal</option>
                                <option value="stripe">Stripe</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Transaction/Reference ID</label>
                            <input type="text" name="transaction_id" class="form-input" placeholder="e.g. TXN-12345">
                        </div>
                        <div class="form-group full">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-textarea"
                                placeholder="Any additional notes about this payment..."></textarea>
                        </div>
                    </div>
                    <div class="btn-row">
                        <a href="invoice_view.php?id=<?= $invoice_id?>" class="btn-secondary">Cancel</a>
                        <button type="submit" class="btn-success"><i class="fas fa-check"></i> Record Payment</button>
                    </div>
                </form>

                <div class="history">
                    <h3><i class="fas fa-history" style="color:var(--primary);margin-right:8px;"></i>Payment History
                    </h3>
                    <div class="payment-list">
                        <?php if (empty($payments)): ?>
                        <div class="empty-state"><i class="fas fa-inbox"
                                style="font-size:24px;display:block;margin-bottom:8px;"></i>No payments recorded yet
                        </div>
                        <?php
else:
    foreach ($payments as $p): ?>
                        <div class="payment-row">
                            <div class="pay-icon"><i class="fas fa-check-circle"></i></div>
                            <div class="pay-info">
                                <strong>
                                    <?= ucfirst(str_replace('_', ' ', $p['payment_method']))?>
                                </strong>
                                <span>
                                    <?= date("M d, Y", strtotime($p['payment_date']))?>
                                    <?= $p['transaction_id'] ? ' · Ref: ' . htmlspecialchars($p['transaction_id']) : ''?>
                                </span>
                            </div>
                            <div class="pay-amount">LKR
                                <?= number_format($p['amount'], 2)?>
                            </div>
                            <div class="pay-actions">
                                <a href="generate_pdf.php?type=receipt&id=<?= $p['id']?>" class="btn-sm"
                                    title="Receipt PDF" target="_blank"><i class="fas fa-file-pdf"></i></a>
                                <a href="send_email.php?type=receipt&id=<?= $p['id']?>" class="btn-sm"
                                    title="Email Receipt"><i class="fas fa-paper-plane"></i></a>
                                <a href="payment_delete.php?id=<?= $p['id']?>&invoice_id=<?= $invoice_id?>"
                                    class="btn-sm" title="Delete" onclick="return confirm('Delete this payment?')"><i
                                        class="fas fa-trash"></i></a>
                            </div>
                        </div>
                        <?php
    endforeach;
endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const menuToggle = document.getElementById('menuToggle'), sidebar = document.getElementById('sidebar'); if (menuToggle) menuToggle.addEventListener('click', () => sidebar.classList.toggle('active'));
        const themeToggle = document.getElementById("themeToggle"); if (localStorage.getItem("theme") === "dark") { document.body.classList.add("dark"); themeToggle.checked = true; } themeToggle.addEventListener("change", () => { if (themeToggle.checked) { document.body.classList.add("dark"); localStorage.setItem("theme", "dark"); } else { document.body.classList.remove("dark"); localStorage.setItem("theme", "light"); } });
    </script>
</body>

</html>