<?php
include("../includes/auth.php");
include("../includes/db.php");

// --- CONFIGURATION ---
$app_version = "2.5.2";

$message = "";
$msg_type = "";

// Handle Profile Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $current_user = $_SESSION['admin'];
    $new_username = mysqli_real_escape_string($conn, $_POST['username']);
    
    // In a real app, you would update bio/socials here too.
    // For now, we update the username which is in your DB.
    $update_query = "UPDATE admins SET username='$new_username' WHERE username='$current_user'";
    
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['admin'] = $new_username;
        $message = "Profile updated successfully.";
        $msg_type = "success";
    } else {
        $message = "Error updating profile.";
        $msg_type = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | Lexora Admin</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/logo/logo.png" />
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- VARIABLES --- */
        :root {
            --primary: #ffb400;
            --primary-hover: #e5a300;
            --bg-body: #f3f4f6;
            --bg-sidebar: #121212;
            --bg-surface: #ffffff;
            --text-main: #111827;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --danger: #ef4444;
            --success: #10b981;
            --sidebar-width: 260px;
            --header-height: 70px;
            --radius: 10px;
        }

        body.dark {
            --bg-body: #0f1113;
            --bg-sidebar: #000000;
            --bg-surface: #1a1d21;
            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
            --border: #2d3035;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: var(--bg-body); color: var(--text-main); transition: 0.3s ease; }
        a { text-decoration: none; color: inherit; }

        /* --- LAYOUT STRUCTURE --- */
        .dashboard-container { display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width); background: var(--bg-sidebar); color: #fff; position: fixed; height: 100vh;
            left: 0; top: 0; z-index: 100; display: flex; flex-direction: column; padding: 20px;
            border-right: 1px solid rgba(255,255,255,0.05);
        }
        .brand { display: flex; align-items: center; gap: 12px; margin-bottom: 40px; padding: 0 10px; }
        .brand img { height: 32px; width: auto; }
        .brand span { font-size: 18px; font-weight: 700; color: #fff; letter-spacing: -0.5px; }
        .menu-label { font-size: 12px; text-transform: uppercase; color: #666; margin-bottom: 10px; padding-left: 10px; font-weight: 600; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 15px; border-radius: var(--radius); color: #9ca3af; transition: 0.2s; margin-bottom: 5px; font-weight: 500; }
        .nav-item:hover, .nav-item.active { background: rgba(255, 180, 0, 0.1); color: var(--primary); }
        .nav-item i { width: 20px; text-align: center; font-size: 16px; }
        
        .main-content { flex: 1; margin-left: var(--sidebar-width); display: flex; flex-direction: column; }

        /* Header */
        header {
            height: var(--header-height); background: var(--bg-surface); border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between; padding: 0 40px; position: sticky; top: 0; z-index: 90;
        }
        .header-left h2 { font-size: 20px; font-weight: 700; color: var(--text-main); letter-spacing: -0.5px; }
        .user-profile { display: flex; align-items: center; gap: 10px; }
        .avatar { width: 36px; height: 36px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #000; font-weight: bold; font-size: 14px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }

        /* --- SETTINGS INTERFACE --- */
        .content-wrapper { padding: 40px; max-width: 1200px; margin: 0 auto; width: 100%; }

        .settings-container {
            display: flex;
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            min-height: 650px;
            overflow: hidden;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.08);
        }

        /* Internal Sidebar */
        .settings-nav {
            width: 260px;
            background: var(--bg-body); /* Slightly contrast bg */
            border-right: 1px solid var(--border);
            padding: 30px 15px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .settings-tab {
            padding: 12px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 12px;
            transition: 0.2s;
        }
        .settings-tab:hover { background: rgba(0,0,0,0.03); color: var(--text-main); }
        .settings-tab.active { background: var(--bg-surface); color: var(--primary); box-shadow: 0 2px 8px rgba(0,0,0,0.04); font-weight: 600; }
        .settings-tab i { width: 20px; text-align: center; }

        /* Content Area */
        .settings-panel {
            flex: 1;
            padding: 0;
            display: none; /* Hidden by default */
            animation: fadeIn 0.3s ease;
        }
        .settings-panel.active { display: block; }

        /* Profile Specific Styles */
        .profile-banner {
            height: 140px;
            background: linear-gradient(135deg, #111827, #1f2937);
            position: relative;
        }
        .profile-banner::after {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 20px 20px; opacity: 0.3;
        }
        
        .profile-header-content {
            padding: 0 40px;
            margin-top: -50px;
            display: flex;
            align-items: flex-end;
            gap: 25px;
            margin-bottom: 30px;
            position: relative;
        }
        
        .profile-pic {
            width: 120px; height: 120px; border-radius: 50%;
            background: var(--primary); border: 5px solid var(--bg-surface);
            display: flex; align-items: center; justify-content: center;
            font-size: 40px; font-weight: 700; color: #000;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            position: relative;
        }
        .edit-avatar-btn {
            position: absolute; bottom: 0; right: 0; background: var(--text-main); color: #fff;
            width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 14px; border: 2px solid var(--bg-surface); cursor: pointer;
        }

        .profile-meta h2 { font-size: 24px; font-weight: 700; color: var(--text-main); margin-bottom: 4px; }
        .profile-meta span { font-size: 14px; color: var(--text-muted); display: flex; align-items: center; gap: 6px; }
        .role-badge { background: rgba(255, 180, 0, 0.1); color: #b48000; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; }

        .panel-body { padding: 0 40px 40px 40px; }

        .section-title { font-size: 16px; font-weight: 600; color: var(--text-main); margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid var(--border); }

        /* Forms */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 30px; }
        .form-full { grid-column: span 2; }
        
        .form-group { margin-bottom: 5px; }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: var(--text-main); margin-bottom: 8px; }
        .form-input {
            width: 100%; background: var(--bg-surface); border: 1px solid var(--border); padding: 12px 15px;
            border-radius: 8px; color: var(--text-main); font-size: 14px; transition: 0.2s; outline: none;
        }
        .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(255, 180, 0, 0.1); }
        .form-input:disabled { background: var(--bg-body); cursor: not-allowed; opacity: 0.7; }
        
        .form-textarea { width: 100%; padding: 12px 15px; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-surface); min-height: 100px; resize: vertical; color: var(--text-main); outline: none; }
        .form-textarea:focus { border-color: var(--primary); }

        .btn-primary {
            background: var(--primary); color: #000; padding: 12px 25px; border-radius: 8px; font-weight: 600; font-size: 14px; border: none; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-primary:hover { background: var(--primary-hover); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

        /* Toggles & Lists */
        .toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid var(--border); }
        .toggle-text h4 { font-size: 14px; font-weight: 600; color: var(--text-main); margin-bottom: 2px; }
        .toggle-text p { font-size: 12px; color: var(--text-muted); }

        .switch { position: relative; display: inline-block; width: 40px; height: 22px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #e5e7eb; transition: .4s; border-radius: 22px; }
        .slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 2px; bottom: 2px; background-color: white; transition: .4s; border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        input:checked + .slider { background-color: var(--primary); }
        input:checked + .slider:before { transform: translateX(18px); }

        /* Login Activity Table */
        .activity-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .activity-table th { text-align: left; font-size: 11px; text-transform: uppercase; color: var(--text-muted); padding: 10px 0; border-bottom: 1px solid var(--border); }
        .activity-table td { padding: 15px 0; border-bottom: 1px solid var(--border); font-size: 14px; color: var(--text-main); }
        .device-icon { color: var(--text-muted); margin-right: 8px; }

        /* System Info Grid */
        .sys-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
        .sys-card { background: var(--bg-body); padding: 20px; border-radius: 12px; border: 1px solid var(--border); }
        .sys-label { font-size: 12px; color: var(--text-muted); display: block; margin-bottom: 5px; }
        .sys-val { font-size: 16px; font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: 8px; }
        .status-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--success); }

        /* Toast */
        .toast-container { position: fixed; bottom: 30px; right: 30px; z-index: 3000; }
        .toast { background: #1f2937; color: #fff; padding: 14px 24px; border-radius: 10px; font-size: 14px; display: flex; align-items: center; gap: 12px; animation: slideUp 0.4s ease; box-shadow: 0 10px 40px rgba(0,0,0,0.2); border-left: 4px solid var(--primary); }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        /* Theme Toggle */
        .theme-switch { position: relative; width: 40px; height: 20px; cursor: pointer; }
        .theme-switch input { display: none; }
        .slider-theme { position: absolute; inset: 0; background: #cbd5e1; border-radius: 20px; transition: .4s; }
        .slider-theme:before { content: ""; position: absolute; height: 16px; width: 16px; left: 2px; bottom: 2px; background: white; border-radius: 50%; transition: .4s; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
        input:checked + .slider-theme { background: var(--primary); }
        input:checked + .slider-theme:before { transform: translateX(20px); }

        @media (max-width: 900px) {
            .settings-container { flex-direction: column; height: auto; }
            .settings-nav { width: 100%; flex-direction: row; overflow-x: auto; border-right: none; border-bottom: 1px solid var(--border); padding: 15px; }
            .form-grid { grid-template-columns: 1fr; }
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .profile-header-content { flex-direction: column; align-items: center; text-align: center; margin-top: -60px; }
        }
    </style>
</head>

<body>

    <div class="dashboard-container">
        
        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <div class="brand"> <img src="../img/logo/logo.jpg" alt="Logo"><span>Lexora Admin</span></div>
            <div class="menu-label">Main Menu</div>
            <a href="dashboard.php" class="nav-item"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            <a href="all_blogs.php" class="nav-item"><i class="fas fa-layer-group"></i> <span>All Blogs</span></a>
            <a href="add_blog.php" class="nav-item"><i class="fas fa-plus-circle"></i> <span>Add New</span></a>
            <div class="menu-label" style="margin-top: 20px;">System</div>
            <a href="settings.php" class="nav-item active"><i class="fas fa-cog"></i> <span>Settings</span></a>
            <a href="quote_requests.php" class="nav-item"><i class="fas fa-envelope"></i> <span>Inquiries</span></a>
            <div class="sidebar-footer" style="margin-top: auto;">
                <a href="logout.php" class="nav-item" style="color: var(--danger);"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
            </div>
        </aside>

        <div class="main-content">
            
            <header>
                <div class="header-left" style="display:flex; align-items:center;">
                    <i class="fas fa-bars" id="menuToggle" style="font-size:24px; cursor:pointer; margin-right:15px; display:none;"></i>
                    <h2>Settings</h2>
                </div>
                <div style="display: flex; align-items: center; gap: 20px;">
                    <label class="theme-switch"><input type="checkbox" id="themeToggle"><span class="slider-theme"></span></label>
                    <div class="user-profile"><div class="avatar"><?php echo strtoupper(substr($_SESSION['admin'], 0, 1)); ?></div></div>
                </div>
            </header>

            <div class="content-wrapper">
                
                <div class="settings-container">
                    
                    <!-- Internal Navigation -->
                    <div class="settings-nav">
                        <div class="settings-tab active" onclick="openTab(event, 'profile')"><i class="fas fa-user"></i> My Profile</div>
                        <div class="settings-tab" onclick="openTab(event, 'security')"><i class="fas fa-shield-alt"></i> Security</div>
                        <div class="settings-tab" onclick="openTab(event, 'notifications')"><i class="fas fa-bell"></i> Notifications</div>
                        <div class="settings-tab" onclick="openTab(event, 'system')"><i class="fas fa-server"></i> System</div>
                    </div>

                    <!-- 1. PROFILE PANEL -->
                    <div id="profile" class="settings-panel active">
                        <div class="profile-banner"></div>
                        <div class="profile-header-content">
                            <div class="profile-pic">
                                <?php echo strtoupper(substr($_SESSION['admin'], 0, 1)); ?>
                                <div class="edit-avatar-btn" title="Change Photo"><i class="fas fa-camera"></i></div>
                            </div>
                            <div class="profile-meta">
                                <h2><?php echo $_SESSION['admin']; ?></h2>
                                <span><i class="fas fa-briefcase"></i> Administrator <span class="role-badge">Super Admin</span></span>
                            </div>
                        </div>

                        <div class="panel-body">
                            <form method="POST">
                                <div class="section-title">Personal Information</div>
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" class="form-input" value="<?php echo $_SESSION['admin']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" value="info@lexoratech.com" class="form-input" disabled>
                                    </div>
                                    <div class="form-group form-full">
                                        <label class="form-label">Bio / About</label>
                                        <textarea class="form-textarea" placeholder="Tell us a little about yourself..."></textarea>
                                    </div>
                                </div>

                                <div class="section-title">Social Links</div>
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label class="form-label">LinkedIn</label>
                                        <input type="text" class="form-input" placeholder="https://linkedin.com/in/...">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Twitter / X</label>
                                        <input type="text" class="form-input" placeholder="@username">
                                    </div>
                                </div>

                                <div style="text-align: right; margin-top: 20px;">
                                    <button type="submit" name="update_profile" class="btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- 2. SECURITY PANEL -->
                    <div id="security" class="settings-panel">
                        <div class="panel-header" style="padding: 40px 40px 20px 40px;">
                            <h3>Login & Security</h3>
                            <p>Manage your password and 2-factor authentication settings.</p>
                        </div>
                        <div class="panel-body">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Current Password</label>
                                    <input type="password" class="form-input" placeholder="••••••••">
                                </div>
                                <div class="form-group"></div> <!-- Spacer -->
                                <div class="form-group">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-input" placeholder="New password">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-input" placeholder="Confirm new password">
                                </div>
                            </div>
                            <div style="text-align: right; margin-bottom: 40px;">
                                <button type="button" class="btn-primary">Update Password</button>
                            </div>

                            <div class="section-title">Login Activity</div>
                            <table class="activity-table">
                                <thead>
                                    <tr>
                                        <th>Browser</th>
                                        <th>IP Address</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i class="fab fa-chrome device-icon"></i> Chrome On Windows</td>
                                        <td><?php echo $_SERVER['REMOTE_ADDR']; ?></td>
                                        <td>Just now</td>
                                        <td style="color:var(--success);">Active</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-mobile-alt device-icon"></i> Safari On iPhone</td>
                                        <td>202.14.33.12</td>
                                        <td>2 hours ago</td>
                                        <td>Signed Out</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 3. NOTIFICATIONS PANEL -->
                    <div id="notifications" class="settings-panel">
                        <div class="panel-header" style="padding: 40px 40px 20px 40px;">
                            <h3>Notification Preferences</h3>
                            <p>Choose what we get in touch with you about.</p>
                        </div>
                        <div class="panel-body">
                            <div class="section-title" style="border:none; padding:0; margin-bottom:10px;">Email Alerts</div>
                            
                            <div class="toggle-row">
                                <div class="toggle-text">
                                    <h4>New Quote Requests</h4>
                                    <p>Get notified immediately when a client submits a form.</p>
                                </div>
                                <label class="switch"><input type="checkbox" checked><span class="slider"></span></label>
                            </div>
                            
                            <div class="toggle-row">
                                <div class="toggle-text">
                                    <h4>Weekly Digest</h4>
                                    <p>A summary of your site's performance sent every Monday.</p>
                                </div>
                                <label class="switch"><input type="checkbox"><span class="slider"></span></label>
                            </div>

                            <div class="section-title" style="border:none; padding:0; margin:30px 0 10px;">System Alerts</div>
                            
                            <div class="toggle-row">
                                <div class="toggle-text">
                                    <h4>Maintenance Mode</h4>
                                    <p>Show a "Under Construction" page to visitors.</p>
                                </div>
                                <label class="switch"><input type="checkbox"><span class="slider"></span></label>
                            </div>
                        </div>
                    </div>

                    <!-- 4. SYSTEM PANEL -->
                    <div id="system" class="settings-panel">
                        <div class="panel-header" style="padding: 40px 40px 20px 40px;">
                            <h3>System Health</h3>
                            <p>Technical details and environment information.</p>
                        </div>
                        <div class="panel-body">
                            <div class="sys-grid">
                                <div class="sys-card">
                                    <span class="sys-label">Web Version</span>
                                    <div class="sys-value"><?php echo $app_version; ?></div>
                                </div>
                                <div class="sys-card">
                                    <span class="sys-label">PHP Version</span>
                                    <div class="sys-value"><?php echo phpversion(); ?></div>
                                </div>
                                <div class="sys-card">
                                    <span class="sys-label">Server Status</span>
                                    <div class="sys-value"><span class="status-dot"></span> Online</div>
                                </div>
                                <div class="sys-card">
                                    <span class="sys-label">Database</span>
                                    <div class="sys-value"><span class="status-dot"></span> Connected</div>
                                </div>
                                <div class="sys-card" style="grid-column: span 2;">
                                    <span class="sys-label">Admin Access IP</span>
                                    <div class="sys-value"><?php echo $_SERVER['REMOTE_ADDR']; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div id="toastContainer" class="toast-container"></div>

    <script>
        // Tab Switching
        function openTab(evt, tabName) {
            const panels = document.getElementsByClassName("settings-panel");
            const tabs = document.getElementsByClassName("settings-tab");
            
            for (let i = 0; i < panels.length; i++) {
                panels[i].style.display = "none";
                panels[i].classList.remove("active");
            }
            for (let i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove("active");
            }
            
            document.getElementById(tabName).style.display = "block";
            setTimeout(() => document.getElementById(tabName).classList.add("active"), 10); // Tiny delay for anim
            evt.currentTarget.classList.add("active");
        }

        // Sidebar Mobile
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        if(window.innerWidth <= 768) menuToggle.style.display = 'block';
        menuToggle.addEventListener('click', () => sidebar.classList.toggle('active'));

        // Theme Logic
        const themeToggle = document.getElementById("themeToggle");
        const body = document.body;
        if (localStorage.getItem("theme") === "dark") { body.classList.add("dark"); themeToggle.checked = true; }
        themeToggle.addEventListener("change", () => {
            if (themeToggle.checked) { body.classList.add("dark"); localStorage.setItem("theme", "dark"); }
            else { body.classList.remove("dark"); localStorage.setItem("theme", "light"); }
        });

        // Toast
        function showToast(msg, type) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'toast';
            const icon = type === 'success' ? '<i class="fas fa-check-circle" style="color:var(--success); font-size:18px;"></i>' : '<i class="fas fa-exclamation-circle" style="color:var(--danger); font-size:18px;"></i>';
            toast.innerHTML = `${icon} <span style="font-weight:600;">${msg}</span>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        <?php if (!empty($message)): ?>
            showToast("<?php echo $message; ?>", "<?php echo $msg_type; ?>");
        <?php endif; ?>
    </script>
</body>
</html>