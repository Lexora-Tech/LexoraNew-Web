<?php
include("../includes/auth.php");
include("../includes/db.php");

// 1. Handle Search Logic
$search_term = "";

// UPDATE: Added LIMIT 12 to show only recent posts by default
$sql = "SELECT * FROM blogs ORDER BY created_at DESC LIMIT 12"; 

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);
    // Search results show ALL matches (not limited) so you can find old posts
    $sql = "SELECT * FROM blogs WHERE title LIKE '%$search_term%' OR heading LIKE '%$search_term%' ORDER BY created_at DESC";
}

$result = mysqli_query($conn, $sql);

// 2. Fetch Global Stats (Constant, not affected by search)
// Total Blogs Count
$count_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM blogs");
$count_data = mysqli_fetch_assoc($count_query);
$total_blogs_stat = $count_data['count'];

// Total Views Count
$view_query = mysqli_query($conn, "SELECT SUM(views) as total_views FROM blogs");
$view_data = mysqli_fetch_assoc($view_query);
$real_total_views = $view_data['total_views'] ? $view_data['total_views'] : 0;

// Helper to format numbers
function format_number($n) {
    if ($n < 1000) return $n;
    $suffix = ['','k','M','G','T'];
    $power = floor(log($n, 1000));
    return round($n / (1000 ** $power), 1) . $suffix[$power];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Lexora Tech</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/logo/logo.png" />
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- VARIABLES & RESET --- */
        :root {
            --primary: #ffb400; /* Lexora Gold */
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

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        
        body { background: var(--bg-body); color: var(--text-main); transition: 0.3s ease; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }

        /* --- LAYOUT STRUCTURE --- */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR --- */
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
            border-right: 1px solid rgba(255,255,255,0.05);
            transition: 0.3s ease;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
            padding: 0 10px;
        }

        .brand img { height: 32px; width: auto; }
        .brand span { font-size: 18px; font-weight: 700; color: #fff; letter-spacing: 0.5px; }

        .menu-label { font-size: 12px; text-transform: uppercase; color: #666; margin-bottom: 10px; padding-left: 10px; font-weight: 600; letter-spacing: 1px; }

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

        .nav-item:hover, .nav-item.active {
            background: rgba(255, 180, 0, 0.1);
            color: var(--primary);
        }

        .nav-item i { width: 20px; text-align: center; font-size: 16px; }

        .sidebar-footer { margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); }

        /* --- MAIN CONTENT AREA --- */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
        }

        /* --- HEADER --- */
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

        .header-left h2 { font-size: 20px; font-weight: 600; }
        .date-display { font-size: 13px; color: var(--text-muted); }

        /* Updated Search Box to Form */
        .search-box {
            background: var(--bg-body);
            padding: 8px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--border);
            width: 300px;
        }
        .search-button { background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 0; font-size: 14px; }
        .search-box input { border: none; background: transparent; outline: none; color: var(--text-main); width: 100%; }
        .search-box:focus-within { border-color: var(--primary); }

        .header-right { display: flex; align-items: center; gap: 20px; }

        .user-profile { display: flex; align-items: center; gap: 10px; cursor: pointer; }
        .avatar { width: 35px; height: 35px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #000; font-weight: bold; }
        .user-info { display: flex; flex-direction: column; line-height: 1.2; }
        .user-name { font-size: 14px; font-weight: 600; }
        .user-role { font-size: 11px; color: var(--text-muted); }

        /* --- DASHBOARD WIDGETS --- */
        .content-wrapper { padding: 30px; }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--bg-card);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: 0.3s;
        }
        
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); border-color: var(--primary); }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-icon.blue { background: rgba(37, 99, 235, 0.1); color: #2563eb; }
        .stat-icon.green { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        .stat-icon.gold { background: rgba(255, 180, 0, 0.1); color: #ffb400; }

        .stat-info h4 { font-size: 24px; font-weight: 700; margin-bottom: 2px; }
        .stat-info p { font-size: 13px; color: var(--text-muted); }

        /* --- BLOG GRID --- */
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-add { background: var(--primary); color: #000; padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 14px; transition: 0.3s; display: flex; align-items: center; gap: 8px; }
        .btn-add:hover { background: var(--primary-hover); transform: translateY(-2px); }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
        }

        .blog-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            transition: 0.3s;
            position: relative;
        }

        .blog-card:hover {
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
            transform: translateY(-5px);
        }

        .card-image-wrapper { position: relative; height: 180px; overflow: hidden; }
        .card-cover { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
        .blog-card:hover .card-cover { transform: scale(1.05); }
        
        .card-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(0,0,0,0.7);
            color: #fff;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            backdrop-filter: blur(4px);
        }

        .card-body { padding: 20px; }
        .blog-date { font-size: 12px; color: var(--text-muted); margin-bottom: 8px; display: block; }
        .blog-title { font-size: 18px; font-weight: 700; margin-bottom: 10px; color: var(--text-main); line-height: 1.4; }
        .blog-brief { font-size: 14px; color: var(--text-muted); line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 20px; }

        .card-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0,0,0,0.02);
        }

        .actions { display: flex; gap: 10px; }
        .btn-icon { width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border); color: var(--text-muted); transition: 0.3s; cursor: pointer; background: var(--bg-card); }
        .btn-icon:hover { color: var(--primary); border-color: var(--primary); }
        .btn-icon.delete:hover { color: var(--danger); border-color: var(--danger); }

        /* --- THEME TOGGLE --- */
        .theme-switch { position: relative; width: 40px; height: 20px; cursor: pointer; }
        .theme-switch input { display: none; }
        .slider { position: absolute; inset: 0; background: #ccc; border-radius: 20px; transition: .4s; }
        .slider:before { content: ""; position: absolute; height: 16px; width: 16px; left: 2px; bottom: 2px; background: white; border-radius: 50%; transition: .4s; }
        input:checked + .slider { background: var(--primary); }
        input:checked + .slider:before { transform: translateX(20px); }

        /* --- MODAL & TOAST --- */
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1000; justify-content: center; align-items: center; backdrop-filter: blur(5px); }
        .modal-content { background: var(--bg-card); padding: 30px; border-radius: 16px; width: 90%; max-width: 400px; text-align: center; border: 1px solid var(--border); }
        .modal-btns { margin-top: 20px; display: flex; justify-content: center; gap: 15px; }
        .btn-modal { padding: 10px 25px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; }
        .btn-yes { background: var(--danger); color: #fff; }
        .btn-no { background: var(--border); color: var(--text-main); }
        
        .toast-container { position: fixed; bottom: 30px; right: 30px; z-index: 2000; display: flex; flex-direction: column; gap: 10px; }
        .toast { background: #333; color: #fff; padding: 15px 20px; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); display: flex; align-items: center; gap: 10px; animation: slideIn 0.3s ease; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); position: fixed; }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .search-box { display: none; }
            .menu-toggle { display: block; font-size: 24px; cursor: pointer; margin-right: 15px; }
        }
        @media (min-width: 769px) { .menu-toggle { display: none; } }
    </style>
</head>

<body>

    <div class="dashboard-container">
        
        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <img src="../img/logo/logo.jpg" alt="Logo">
                <span>Lexora Admin</span>
            </div>

            <div class="menu-label">Main Menu</div>
            <a href="#" class="nav-item active">
              <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
            <a href="all_blogs.php" class="nav-item">
                <i class="fas fa-layer-group"></i> <span>All Blogs</span>
            </a>
            <a href="add_blog.php" class="nav-item">
                <i class="fas fa-plus-circle"></i> <span>Add New</span>
            </a>

            <div class="menu-label" style="margin-top: 20px;">System</div>
            <a href="settings.php" class="nav-item">
                <i class="fas fa-cog"></i> <span>Settings</span>
            </a>
            <a href="quote_requests.php" class="nav-item">
                <i class="fas fa-envelope"></i> <span>Inquiries</span>
            </a>

            <div class="sidebar-footer">
                <a href="logout.php" class="nav-item" style="color: var(--danger);">
                    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                </a>
            </div>
        </aside>

        <div class="main-content">
            
            <header>
                <div class="header-left" style="display:flex; align-items:center;">
                    <i class="fas fa-bars menu-toggle" id="menuToggle"></i>
                    <div>
                        <h2>Dashboard</h2>
                        <span class="date-display"><?php echo date("l, F j, Y"); ?></span>
                    </div>
                </div>

                <div class="header-right">
                    
                    <!-- UPDATED SEARCH FORM -->
                    <form class="search-box" method="GET" action="">
                        <button type="submit" class="search-button"><i class="fas fa-search"></i></button>
                        <input type="text" name="search" placeholder="Search blogs..." value="<?= htmlspecialchars($search_term) ?>">
                    </form>
                    
                    <label class="theme-switch">
                        <input type="checkbox" id="themeToggle">
                        <span class="slider"></span>
                    </label>

                    <div class="user-profile">
                        <div class="user-info">
                            <span class="user-name"><?php echo $_SESSION['admin']; ?></span>
                            <span class="user-role">Administrator</span>
                        </div>
                        <div class="avatar">
                            <?php echo strtoupper(substr($_SESSION['admin'], 0, 1)); ?>
                        </div>
                    </div>
                </div>
            </header>

            <div class="content-wrapper">
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon gold">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="stat-info">
                            <h4><?php echo $total_blogs_stat; ?></h4>
                            <p>Total Blogs</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stat-info">
                            <h4><?php echo format_number($real_total_views); ?></h4>
                            <p>Total Views</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h4>Active</h4>
                            <p>System Status</p>
                        </div>
                    </div>
                </div>

                <div class="section-header">
                    <h3><?php echo empty($search_term) ? "Recent Publications" : "Search Results for '" . htmlspecialchars($search_term) . "'"; ?></h3>
                    <a href="add_blog.php" class="btn-add">
                        <i class="fas fa-plus"></i> Create Blog
                    </a>
                </div>

                <?php if(mysqli_num_rows($result) == 0): ?>
                    <div style="text-align:center; padding:40px; color:var(--text-muted);">
                        <i class="fas fa-folder-open" style="font-size:30px; margin-bottom:10px; display:block;"></i>
                        No blogs found.
                    </div>
                <?php else: ?>
                    <div class="card-grid">
                        <?php 
                        mysqli_data_seek($result, 0);
                        while ($row = mysqli_fetch_assoc($result)) { 
                        ?>
                            <div class="blog-card">
                                <div class="card-image-wrapper">
                                    <span class="card-badge">Published</span>
                                    <img src="../uploads/<?= htmlspecialchars($row['cover_image'], ENT_QUOTES) ?>" class="card-cover">
                                </div>
                                <div class="card-body">
                                    <span class="blog-date">
                                        <i class="far fa-calendar-alt"></i> <?= date("M d, Y", strtotime($row['created_at'])) ?>
                                        <span style="float:right; font-size:11px; opacity:0.7;">
                                            <i class="fas fa-eye"></i> <?= format_number($row['views']) ?>
                                        </span>
                                    </span>
                                    <h4 class="blog-title"><?= htmlspecialchars($row['title']) ?></h4>
                                    <p class="blog-brief"><?= htmlspecialchars($row['headingbrief']) ?></p>
                                </div>
                                <div class="card-footer">
                                    <div style="font-size:12px; color:var(--text-muted);">ID: #<?= $row['id'] ?></div>
                                    <div class="actions">
                                        <a href="edit_blog.php?id=<?= $row['id'] ?>" class="btn-icon" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <div class="btn-icon delete" title="Delete" data-id="<?= $row['id'] ?>">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                        <div class="btn-icon share-btn" title="Share" data-link="publication.php?id=<?= $row['id'] ?>">
                                            <i class="fas fa-share-alt"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <div id="toastContainer" class="toast-container"></div>

    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <i class="fas fa-exclamation-circle" style="font-size: 40px; color: var(--danger); margin-bottom: 15px;"></i>
            <h3 style="margin-bottom: 10px;">Delete Blog?</h3>
            <p style="color: var(--text-muted); margin-bottom: 20px;">This action cannot be undone. Are you sure?</p>
            <div class="modal-btns">
                <button class="btn-modal btn-no" id="confirmNo">Cancel</button>
                <button class="btn-modal btn-yes" id="confirmYes">Delete</button>
            </div>
        </div>
    </div>

    <script>
        // Sidebar Toggle for Mobile
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        
        if(menuToggle){
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
            });
        }

        // Theme Toggle Logic
        const themeToggle = document.getElementById("themeToggle");
        const body = document.body;
        
        // Check saved theme
        if (localStorage.getItem("theme") === "dark") {
            body.classList.add("dark");
            themeToggle.checked = true;
        }

        themeToggle.addEventListener("change", () => {
            if (themeToggle.checked) {
                body.classList.add("dark");
                localStorage.setItem("theme", "dark");
            } else {
                body.classList.remove("dark");
                localStorage.setItem("theme", "light");
            }
        });

        // Delete Modal Logic
        let deleteId = null;
        document.querySelectorAll('.delete').forEach(btn => {
            btn.addEventListener('click', () => {
                deleteId = btn.getAttribute('data-id');
                document.getElementById('deleteModal').style.display = 'flex';
            });
        });

        document.getElementById('confirmNo').addEventListener('click', () => {
            document.getElementById('deleteModal').style.display = 'none';
        });

        document.getElementById('confirmYes').addEventListener('click', () => {
            window.location.href = `delete_blog.php?id=${deleteId}`;
        });

        // Close modal on outside click
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Toast Logic (Simplified for the Professional Look)
        function showToast(message) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.innerHTML = `<i class="fas fa-info-circle"></i> ${message}`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Share Button Logic
        document.querySelectorAll('.share-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const link = window.location.origin + "/" + btn.getAttribute('data-link');
                navigator.clipboard.writeText(link).then(() => {
                    showToast("Link copied to clipboard!");
                });
            });
        });
    </script>
</body>
</html>