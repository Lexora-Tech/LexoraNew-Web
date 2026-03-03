<?php
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");

// --- Billing Dashboard Stats ---

// Total Revenue (paid invoices)
$rev_q = mysqli_query($conn, "SELECT COALESCE(SUM(amount_paid), 0) as total FROM invoices WHERE status='paid'");
$total_revenue = mysqli_fetch_assoc($rev_q)['total'];

// Unpaid invoices
$unpaid_q = mysqli_query($conn, "SELECT COUNT(*) as cnt, COALESCE(SUM(grand_total - amount_paid), 0) as total FROM invoices WHERE status IN ('sent','partial')");
$unpaid = mysqli_fetch_assoc($unpaid_q);

// Overdue invoices
$overdue_q = mysqli_query($conn, "SELECT COUNT(*) as cnt, COALESCE(SUM(grand_total - amount_paid), 0) as total FROM invoices WHERE status='overdue' OR (due_date < CURDATE() AND status IN ('sent','partial'))");
$overdue = mysqli_fetch_assoc($overdue_q);

// Total quotations
$quo_q = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM quotations");
$total_quotations = mysqli_fetch_assoc($quo_q)['cnt'];

// Total customers
$cust_q = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM customers");
$total_customers = mysqli_fetch_assoc($cust_q)['cnt'];

// Total invoices
$inv_q = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM invoices");
$total_invoices = mysqli_fetch_assoc($inv_q)['cnt'];

// Recent invoices
$recent_inv = mysqli_query($conn, "SELECT i.*, c.name as customer_name FROM invoices i LEFT JOIN customers c ON i.customer_id = c.id ORDER BY i.created_at DESC LIMIT 10");

// Recent quotations
$recent_quo = mysqli_query($conn, "SELECT q.*, c.name as customer_name FROM quotations q LEFT JOIN customers c ON q.customer_id = c.id ORDER BY q.created_at DESC LIMIT 10");

function format_currency($amount)
{
    return 'LKR ' . number_format($amount, 2);
}

function getStatusBadge($status)
{
    $colors = [
        'draft' => 'background:rgba(107,114,128,0.1);color:#6b7280;',
        'sent' => 'background:rgba(59,130,246,0.1);color:#3b82f6;',
        'paid' => 'background:rgba(16,185,129,0.1);color:#10b981;',
        'overdue' => 'background:rgba(239,68,68,0.1);color:#ef4444;',
        'cancelled' => 'background:rgba(239,68,68,0.1);color:#ef4444;',
        'partial' => 'background:rgba(245,158,11,0.1);color:#f59e0b;',
        'accepted' => 'background:rgba(16,185,129,0.1);color:#10b981;',
        'rejected' => 'background:rgba(239,68,68,0.1);color:#ef4444;',
        'converted' => 'background:rgba(139,92,246,0.1);color:#8b5cf6;'
    ];
    $style = $colors[$status] ?? 'background:rgba(107,114,128,0.1);color:#6b7280;';
    return '<span style="padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;' . $style . '">' . ucfirst($status) . '</span>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Dashboard | Lexora Admin</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../img/logo/logo.png" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            --header-height: 70px;
        }
        body.dark {
            --bg-body: #0b0b0b;
            --bg-sidebar: #000000;
            --bg-card: #1e1e1e;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border: #333333;
        }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif; }
        body { background:var(--bg-body); color:var(--text-main); transition:0.3s ease; overflow-x:hidden; }
        a { text-decoration:none; color:inherit; }
        ul { list-style:none; }

        .dashboard-container { display:flex; min-height:100vh; }

        /* SIDEBAR */
        .sidebar { width:var(--sidebar-width); background:var(--bg-sidebar); color:#fff; position:fixed; height:100vh; left:0; top:0; z-index:100; display:flex; flex-direction:column; padding:20px; border-right:1px solid rgba(255,255,255,0.05); transition:0.3s ease; }
        .brand { display:flex; align-items:center; gap:12px; margin-bottom:40px; padding:0 10px; }
        .brand img { height:32px; width:auto; }
        .brand span { font-size:18px; font-weight:700; color:#fff; letter-spacing:0.5px; }
        .menu-label { font-size:12px; text-transform:uppercase; color:#666; margin-bottom:10px; padding-left:10px; font-weight:600; letter-spacing:1px; }
        .nav-item { display:flex; align-items:center; gap:12px; padding:12px 15px; border-radius:8px; color:#a0a0a0; transition:0.3s; margin-bottom:5px; }
        .nav-item:hover, .nav-item.active { background:rgba(255,180,0,0.1); color:var(--primary); }
        .nav-item i { width:20px; text-align:center; font-size:16px; }
        .sidebar-footer { margin-top:auto; padding-top:20px; border-top:1px solid rgba(255,255,255,0.1); }

        /* MAIN */
        .main-content { flex:1; margin-left:var(--sidebar-width); display:flex; flex-direction:column; }

        header { height:var(--header-height); background:var(--bg-card); border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; padding:0 30px; position:sticky; top:0; z-index:90; }
        .header-left h2 { font-size:20px; font-weight:600; }
        .header-right { display:flex; align-items:center; gap:20px; }
        .user-profile { display:flex; align-items:center; gap:10px; cursor:pointer; }
        .avatar { width:35px; height:35px; background:var(--primary); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#000; font-weight:bold; }
        .user-info { display:flex; flex-direction:column; line-height:1.2; }
        .user-name { font-size:14px; font-weight:600; }
        .user-role { font-size:11px; color:var(--text-muted); }

        .theme-switch { position:relative; width:40px; height:20px; cursor:pointer; }
        .theme-switch input { display:none; }
        .slider { position:absolute; inset:0; background:#ccc; border-radius:20px; transition:.4s; }
        .slider:before { content:""; position:absolute; height:16px; width:16px; left:2px; bottom:2px; background:white; border-radius:50%; transition:.4s; }
        input:checked + .slider { background:var(--primary); }
        input:checked + .slider:before { transform:translateX(20px); }

        .content-wrapper { padding:30px; }

        /* STATS GRID */
        .stats-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:20px; margin-bottom:30px; }
        .stat-card { background:var(--bg-card); padding:20px; border-radius:12px; border:1px solid var(--border); display:flex; align-items:center; gap:20px; transition:0.3s; }
        .stat-card:hover { transform:translateY(-5px); box-shadow:0 10px 20px rgba(0,0,0,0.05); border-color:var(--primary); }
        .stat-icon { width:50px; height:50px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:20px; }
        .stat-icon.gold { background:rgba(255,180,0,0.1); color:#ffb400; }
        .stat-icon.green { background:rgba(16,185,129,0.1); color:#10b981; }
        .stat-icon.blue { background:rgba(37,99,235,0.1); color:#2563eb; }
        .stat-icon.red { background:rgba(239,68,68,0.1); color:#ef4444; }
        .stat-icon.purple { background:rgba(139,92,246,0.1); color:#8b5cf6; }
        .stat-info h4 { font-size:22px; font-weight:700; margin-bottom:2px; }
        .stat-info p { font-size:13px; color:var(--text-muted); }

        /* TABLE */
        .section-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
        .section-header h3 { font-size:18px; font-weight:600; }
        .btn-add { background:var(--primary); color:#000; padding:10px 20px; border-radius:8px; font-weight:600; font-size:14px; transition:0.3s; display:flex; align-items:center; gap:8px; }
        .btn-add:hover { background:var(--primary-hover); transform:translateY(-2px); }

        .table-container { background:var(--bg-card); border-radius:16px; border:1px solid var(--border); overflow:hidden; margin-bottom:30px; }
        .table-responsive { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; }
        thead { background:rgba(0,0,0,0.02); border-bottom:1px solid var(--border); }
        th { text-align:left; padding:16px 24px; font-size:12px; text-transform:uppercase; letter-spacing:0.5px; color:var(--text-muted); font-weight:600; }
        td { padding:16px 24px; border-bottom:1px solid var(--border); vertical-align:middle; font-size:14px; }
        tbody tr:hover { background:rgba(0,0,0,0.015); }
        tbody tr:last-child td { border-bottom:none; }

        .dual-section { display:grid; grid-template-columns:1fr 1fr; gap:30px; }

        @media (max-width:900px) {
            .sidebar { transform:translateX(-100%); position:fixed; }
            .sidebar.active { transform:translateX(0); }
            .main-content { margin-left:0; }
            .dual-section { grid-template-columns:1fr; }
            .menu-toggle { display:block; font-size:24px; cursor:pointer; margin-right:15px; }
        }
        @media (min-width:901px) { .menu-toggle { display:none; } }
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
        <a href="billing_dashboard.php" class="nav-item active"><i class="fas fa-chart-pie"></i> <span>Overview</span></a>
        <a href="quotations.php" class="nav-item"><i class="fas fa-file-invoice"></i> <span>Quotations</span></a>
        <a href="invoices.php" class="nav-item"><i class="fas fa-file-invoice-dollar"></i> <span>Invoices</span></a>
        <a href="customers.php" class="nav-item"><i class="fas fa-users"></i> <span>Customers</span></a>
        <div class="menu-label" style="margin-top:20px;">System</div>
        <a href="../settings.php" class="nav-item"><i class="fas fa-cog"></i> <span>Settings</span></a>
        <a href="../quote_requests.php" class="nav-item"><i class="fas fa-envelope"></i> <span>Inquiries</span></a>
        <div class="sidebar-footer">
            <a href="../logout.php" class="nav-item" style="color:var(--danger);"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
        </div>
    </aside>

    <div class="main-content">
        <header>
            <div class="header-left" style="display:flex;align-items:center;">
                <i class="fas fa-bars menu-toggle" id="menuToggle"></i>
                <div>
                    <h2>Billing Dashboard</h2>
                    <span style="font-size:13px;color:var(--text-muted);"><?php echo date("l, F j, Y"); ?></span>
                </div>
            </div>
            <div class="header-right">
                <label class="theme-switch"><input type="checkbox" id="themeToggle"><span class="slider"></span></label>
                <div class="user-profile">
                    <div class="user-info">
                        <span class="user-name"><?php echo $_SESSION['admin']; ?></span>
                        <span class="user-role">Administrator</span>
                    </div>
                    <div class="avatar"><?php echo strtoupper(substr($_SESSION['admin'], 0, 1)); ?></div>
                </div>
            </div>
        </header>

        <div class="content-wrapper">
            <!-- STATS -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon gold"><i class="fas fa-coins"></i></div>
                    <div class="stat-info">
                        <h4><?php echo format_currency($total_revenue); ?></h4>
                        <p>Total Revenue</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fas fa-clock"></i></div>
                    <div class="stat-info">
                        <h4><?php echo $unpaid['cnt']; ?></h4>
                        <p>Unpaid Invoices (<?php echo format_currency($unpaid['total']); ?>)</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon red"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="stat-info">
                        <h4><?php echo $overdue['cnt']; ?></h4>
                        <p>Overdue (<?php echo format_currency($overdue['total']); ?>)</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon purple"><i class="fas fa-file-alt"></i></div>
                    <div class="stat-info">
                        <h4><?php echo $total_quotations; ?></h4>
                        <p>Total Quotations</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green"><i class="fas fa-file-invoice-dollar"></i></div>
                    <div class="stat-info">
                        <h4><?php echo $total_invoices; ?></h4>
                        <p>Total Invoices</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fas fa-users"></i></div>
                    <div class="stat-info">
                        <h4><?php echo $total_customers; ?></h4>
                        <p>Total Customers</p>
                    </div>
                </div>
            </div>

            <!-- RECENT TABLES -->
            <div class="dual-section">
                <div>
                    <div class="section-header">
                        <h3>Recent Invoices</h3>
                        <a href="invoices.php" class="btn-add"><i class="fas fa-eye"></i> View All</a>
                    </div>
                    <div class="table-container">
                        <div class="table-responsive">
                            <table>
                                <thead><tr><th>Invoice</th><th>Customer</th><th>Amount</th><th>Status</th></tr></thead>
                                <tbody>
                                <?php if (mysqli_num_rows($recent_inv) == 0): ?>
                                    <tr><td colspan="4" style="text-align:center;color:var(--text-muted);padding:30px;">No invoices yet</td></tr>
                                <?php
else:
    while ($inv = mysqli_fetch_assoc($recent_inv)): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($inv['invoice_number'])?></strong></td>
                                        <td><?= htmlspecialchars($inv['customer_name'] ?? 'N/A')?></td>
                                        <td><?= format_currency($inv['grand_total'])?></td>
                                        <td><?= getStatusBadge($inv['status'])?></td>
                                    </tr>
                                <?php
    endwhile;
endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="section-header">
                        <h3>Recent Quotations</h3>
                        <a href="quotations.php" class="btn-add"><i class="fas fa-eye"></i> View All</a>
                    </div>
                    <div class="table-container">
                        <div class="table-responsive">
                            <table>
                                <thead><tr><th>Quotation</th><th>Customer</th><th>Amount</th><th>Status</th></tr></thead>
                                <tbody>
                                <?php if (mysqli_num_rows($recent_quo) == 0): ?>
                                    <tr><td colspan="4" style="text-align:center;color:var(--text-muted);padding:30px;">No quotations yet</td></tr>
                                <?php
else:
    while ($quo = mysqli_fetch_assoc($recent_quo)): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($quo['quotation_number'])?></strong></td>
                                        <td><?= htmlspecialchars($quo['customer_name'] ?? 'N/A')?></td>
                                        <td><?= format_currency($quo['grand_total'])?></td>
                                        <td><?= getStatusBadge($quo['status'])?></td>
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
    </div>
</div>

<script>
const menuToggle = document.getElementById('menuToggle');
const sidebar = document.getElementById('sidebar');
if(menuToggle) menuToggle.addEventListener('click', () => sidebar.classList.toggle('active'));

const themeToggle = document.getElementById("themeToggle");
if(localStorage.getItem("theme")==="dark"){document.body.classList.add("dark");themeToggle.checked=true;}
themeToggle.addEventListener("change",()=>{
    if(themeToggle.checked){document.body.classList.add("dark");localStorage.setItem("theme","dark");}
    else{document.body.classList.remove("dark");localStorage.setItem("theme","light");}
});
</script>
</body>
</html>
