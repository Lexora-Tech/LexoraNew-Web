<?php
include(__DIR__ . "/../../includes/auth.php");
include(__DIR__ . "/../../includes/db.php");

$editing = false;
$customer = ['name' => '', 'email' => '', 'phone' => '', 'company' => '', 'address' => '', 'city' => '', 'country' => '', 'tax_id' => '', 'notes' => ''];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $q = mysqli_query($conn, "SELECT * FROM customers WHERE id=$id");
    if ($row = mysqli_fetch_assoc($q)) {
        $customer = $row;
        $editing = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $editing ? 'Edit' : 'Add'?> Customer | Lexora Admin
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
            height: 32px;
            width: auto
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
            max-width: 900px
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
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px
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
            color: var(--text-main);
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
            outline: none;
            transition: 0.2s
        }

        .form-input:focus,
        .form-textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 180, 0, 0.1)
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical
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
            cursor: pointer;
            transition: 0.2s
        }

        .btn-secondary:hover {
            background: var(--border)
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
            <a href="../add_blog.php" class="nav-item"><i class="fas fa-plus-circle"></i> <span>Add New</span></a>
            <div class="menu-label" style="margin-top:20px;">Billing</div>
            <a href="billing_dashboard.php" class="nav-item"><i class="fas fa-chart-pie"></i> <span>Overview</span></a>
            <a href="quotations.php" class="nav-item"><i class="fas fa-file-invoice"></i> <span>Quotations</span></a>
            <a href="invoices.php" class="nav-item"><i class="fas fa-file-invoice-dollar"></i> <span>Invoices</span></a>
            <a href="customers.php" class="nav-item active"><i class="fas fa-users"></i> <span>Customers</span></a>
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
                    <h2>
                        <?= $editing ? 'Edit Customer' : 'Add Customer'?>
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
                <form action="customer_save.php" method="POST" class="form-container">
                    <div class="form-title"><i class="fas fa-user-plus"
                            style="color:var(--primary);margin-right:10px;"></i>
                        <?= $editing ? 'Edit Customer Details' : 'New Customer'?>
                    </div>
                    <?php if ($editing): ?><input type="hidden" name="id" value="<?= $customer['id']?>">
                    <?php
endif; ?>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-input"
                                value="<?= htmlspecialchars($customer['name'])?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-input"
                                value="<?= htmlspecialchars($customer['email'] ?? '')?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-input"
                                value="<?= htmlspecialchars($customer['phone'] ?? '')?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Company</label>
                            <input type="text" name="company" class="form-input"
                                value="<?= htmlspecialchars($customer['company'] ?? '')?>">
                        </div>
                        <div class="form-group full">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-input"
                                value="<?= htmlspecialchars($customer['address'] ?? '')?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-input"
                                value="<?= htmlspecialchars($customer['city'] ?? '')?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-input"
                                value="<?= htmlspecialchars($customer['country'] ?? '')?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tax ID / VAT</label>
                            <input type="text" name="tax_id" class="form-input"
                                value="<?= htmlspecialchars($customer['tax_id'] ?? '')?>">
                        </div>
                        <div class="form-group full">
                            <label class="form-label">Notes</label>
                            <textarea name="notes"
                                class="form-textarea"><?= htmlspecialchars($customer['notes'] ?? '')?></textarea>
                        </div>
                    </div>

                    <div class="btn-row">
                        <a href="customers.php" class="btn-secondary">Cancel</a>
                        <button type="submit" class="btn-primary"><i class="fas fa-save"></i>
                            <?= $editing ? 'Update' : 'Save'?> Customer
                        </button>
                    </div>
                </form>
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