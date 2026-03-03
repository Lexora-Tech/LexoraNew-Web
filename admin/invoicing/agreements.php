<?php
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");

$search = mysqli_real_escape_string($conn, $_GET['search'] ?? '');
$filterStatus = mysqli_real_escape_string($conn, $_GET['status'] ?? '');
$where = "1=1";
if ($search)
    $where .= " AND (a.agreement_number LIKE '%$search%' OR c.name LIKE '%$search%')";
if ($filterStatus)
    $where .= " AND a.status='$filterStatus'";

$q = mysqli_query($conn, "SELECT a.*, c.name as customer_name, i.invoice_number FROM service_agreements a LEFT JOIN customers c ON a.customer_id=c.id LEFT JOIN invoices i ON a.invoice_id=i.id WHERE $where ORDER BY a.created_at DESC");
$count = mysqli_num_rows($q);
$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Agreements — Lexora Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
        }

        :root {
            --bg-body: #f4f4f5;
            --bg-card: #ffffff;
            --bg-sidebar: #121212;
            --text-primary: #1a1a1a;
            --text-secondary: #6b7280;
            --border: #e5e7eb;
            --primary: #ffb400;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --sidebar-width: 260px;
        }

        @media(prefers-color-scheme:dark) {
            :root {
                --bg-body: #0a0a0a;
                --bg-card: #1a1a1a;
                --bg-sidebar: #000000;
                --text-primary: #f5f5f5;
                --text-secondary: #9ca3af;
                --border: #2d2d2d;
            }
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: var(--bg-sidebar);
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 10px;
        }

        .brand img {
            width: 36px;
            height: 36px;
            border-radius: 8px;
        }

        .brand span {
            color: #fff;
            font-weight: 700;
            font-size: 15px;
        }

        .menu-label {
            color: rgba(255, 255, 255, 0.4);
            font-size: 11px;
            font-weight: 600;
            padding: 12px 20px 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            color: rgba(255, 255, 255, 0.65);
            text-decoration: none;
            font-size: 13.5px;
            transition: all .2s;
        }

        .nav-item:hover,
        .nav-item.active {
            background: rgba(255, 180, 0, 0.12);
            color: #ffb400;
        }

        .nav-item i {
            width: 18px;
            text-align: center;
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 30px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }

        header h2 {
            font-size: 22px;
            font-weight: 700;
        }

        .header-actions {
            display: flex;
            gap: 10px;
            align-items: center;
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
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: #000;
        }

        .btn-primary:hover {
            filter: brightness(1.1);
        }

        .search-bar {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .search-bar input,
        .search-bar select {
            padding: 9px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            background: var(--bg-card);
            color: var(--text-primary);
        }

        .search-bar input {
            flex: 1;
            min-width: 200px;
        }

        .card {
            background: var(--bg-card);
            border-radius: 12px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: rgba(0, 0, 0, 0.03);
            padding: 12px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border);
        }

        @media(prefers-color-scheme:dark) {
            th {
                background: rgba(255, 255, 255, 0.04);
            }
        }

        td {
            padding: 12px 16px;
            font-size: 13.5px;
            border-bottom: 1px solid var(--border);
        }

        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-draft {
            background: rgba(107, 114, 128, 0.15);
            color: #6b7280;
        }

        .badge-sent {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
        }

        .badge-signed {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
        }

        .badge-cancelled {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }

        .actions {
            display: flex;
            gap: 6px;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: 1px solid var(--border);
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13px;
            transition: all .2s;
            cursor: pointer;
            background: transparent;
        }

        .btn-icon:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 13px;
            background: rgba(16, 185, 129, 0.12);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .empty {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }

        .empty i {
            font-size: 48px;
            margin-bottom: 12px;
            opacity: 0.3;
            display: block;
        }

        .menu-toggle {
            display: none;
            font-size: 20px;
            cursor: pointer;
            color: var(--text-primary);
            margin-right: 15px;
        }

        @media(max-width:900px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform .3s;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
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
                <div class="header-left" style="display:flex;align-items:center;">
                    <i class="fas fa-bars menu-toggle" id="menuToggle"></i>
                    <h2>Service Agreements (
                        <?= $count?>)
                    </h2>
                </div>
            </header>
            <?php if ($msg): ?>
            <div class="alert">
                <?= htmlspecialchars($msg)?>
            </div>
            <?php
endif; ?>
            <form class="search-bar" method="GET">
                <input type="text" name="search" placeholder="Search by agreement # or customer..."
                    value="<?= htmlspecialchars($search)?>">
                <select name="status" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="draft" <?=$filterStatus === 'draft'  ? 'selected' : ''?>>Draft</option>
                    <option value="sent" <?=$filterStatus === 'sent'  ? 'selected' : ''?>>Sent</option>
                    <option value="signed" <?=$filterStatus === 'signed'  ? 'selected' : ''?>>Signed</option>
                    <option value="cancelled" <?=$filterStatus === 'cancelled'  ? 'selected' : ''?>>Cancelled</option>
                </select>
                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Search</button>
            </form>
            <div class="card">
                <?php if ($count === 0): ?>
                <div class="empty"><i class="fas fa-file-contract"></i>
                    <p>No agreements found. Generate one from an invoice.</p>
                </div>
                <?php
else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Agreement #</th>
                            <th>Customer</th>
                            <th>Invoice</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($q)): ?>
                        <tr>
                            <td><strong>
                                    <?= htmlspecialchars($row['agreement_number'])?>
                                </strong></td>
                            <td>
                                <?= htmlspecialchars($row['customer_name'] ?? 'N/A')?>
                            </td>
                            <td><a href="invoice_view.php?id=<?= $row['invoice_id']?>" style="color:var(--primary);">
                                    <?= htmlspecialchars($row['invoice_number'] ?? '')?>
                                </a></td>
                            <td>
                                <?= $row['effective_date'] ? date("M d, Y", strtotime($row['effective_date'])) : '-'?>
                            </td>
                            <td><span class="badge badge-<?= $row['status']?>">
                                    <?= ucfirst($row['status'])?>
                                </span></td>
                            <td>
                                <div class="actions">
                                    <a href="agreement_view.php?id=<?= $row['id']?>" class="btn-icon" title="View"><i
                                            class="fas fa-eye"></i></a>
                                    <a href="agreement_form.php?id=<?= $row['id']?>" class="btn-icon" title="Edit"><i
                                            class="fas fa-pen"></i></a>
                                    <a href="generate_pdf.php?type=agreement&id=<?= $row['id']?>" class="btn-icon"
                                        title="PDF" target="_blank"><i class="fas fa-file-pdf"></i></a>
                                    <a href="send_email.php?type=agreement&id=<?= $row['id']?>" class="btn-icon"
                                        title="Send Email"><i class="fas fa-paper-plane"></i></a>
                                    <div class="btn-icon"
                                        onclick="if(confirm('Delete this agreement?'))location.href='agreement_delete.php?id=<?= $row['id']?>'"
                                        title="Delete" style="cursor:pointer;"><i class="fas fa-trash"></i></div>
                                </div>
                            </td>
                        </tr>
                        <?php
    endwhile; ?>
                    </tbody>
                </table>
                <?php
endif; ?>
            </div>
        </div>
    </div>
    <script>
        const menuToggle = document.getElementById('menuToggle'), sidebar = document.getElementById('sidebar');
        if (menuToggle) menuToggle.addEventListener('click', () => sidebar.classList.toggle('active'));
    </script>
</body>

</html>