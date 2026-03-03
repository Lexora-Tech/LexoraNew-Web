<?php
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");

$editing = false;
$invoice = ['customer_id' => '', 'status' => 'draft', 'issue_date' => date('Y-m-d'), 'due_date' => date('Y-m-d', strtotime('+30 days')), 'payment_terms' => '', 'notes' => '', 'amount_paid' => 0];
$items = [];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $q = mysqli_query($conn, "SELECT * FROM invoices WHERE id=$id");
    if ($row = mysqli_fetch_assoc($q)) {
        $invoice = $row;
        $editing = true;
    }
    $items_q = mysqli_query($conn, "SELECT * FROM invoice_items WHERE item_type='invoice' AND parent_id=$id ORDER BY sort_order ASC");
    while ($it = mysqli_fetch_assoc($items_q))
        $items[] = $it;
}

$customers = mysqli_query($conn, "SELECT id, name, email FROM customers ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $editing ? 'Edit' : 'New'?> Invoice | Lexora Admin
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
            padding: 30px
        }

        .form-container {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02)
        }

        .form-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border)
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px
        }

        .form-group {
            margin-bottom: 5px
        }

        .form-group.full {
            grid-column: span 3
        }

        .form-group.half {
            grid-column: span 2
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-main);
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
            outline: none;
            transition: 0.2s
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 180, 0, 0.1)
        }

        .form-textarea {
            min-height: 80px;
            resize: vertical
        }

        .form-select {
            cursor: pointer;
            appearance: auto
        }

        .items-section {
            margin: 30px 0
        }

        .items-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px
        }

        .items-header h3 {
            font-size: 16px;
            font-weight: 600
        }

        .btn-add-item {
            background: var(--bg-body);
            border: 1px dashed var(--border);
            color: var(--primary);
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 6px
        }

        .btn-add-item:hover {
            background: rgba(255, 180, 0, 0.05);
            border-color: var(--primary)
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px
        }

        .items-table th {
            text-align: left;
            padding: 12px;
            font-size: 12px;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 600;
            border-bottom: 2px solid var(--border)
        }

        .items-table td {
            padding: 8px;
            border-bottom: 1px solid var(--border);
            vertical-align: top
        }

        .items-table input {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 6px;
            background: var(--bg-body);
            color: var(--text-main);
            font-size: 13px;
            outline: none
        }

        .items-table input:focus {
            border-color: var(--primary)
        }

        .items-table .desc-col {
            min-width: 250px
        }

        .items-table .num-col {
            width: 100px;
            text-align: right
        }

        .items-table .total-col {
            width: 120px;
            text-align: right;
            font-weight: 600;
            padding-top: 18px;
            color: var(--text-main)
        }

        .btn-remove {
            background: none;
            border: none;
            color: var(--danger);
            cursor: pointer;
            font-size: 16px;
            padding: 8px;
            opacity: 0.7;
            transition: 0.2s
        }

        .btn-remove:hover {
            opacity: 1
        }

        .totals-section {
            display: flex;
            justify-content: flex-end
        }

        .totals-box {
            width: 350px;
            background: var(--bg-body);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 14px
        }

        .total-row.grand {
            border-top: 2px solid var(--border);
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
            padding-top: 15px;
            margin-top: 5px
        }

        .btn-row {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px
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
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px)
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

            .form-grid {
                grid-template-columns: 1fr
            }

            .form-group.full,
            .form-group.half {
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
            <a href="../add_blog.php" class="nav-item"><i class="fas fa-plus-circle"></i> <span>Add New</span></a>
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
                    <h2>
                        <?= $editing ? 'Edit Invoice' : 'New Invoice'?>
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
                <form action="invoice_save.php" method="POST" class="form-container">
                    <div class="form-title"><i class="fas fa-file-invoice-dollar"
                            style="color:var(--primary);margin-right:10px;"></i>
                        <?= $editing ? 'Edit Invoice #' . htmlspecialchars($invoice['invoice_number']) : 'Create New Invoice'?>
                    </div>
                    <?php if ($editing): ?><input type="hidden" name="id" value="<?= $invoice['id']?>">
                    <?php
endif; ?>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Customer *</label>
                            <select name="customer_id" class="form-select" required>
                                <option value="">Select Customer</option>
                                <?php while ($c = mysqli_fetch_assoc($customers)): ?>
                                <option value="<?= $c['id']?>" <?=$invoice['customer_id'] == $c['id'] ? 'selected' : ''?>>
                                    <?= htmlspecialchars($c['name'])?> (
                                    <?= htmlspecialchars($c['email'] ?? '')?>)
                                </option>
                                <?php
endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Issue Date *</label>
                            <input type="date" name="issue_date" class="form-input"
                                value="<?= $invoice['issue_date']?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Due Date</label>
                            <input type="date" name="due_date" class="form-input"
                                value="<?= $invoice['due_date'] ?? ''?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <?php foreach (['draft', 'sent', 'paid', 'overdue', 'partial', 'cancelled'] as $s): ?>
                                <option value="<?= $s?>" <?=$invoice['status'] == $s ? 'selected' : ''?>>
                                    <?= ucfirst($s)?>
                                </option>
                                <?php
endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Amount Paid</label>
                            <input type="number" name="amount_paid" class="form-input" step="0.01" min="0"
                                value="<?= $invoice['amount_paid'] ?? 0?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Payment Terms</label>
                            <input type="text" name="payment_terms" class="form-input"
                                value="<?= htmlspecialchars($invoice['payment_terms'] ?? '')?>"
                                placeholder="e.g., Net 30">
                        </div>
                        <div class="form-group full">
                            <label class="form-label">Notes (visible to client)</label>
                            <textarea name="notes"
                                class="form-textarea"><?= htmlspecialchars($invoice['notes'] ?? '')?></textarea>
                        </div>
                    </div>

                    <div class="items-section">
                        <div class="items-header">
                            <h3><i class="fas fa-list" style="color:var(--primary);margin-right:8px;"></i>Line Items
                            </h3><button type="button" class="btn-add-item" onclick="addItem()"><i
                                    class="fas fa-plus"></i> Add Item</button>
                        </div>
                        <div style="overflow-x:auto;">
                            <table class="items-table" id="itemsTable">
                                <thead>
                                    <tr>
                                        <th class="desc-col">Description</th>
                                        <th class="num-col">Qty</th>
                                        <th class="num-col">Unit Price</th>
                                        <th class="num-col">Tax %</th>
                                        <th class="num-col">Discount</th>
                                        <th class="num-col">Total</th>
                                        <th style="width:40px"></th>
                                    </tr>
                                </thead>
                                <tbody id="itemsBody"></tbody>
                            </table>
                        </div>
                        <div class="totals-section">
                            <div class="totals-box">
                                <div class="total-row"><span>Subtotal</span><span id="subtotalDisplay">LKR 0.00</span>
                                </div>
                                <div class="total-row"><span>Tax</span><span id="taxDisplay">LKR 0.00</span></div>
                                <div class="total-row"><span>Discount</span><span id="discountDisplay">- LKR 0.00</span>
                                </div>
                                <div class="total-row grand"><span>Grand Total</span><span id="grandTotalDisplay">LKR
                                        0.00</span></div>
                            </div>
                        </div>
                        <input type="hidden" name="subtotal" id="subtotalInput">
                        <input type="hidden" name="tax_amount" id="taxInput">
                        <input type="hidden" name="discount_amount" id="discountInput">
                        <input type="hidden" name="grand_total" id="grandTotalInput">
                    </div>
                    <div class="btn-row">
                        <a href="invoices.php" class="btn-secondary">Cancel</a>
                        <button type="submit" class="btn-primary"><i class="fas fa-save"></i>
                            <?= $editing ? 'Update' : 'Save'?> Invoice
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const menuToggle = document.getElementById('menuToggle'), sidebar = document.getElementById('sidebar'); if (menuToggle) menuToggle.addEventListener('click', () => sidebar.classList.toggle('active'));
        const themeToggle = document.getElementById("themeToggle"); if (localStorage.getItem("theme") === "dark") { document.body.classList.add("dark"); themeToggle.checked = true; } themeToggle.addEventListener("change", () => { if (themeToggle.checked) { document.body.classList.add("dark"); localStorage.setItem("theme", "dark"); } else { document.body.classList.remove("dark"); localStorage.setItem("theme", "light"); } });

        let itemIndex = 0;
        function addItem(desc = '', qty = 1, price = 0, tax = 0, discount = 0) {
            const tbody = document.getElementById('itemsBody'), tr = document.createElement('tr');
            tr.innerHTML = `<td><input type="text" name="items[${itemIndex}][description]" value="${desc}" placeholder="Service or product description" required></td>
    <td class="num-col"><input type="number" name="items[${itemIndex}][quantity]" value="${qty}" min="0.01" step="0.01" class="calc"></td>
    <td class="num-col"><input type="number" name="items[${itemIndex}][unit_price]" value="${price}" min="0" step="0.01" class="calc"></td>
    <td class="num-col"><input type="number" name="items[${itemIndex}][tax_rate]" value="${tax}" min="0" max="100" step="0.01" class="calc"></td>
    <td class="num-col"><input type="number" name="items[${itemIndex}][discount]" value="${discount}" min="0" step="0.01" class="calc"></td>
    <td class="total-col" id="lineTotal_${itemIndex}">0.00</td>
    <td><button type="button" class="btn-remove" onclick="removeItem(this)"><i class="fas fa-times"></i></button></td>`;
            tbody.appendChild(tr); itemIndex++;
            tr.querySelectorAll('.calc').forEach(i => i.addEventListener('input', recalculate)); recalculate();
        }
        function removeItem(btn) { btn.closest('tr').remove(); recalculate(); }
        function recalculate() {
            let subtotal = 0, totalTax = 0, totalDiscount = 0;
            document.querySelectorAll('#itemsBody tr').forEach(tr => {
                const qty = parseFloat(tr.querySelector('[name*="quantity"]').value) || 0, price = parseFloat(tr.querySelector('[name*="unit_price"]').value) || 0, taxRate = parseFloat(tr.querySelector('[name*="tax_rate"]').value) || 0, disc = parseFloat(tr.querySelector('[name*="discount"]').value) || 0;
                const base = qty * price, tax = base * (taxRate / 100), lineTotal = base + tax - disc;
                const tc = tr.querySelector('td.total-col'); if (tc) tc.textContent = lineTotal.toFixed(2);
                subtotal += base; totalTax += tax; totalDiscount += disc;
            });
            const grand = subtotal + totalTax - totalDiscount;
            document.getElementById('subtotalDisplay').textContent = 'LKR ' + subtotal.toFixed(2);
            document.getElementById('taxDisplay').textContent = 'LKR ' + totalTax.toFixed(2);
            document.getElementById('discountDisplay').textContent = '- LKR ' + totalDiscount.toFixed(2);
            document.getElementById('grandTotalDisplay').textContent = 'LKR ' + grand.toFixed(2);
            document.getElementById('subtotalInput').value = subtotal.toFixed(2);
            document.getElementById('taxInput').value = totalTax.toFixed(2);
            document.getElementById('discountInput').value = totalDiscount.toFixed(2);
            document.getElementById('grandTotalInput').value = grand.toFixed(2);
        }
<?php if  (!empty($items)):
    foreach ($items as $it): ?>
            addItem(<?= json_encode($it['description'])?>,<?= $it['quantity']?>,<?= $it['unit_price']?>,<?= $it['tax_rate']?>,<?= $it['discount']?>);
<?php
    endforeach;
else: ?> addItem();<?php
endif; ?>
    </script>
</body>

</html>