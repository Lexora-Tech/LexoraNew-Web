<?php
include("../includes/auth.php");
include("../includes/db.php");

// Fetch Inquiries
$sql = "SELECT * FROM quote_requests ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);

// Helper for initials
function getInitials($name)
{
    $words = explode(" ", $name);
    $acronym = "";
    foreach ($words as $w) {
        $acronym .= mb_substr($w, 0, 1);
    }
    return strtoupper(substr($acronym, 0, 2));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiries | Lexora Admin</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/logo/logo.png" />

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- VARIABLES --- */
        :root {
            --primary: #ffb400;
            --primary-hover: #e5a300;
            --bg-body: #f8f9fa;
            --bg-sidebar: #121212;
            --bg-card: #ffffff;
            --text-main: #0f172a;
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
            --bg-card: #161616;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border: #2d2d2d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: var(--bg-body);
            color: var(--text-main);
            transition: 0.3s ease;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* --- LAYOUT --- */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
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
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            transition: 0.3s ease;
        }

        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
            padding: 0 10px;
        }

        .brand img {
            height: 32px;
            width: auto;
        }

        .brand span {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
        }

        .menu-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 10px;
            padding-left: 10px;
            font-weight: 600;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: 8px;
            color: #a0a0a0;
            transition: 0.3s;
            margin-bottom: 5px;
        }

        .nav-item:hover,
        .nav-item.active {
            background: rgba(255, 180, 0, 0.1);
            color: var(--primary);
        }

        .nav-item i {
            width: 20px;
            text-align: center;
            font-size: 16px;
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
            z-index: 90;
        }

        .header-left h2 {
            font-size: 20px;
            font-weight: 600;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
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
            font-weight: bold;
        }

        /* --- TABLE STYLES --- */
        .content-wrapper {
            padding: 30px;
            max-width: 100%;
        }

        .table-container {
            background: var(--bg-card);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: rgba(0, 0, 0, 0.02);
            border-bottom: 1px solid var(--border);
        }

        th {
            text-align: left;
            padding: 20px 30px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            font-weight: 600;
        }

        td {
            padding: 20px 30px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            font-size: 15px;
        }

        tbody tr:hover {
            background: rgba(0, 0, 0, 0.015);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* Client Cell */
        .client-cell {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .client-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 180, 0, 0.1);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            border: 1px solid rgba(255, 180, 0, 0.2);
        }

        .client-details {
            display: flex;
            flex-direction: column;
        }

        .client-name {
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 4px;
            font-size: 16px;
        }

        .client-email {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* Badges */
        .badge {
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-new {
            background: rgba(59, 130, 246, 0.1);
            color: var(--info);
        }

        .status-replied {
            background: rgba(255, 180, 0, 0.1);
            color: #b48000;
        }

        .status-closed {
            background: rgba(34, 197, 94, 0.1);
            color: var(--success);
        }

        .budget-tag {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            color: var(--text-main);
            background: rgba(0, 0, 0, 0.05);
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 14px;
        }

        .service-count {
            color: var(--text-muted);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Actions */
        .action-cell {
            display: flex;
            gap: 12px;
        }

        .btn-icon {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            color: var(--text-muted);
            cursor: pointer;
            transition: 0.2s;
            background: transparent;
            font-size: 16px;
        }

        .btn-icon:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .btn-icon.delete:hover {
            border-color: var(--danger);
            color: var(--danger);
        }

        /* --- MODAL --- */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 2000;
            backdrop-filter: blur(5px);
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease;
        }

        .crm-card {
            background: var(--bg-card);
            width: 95%;
            max-width: 1100px;
            height: 85vh;
            border-radius: 20px;
            border: 1px solid var(--border);
            display: flex;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .crm-main {
            flex: 1.5;
            padding: 40px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--border);
        }

        .crm-header {
            margin-bottom: 30px;
        }

        .crm-title h2 {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 5px;
        }

        .info-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .info-card {
            background: var(--bg-body);
            border: 1px solid var(--border);
            padding: 15px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .info-label {
            font-size: 11px;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 700;
        }

        .info-value {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-main);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .info-card.budget {
            background: rgba(255, 180, 0, 0.05);
            border-color: rgba(255, 180, 0, 0.3);
        }

        .info-card.budget .info-value {
            color: #b48000;
            font-size: 18px;
        }

        .section-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            font-weight: 700;
            margin-bottom: 12px;
            display: block;
            border-bottom: 1px solid var(--border);
            padding-bottom: 8px;
            margin-top: 10px;
        }

        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 25px;
        }

        .tag {
            padding: 8px 16px;
            background: var(--bg-body);
            border: 1px solid var(--border);
            border-radius: 20px;
            font-size: 14px;
            color: var(--text-main);
            font-weight: 500;
        }

        .message-body {
            background: var(--bg-body);
            padding: 25px;
            border-radius: 12px;
            font-size: 16px;
            line-height: 1.7;
            color: var(--text-main);
            border: 1px solid var(--border);
            white-space: pre-wrap;
        }

        /* RIGHT SIDEBAR */
        .crm-sidebar {
            flex: 1;
            background: var(--bg-body);
            padding: 30px;
            display: flex;
            flex-direction: column;
            min-width: 380px;
            /* Added scrollability if content is long */
            overflow-y: auto;
        }

        .modal-tabs {
            display: flex;
            border-bottom: 1px solid var(--border);
            margin-bottom: 25px;
        }

        .tab-btn {
            flex: 1;
            background: none;
            border: none;
            padding: 12px;
            font-size: 14px;
            font-weight: 700;
            color: var(--text-muted);
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: 0.3s;
        }

        .tab-btn.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        .tab-content {
            display: none;
            flex: 1;
            flex-direction: column;
        }

        .tab-content.active {
            display: flex;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .template-link {
            color: var(--primary);
            cursor: pointer;
            font-weight: 600;
            font-size: 11px;
            text-decoration: underline;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--bg-card);
            color: var(--text-main);
            font-size: 14px;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--primary);
        }

        .btn-send,
        .btn-save {
            background: var(--primary);
            color: #000;
            padding: 14px;
            border-radius: 8px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            width: 100%;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: 0.2s;
            margin-top: auto;
        }

        .btn-save {
            background: var(--success);
            color: #fff;
            margin-top: 20px;
        }

        .btn-send:hover {
            background: var(--primary-hover);
        }

        .btn-save:hover {
            background: #059669;
        }

        .close-btn {
            background: var(--bg-card);
            border: 1px solid var(--border);
            font-size: 24px;
            color: var(--text-main);
            cursor: pointer;
            position: absolute;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            transition: 0.2s;
        }

        .close-btn:hover {
            background: var(--danger);
            color: #fff;
            border-color: var(--danger);
        }

        /* DELETE MODAL */
        .delete-modal-content {
            background: var(--bg-card);
            padding: 30px;
            border-radius: 16px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            border: 1px solid var(--border);
        }

        .modal-btns {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        .btn-confirm-delete {
            background: var(--danger);
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-main);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        /* ANIMATIONS & TOAST */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .toast-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 3000;
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
            animation: slideIn 0.3s ease;
        }

        /* Theme Toggle */
        .theme-switch {
            position: relative;
            width: 40px;
            height: 20px;
            cursor: pointer;
        }

        .theme-switch input {
            display: none;
        }

        .slider {
            position: absolute;
            inset: 0;
            background: #ccc;
            border-radius: 20px;
            transition: .4s;
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
            transition: .4s;
        }

        input:checked+.slider {
            background: var(--primary);
        }

        input:checked+.slider:before {
            transform: translateX(20px);
        }

        @media (max-width: 900px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .crm-card {
                flex-direction: column;
                height: auto;
                max-height: 90vh;
                overflow-y: auto;
            }

            .crm-sidebar {
                border-left: none;
                border-top: 1px solid var(--border);
            }

            .close-btn {
                display: block;
            }

            .info-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="dashboard-container">
        <aside class="sidebar" id="sidebar">
            <div class="brand"> <img src="../img/logo/logo.png" alt="Logo"><span>Lexora Admin</span></div>
            <div class="menu-label">Main Menu</div>
            <a href="dashboard.php" class="nav-item"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            <a href="all_blogs.php" class="nav-item"><i class="fas fa-layer-group"></i> <span>All Blogs</span></a>
            <a href="add_blog.php" class="nav-item"><i class="fas fa-plus-circle"></i> <span>Add New</span></a>
            <div class="menu-label" style="margin-top: 20px;">System</div>
            <a href="settings.php" class="nav-item"><i class="fas fa-cog"></i> <span>Settings</span></a>
            <a href="#" class="nav-item active"><i class="fas fa-envelope"></i> <span>Inquiries</span></a>
            <div class="sidebar-footer" style="margin-top: auto;">
                <a href="logout.php" class="nav-item" style="color: var(--danger);"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
            </div>
        </aside>

        <div class="main-content">
            <header>
                <div class="header-left" style="display:flex; align-items:center;">
                    <i class="fas fa-bars" id="menuToggle" style="font-size:24px; cursor:pointer; margin-right:15px; display:none;"></i>
                    <h2>Quote Requests</h2>
                </div>
                <div style="display: flex; align-items: center; gap: 20px;">
                    <label class="theme-switch"><input type="checkbox" id="themeToggle"><span class="slider"></span></label>
                    <div class="user-profile">
                        <div class="avatar"><?php echo strtoupper(substr($_SESSION['admin'], 0, 1)); ?></div>
                    </div>
                </div>
            </header>

            <div class="content-wrapper">
                <div class="table-container">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Client Profile</th>
                                    <th>Status</th>
                                    <th>Company</th>
                                    <th>Budget</th>
                                    <th>Services</th>
                                    <th style="text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($count > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $servicesArray = array_filter(explode(",", $row['services']));
                                        $serviceCount = count($servicesArray);
                                        $statusClass = 'status-new';
                                        $statusLabel = 'New Lead';
                                        if ($row['status'] == 'replied') {
                                            $statusClass = 'status-replied';
                                            $statusLabel = 'Replied';
                                        }
                                        if ($row['status'] == 'closed') {
                                            $statusClass = 'status-closed';
                                            $statusLabel = 'Closed';
                                        }
                                ?>
                                        <tr id="row-<?= $row['id'] ?>">
                                            <td>
                                                <div class="client-cell">
                                                    <div class="client-avatar"><?= getInitials($row['name']) ?></div>
                                                    <div class="client-details"><span class="client-name"><?= htmlspecialchars($row['name']) ?></span><span class="client-email"><?= htmlspecialchars($row['email']) ?></span></div>
                                                </div>
                                            </td>
                                            <td><span class="badge <?= $statusClass ?>"><i class="fas fa-circle" style="font-size: 6px;"></i> <?= $statusLabel ?></span></td>
                                            <td style="font-weight: 500; font-size: 15px;"><?= htmlspecialchars($row['company']) ?: '<span style="color:var(--text-muted)">-</span>' ?></td>
                                            <td><span class="budget-tag"><?= htmlspecialchars($row['budget']) ?></span></td>
                                            <td>
                                                <div class="service-count"><i class="fas fa-layer-group"></i> <?= $serviceCount ?> Services</div>
                                            </td>
                                            <td>
                                                <div class="action-cell" style="justify-content: flex-end;">
                                                    <button class="btn-icon view-trigger"
                                                        data-id="<?= $row['id'] ?>"
                                                        data-name="<?= htmlspecialchars($row['name']) ?>"
                                                        data-email="<?= htmlspecialchars($row['email']) ?>"
                                                        data-phone="<?= htmlspecialchars($row['phone']) ?>"
                                                        data-company="<?= htmlspecialchars($row['company']) ?>"
                                                        data-budget="<?= htmlspecialchars($row['budget']) ?>"
                                                        data-message="<?= htmlspecialchars($row['message']) ?>"
                                                        data-services="<?= htmlspecialchars($row['services']) ?>"
                                                        data-status="<?= htmlspecialchars($row['status']) ?>"
                                                        data-notes="<?= htmlspecialchars($row['admin_notes']) ?>">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn-icon delete delete-trigger" data-id="<?= $row['id'] ?>"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                <?php }
                                } else {
                                    echo "<tr><td colspan='6' style='text-align:center; padding: 60px; color:var(--text-muted);'>No inquiries found.</td></tr>";
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CRM MODAL -->
    <div class="modal" id="viewModal">
        <div class="crm-card">
            <button class="close-btn" id="closeViewModal">&times;</button>

            <!-- LEFT: INFO -->
            <div class="crm-main">
                <div class="crm-header">
                    <div class="crm-title">
                        <h2 id="modalName">Client Name</h2>
                        <div class="crm-subtitle" id="modalCompany">Company</div>
                    </div>
                </div>
                <div class="info-cards">
                    <div class="info-card budget"><span class="info-label">Budget</span><span class="info-value" id="modalBudget"></span></div>
                    <div class="info-card"><span class="info-label">Email</span><span class="info-value" id="modalEmail"></span></div>
                    <div class="info-card"><span class="info-label">Phone</span><span class="info-value" id="modalPhone"></span></div>
                </div>
                <span class="section-label">Services</span>
                <div class="tags-container" id="modalServices"></div>
                <span class="section-label">Message</span>
                <div class="message-body" id="modalMessage"></div>
            </div>

            <!-- RIGHT: REPLY FORM -->
            <div class="crm-sidebar">
                <div class="modal-tabs">
                    <button class="tab-btn active" onclick="switchTab('email')"><i class="fas fa-paper-plane"></i> Compose Reply</button>
                    <button class="tab-btn" onclick="switchTab('admin')"><i class="fas fa-edit"></i> Status & Notes</button>
                </div>

                <!-- TAB 1: EMAIL FORM -->
                <div id="tab-email" class="tab-content active">
                    <form id="replyForm">
                        <input type="hidden" id="replyId" name="id">
                        <input type="hidden" id="replyEmail" name="email">

                        <div class="input-group">
                            <label>Load Template</label>
                            <select id="templateSelect" class="form-control" onchange="applyTemplate()">
                                <option value="standard">Standard Reply (Initial)</option>
                                <option value="more_info">Request More Info</option>
                                <option value="booking">Schedule a Call</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label>Subject</label>
                            <input type="text" name="subject" id="replySubject" class="form-control" value="Re: Project Inquiry - Lexora Tech">
                        </div>
                        <div class="input-group" style="flex:1; display:flex; flex-direction:column;">
                            <label>Message Body</label>
                            <textarea name="message" id="replyBody" class="form-control" style="height: 300px; resize: vertical;"></textarea>
                        </div>
                        <button type="submit" id="sendBtn" class="btn-send"><i class="fas fa-paper-plane"></i> Send Email</button>
                    </form>
                </div>

                <!-- TAB 2: ADMIN STATUS FORM -->
                <div id="tab-admin" class="tab-content">
                    <form id="statusForm">
                        <input type="hidden" id="statusId" name="id">
                        <div class="input-group">
                            <label>Inquiry Status</label>
                            <select name="status" id="statusInput" class="form-control" style="cursor:pointer;">
                                <option value="new">🔵 New Lead</option>
                                <option value="replied">🟡 Replied</option>
                                <option value="closed">🟢 Closed / Won</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label>Internal Notes</label>
                            <textarea name="admin_notes" id="notesInput" class="form-control" placeholder="Add private notes about this client..." style="min-height: 250px;"></textarea>
                        </div>
                        <button type="button" id="saveStatusBtn" class="btn-save"><i class="fas fa-save"></i> Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- DELETE MODAL -->
    <div class="modal" id="deleteModal">
        <div class="delete-modal-content">
            <i class="fas fa-trash-alt" style="color: var(--danger); font-size: 30px; margin-bottom: 20px;"></i>
            <h3>Delete Inquiry?</h3>
            <p style="color: var(--text-muted); margin-bottom: 20px;">This cannot be undone.</p>
            <div class="modal-btns">
                <button id="cancelDelete" class="btn-outline">Cancel</button>
                <button id="confirmDelete" class="btn-confirm-delete">Delete</button>
            </div>
        </div>
    </div>

    <div id="toastContainer" class="toast-container"></div>

    <script>
        // --- GLOBAL VARS FOR TEMPLATES ---
        let currentClient = {
            name: '',
            services: '',
            budget: ''
        };

        // --- TAB SWITCHER ---
        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));

            document.getElementById('tab-' + tabName).style.display = 'flex';
            const buttons = document.querySelectorAll('.tab-btn');
            if (tabName === 'email') buttons[0].classList.add('active');
            else buttons[1].classList.add('active');
        }

        // --- TEMPLATE LOGIC ---
        function applyTemplate() {
            const type = document.getElementById('templateSelect').value;
            const name = currentClient.name;
            const services = currentClient.services;
            const budget = currentClient.budget;

            let body = "";

            // 1. THE "PARTNERSHIP" REPLY (Standard)
            if (type === "standard") {
                body = `Hi ${name},

Thanks for reaching out to Lexora Tech!

I’ve reviewed your request regarding ${services}, and it sounds like a project where we can really add value. Given your budget range of ${budget}, we have a few approaches that would work well.

I’d love to schedule a quick 15-minute discovery call to hear more about your vision and see if we're a good fit.

Are you free this Tuesday or Thursday afternoon?

Best regards,

The Lexora Tech Team
www.lexoratech.com`;
            }

            // 2. THE "DEEP DIVE" REPLY (Request Info)
            else if (type === "more_info") {
                body = `Hi ${name},

Thank you for contacting Lexora Tech. We are excited about the potential of working on your ${services} project.

To ensure we provide you with an accurate proposal and timeline, could you share a few more details? Specifically:

1. Do you have a target launch date?
2. Are there any specific reference websites/apps you admire?
3. Do you already have brand assets (Logo, Colors) ready?

Once we have this info, we can put together a tailored roadmap for you.

Best regards,

The Lexora Tech Team
www.lexoratech.com`;
            }

            // 3. THE "CALENDAR LINK" REPLY (Booking)
            else if (type === "booking") {
                body = `Hi ${name},

Thanks for your interest in Lexora Tech. We'd be happy to help you with ${services}.

Since your project involves a few moving parts, the best next step is a brief strategy call. We can discuss your requirements and how to maximize your budget of ${budget}.

You can select a time that works best for you directly on our calendar here:

[INSERT CALENDLY / GOOGLE CALENDAR LINK HERE]

Looking forward to speaking with you.

Best regards,

The Lexora Tech Team
www.lexoratech.com`;
            }

            document.getElementById('replyBody').value = body;
        }

        // --- VIEW MODAL LOGIC ---
        const viewModal = document.getElementById('viewModal');
        document.querySelectorAll('.view-trigger').forEach(btn => {
            btn.addEventListener('click', function() {
                const data = this.dataset;

                // Store data for templates
                currentClient.name = data.name;
                currentClient.budget = data.budget;

                // Populate UI
                document.getElementById('modalName').textContent = data.name;
                document.getElementById('modalCompany').textContent = data.company || 'N/A';
                document.getElementById('modalBudget').textContent = data.budget;
                document.getElementById('modalEmail').textContent = data.email;
                document.getElementById('modalPhone').textContent = data.phone || '-';
                document.getElementById('modalMessage').textContent = data.message || 'No message.';

                // Forms
                document.getElementById('replyId').value = data.id;
                document.getElementById('replyEmail').value = data.email;
                document.getElementById('statusId').value = data.id;
                document.getElementById('statusInput').value = data.status || 'new';
                document.getElementById('notesInput').value = data.notes || '';

                // Services Logic
                const servicesDiv = document.getElementById('modalServices');
                servicesDiv.innerHTML = '';
                let serviceStr = "";
                data.services.split(',').forEach(s => {
                    if (s.trim()) {
                        const t = document.createElement('div');
                        t.className = 'tag';
                        t.textContent = s.trim();
                        servicesDiv.appendChild(t);
                        serviceStr += s.trim() + ", ";
                    }
                });
                // Save cleaned service string for templates
                currentClient.services = serviceStr.slice(0, -2);

                // Apply Default Template
                document.getElementById('templateSelect').value = "standard";
                applyTemplate();

                switchTab('email');
                viewModal.style.display = 'flex';
            });
        });

        document.getElementById('closeViewModal').onclick = () => viewModal.style.display = 'none';

        // --- SEND REPLY AJAX ---
        document.getElementById('replyForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('sendBtn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            btn.disabled = true;

            const formData = new FormData(this);
            fetch('send_reply.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(data => {
                    if (data.trim() === 'success') {
                        showToast("Email sent successfully!");
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast("Error sending email.");
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                });
        });

        // --- SAVE STATUS AJAX ---
        document.getElementById('saveStatusBtn').addEventListener('click', function() {
            const btn = this;
            btn.innerHTML = 'Saving...';
            const formData = new FormData(document.getElementById('statusForm'));
            fetch('update_quote.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(data => {
                    if (data.trim() === 'success') {
                        showToast("Status updated!");
                        setTimeout(() => location.reload(), 800);
                    } else {
                        showToast("Error saving.");
                        btn.innerHTML = '<i class="fas fa-save"></i> Save Changes';
                    }
                });
        });

        // --- DELETE LOGIC ---
        let deleteId = null;
        const deleteModal = document.getElementById('deleteModal');
        document.querySelectorAll('.delete-trigger').forEach(btn => {
            btn.addEventListener('click', function() {
                deleteId = this.getAttribute('data-id');
                deleteModal.style.display = 'flex';
            });
        });
        document.getElementById('cancelDelete').onclick = () => deleteModal.style.display = 'none';
        document.getElementById('confirmDelete').onclick = () => {
            if (deleteId) {
                fetch(`delete_quote.php?id=${deleteId}`).then(() => {
                    deleteModal.style.display = 'none';
                    document.getElementById(`row-${deleteId}`).remove();
                    showToast("Deleted successfully");
                });
            }
        };

        function showToast(msg) {
            const box = document.getElementById('toastContainer');
            const div = document.createElement('div');
            div.className = 'toast';
            div.innerHTML = `<i class="fas fa-info-circle"></i> ${msg}`;
            box.appendChild(div);
            setTimeout(() => div.remove(), 3000);
        }

        // Theme & Mobile
        const menu = document.getElementById('menuToggle');
        const sb = document.getElementById('sidebar');
        if (menu) menu.onclick = () => sb.classList.toggle('active');
        if (window.innerWidth <= 768 && menu) menu.style.display = 'block';

        const themeToggle = document.getElementById("themeToggle");
        if (localStorage.getItem("theme") === "dark") {
            document.body.classList.add("dark");
            themeToggle.checked = true;
        }
        themeToggle.onchange = () => {
            document.body.classList.toggle("dark");
            localStorage.setItem("theme", themeToggle.checked ? "dark" : "light");
        };
    </script>
</body>

</html>