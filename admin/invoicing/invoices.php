<?php
include("../../includes/auth.php");
include("../../includes/db.php");

$search = '';
$sql = "SELECT i.*, c.name as customer_name FROM invoices i LEFT JOIN customers c ON i.customer_id=c.id ORDER BY i.created_at DESC";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT i.*, c.name as customer_name FROM invoices i LEFT JOIN customers c ON i.customer_id=c.id WHERE i.invoice_number LIKE '%$search%' OR c.name LIKE '%$search%' ORDER BY i.created_at DESC";
}
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);

function format_currency($a)
{
    return 'LKR ' . number_format($a, 2);
}
function getStatusBadge($s)
{
    $c = ['draft' => 'background:rgba(107,114,128,0.1);color:#6b7280;', 'sent' => 'background:rgba(59,130,246,0.1);color:#3b82f6;', 'paid' => 'background:rgba(16,185,129,0.1);color:#10b981;', 'overdue' => 'background:rgba(239,68,68,0.1);color:#ef4444;', 'cancelled' => 'background:rgba(239,68,68,0.1);color:#ef4444;', 'partial' => 'background:rgba(245,158,11,0.1);color:#f59e0b;'];
    $st = $c[$s] ?? '';
    return '<span style="padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;' . $st . '">' . ucfirst($s) . '</span>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices | Lexora Admin</title>
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
            --info: #3b82f6;
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
            transition: 0.3s ease;
            overflow-x: hidden
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

        .user-info {
            display: flex;
            flex-direction: column;
            line-height: 1.2
        }

        .user-name {
            font-size: 14px;
            font-weight: 600
        }

        .user-role {
            font-size: 11px;
            color: var(--text-muted)
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

        .search-box {
            background: var(--bg-body);
            padding: 8px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--border);
            width: 300px
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            color: var(--text-main);
            width: 100%
        }

        .search-box:focus-within {
            border-color: var(--primary)
        }

        .search-button {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0;
            font-size: 14px
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px
        }

        .section-header h3 {
            font-size: 18px;
            font-weight: 600
        }

        .btn-add {
            background: var(--primary);
            color: #000;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 8px
        }

        .btn-add:hover {
            background: var(--primary-hover);
            transform: translateY(-2px)
        }

        .table-container {
            background: var(--bg-card);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden
        }

        .table-responsive {
            overflow-x: auto
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        thead {
            background: rgba(0, 0, 0, 0.02);
            border-bottom: 1px solid var(--border)
        }

        th {
            text-align: left;
            padding: 16px 24px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            font-weight: 600
        }

        td {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            font-size: 14px
        }

        tbody tr:hover {
            background: rgba(0, 0, 0, 0.015)
        }

        tbody tr:last-child td {
            border-bottom: none
        }

        .actions {
            display: flex;
            gap: 8px
        }

        .btn-icon {
            width: 34px;
            height: 34px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            color: var(--text-muted);
            transition: 0.3s;
            cursor: pointer;
            background: var(--bg-card)
        }

        .btn-icon:hover {
            color: var(--primary);
            border-color: var(--primary)
        }

        .btn-icon.delete:hover {
            color: var(--danger);
            border-color: var(--danger)
        }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px)
        }

        .modal-content {
            background: var(--bg-card);
            padding: 30px;
            border-radius: 16px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            border: 1px solid var(--border)
        }

        .modal-btns {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 15px
        }

        .btn-modal {
            padding: 10px 25px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer
        }

        .btn-yes {
            background: var(--danger);
            color: #fff
        }

        .btn-no {
            background: var(--border);
            color: var(--text-main)
        }

        .toast-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 2000
        }

        .toast {
            background: #333;
            color: #fff;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.3s ease
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0
            }

            to {
                transform: translateX(0);
                opacity: 1
            }
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

            .search-box {
                display: none
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
                    <h2>Invoices (
                        <?= $count?>)
                    </h2>
                </div>
                <div class="header-right">
                    <form class="search-box" method="GET"><button type="submit" class="search-button"><i
                                class="fas fa-search"></i></button><input type="text" name="search"
                            placeholder="Search invoices..." value="<?= htmlspecialchars($search)?>"></form>
                    <label class="theme-switch"><input type="checkbox" id="themeToggle"><span
                            class="slider"></span></label>
                    <div class="user-profile" style="display:flex;align-items:center;gap:10px;">
                        <div class="user-info"><span class="user-name">
                                <?= $_SESSION['admin']?>
                            </span><span class="user-role">Administrator</span></div>
                        <div class="avatar">
                            <?= strtoupper(substr($_SESSION['admin'], 0, 1))?>
                        </div>
                    </div>
                </div>
            </header>
            <div class="content-wrapper">
                <div class="section-header">
                    <h3>
                        <?= empty($search) ? 'All Invoices' : "Results for '" . htmlspecialchars($search) . "'"?>
                    </h3><a href="invoice_form.php" class="btn-add"><i class="fas fa-plus"></i> New Invoice</a>
                </div>
                <div class="table-container">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    <th>Paid</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($count == 0): ?>
                                <tr>
                                    <td colspan="8" style="text-align:center;color:var(--text-muted);padding:40px;"><i
                                            class="fas fa-file-invoice-dollar"
                                            style="font-size:30px;display:block;margin-bottom:10px;"></i>No invoices
                                        yet.</td>
                                </tr>
                                <?php
else:
    while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><strong>
                                            <?= htmlspecialchars($row['invoice_number'])?>
                                        </strong></td>
                                    <td>
                                        <?= htmlspecialchars($row['customer_name'] ?? 'N/A')?>
                                    </td>
                                    <td style="color:var(--text-muted);font-size:13px;">
                                        <?= date("M d, Y", strtotime($row['issue_date']))?>
                                    </td>
                                    <td style="color:var(--text-muted);font-size:13px;">
                                        <?= $row['due_date'] ? date("M d, Y", strtotime($row['due_date'])) : '-'?>
                                    </td>
                                    <td><strong>
                                            <?= format_currency($row['grand_total'])?>
                                        </strong></td>
                                    <td style="color:var(--success);">
                                        <?= format_currency($row['amount_paid'])?>
                                    </td>
                                    <td>
                                        <?= getStatusBadge($row['status'])?>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="invoice_view.php?id=<?= $row['id']?>" class="btn-icon"
                                                title="View"><i class="fas fa-eye"></i></a>
                                            <a href="invoice_form.php?id=<?= $row['id']?>" class="btn-icon"
                                                title="Edit"><i class="fas fa-pen"></i></a>
                                            <a href="generate_pdf.php?type=invoice&id=<?= $row['id']?>"
                                                class="btn-icon" title="PDF" target="_blank"><i
                                                    class="fas fa-file-pdf"></i></a>
                                            <a href="send_email.php?type=invoice&id=<?= $row['id']?>" class="btn-icon"
                                                title="Send Email"><i class="fas fa-paper-plane"></i></a>
                                            <div class="btn-icon delete" data-id="<?= $row['id']?>" title="Delete"><i
                                                    class="fas fa-trash"></i></div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
    endwhile;
endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="toastContainer" class="toast-container"></div>
    <div class="modal" id="deleteModal">
        <div class="modal-content"><i class="fas fa-exclamation-circle"
                style="font-size:40px;color:var(--danger);margin-bottom:15px;"></i>
            <h3>Delete Invoice?</h3>
            <p style="color:var(--text-muted);margin-bottom:20px;">This action cannot be undone.</p>
            <div class="modal-btns"><button class="btn-modal btn-no" id="confirmNo">Cancel</button><button
                    class="btn-modal btn-yes" id="confirmYes">Delete</button></div>
        </div>
    </div>
    <script>
        const menuToggle = document.getElementById('menuToggle'), sidebar = document.getElementById('sidebar'); if (menuToggle) menuToggle.addEventListener('click', () => sidebar.classList.toggle('active'));
        const themeToggle = document.getElementById("themeToggle"); if (localStorage.getItem("theme") === "dark") { document.body.classList.add("dark"); themeToggle.checked = true; } themeToggle.addEventListener("change", () => { if (themeToggle.checked) { document.body.classList.add("dark"); localStorage.setItem("theme", "dark"); } else { document.body.classList.remove("dark"); localStorage.setItem("theme", "light"); } });
        let deleteId = null; document.querySelectorAll('.delete').forEach(b => { b.addEventListener('click', () => { deleteId = b.getAttribute('data-id'); document.getElementById('deleteModal').style.display = 'flex'; }); });
        document.getElementById('confirmNo').addEventListener('click', () => { document.getElementById('deleteModal').style.display = 'none'; });
        document.getElementById('confirmYes').addEventListener('click', () => { window.location.href = `invoice_delete.php?id=${deleteId}`; });
        window.onclick = function (e) { if (e.target == document.getElementById('deleteModal')) document.getElementById('deleteModal').style.display = 'none'; };
<?php if  (isset($_GET['msg'])): ?> function showToast(m) { const c = document.getElementById('toastContainer'), t = document.createElement('div'); t.className = 'toast'; t.innerHTML = `<i class="fas fa-check-circle" style="color:#10b981"></i> ${m}`; c.appendChild(t); setTimeout(() => { t.style.opacity = '0'; setTimeout(() => t.remove(), 300); }, 3000); }showToast("<?= htmlspecialchars($_GET['msg'])?>");<?php
endif; ?>
    </script>
</body>

</html>