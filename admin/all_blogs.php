<?php
include("../includes/auth.php");
include("../includes/db.php");

// --- CONFIGURATION ---
$limit = 20; // Limit rows per page
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// --- SEARCH & FILTER LOGIC ---
$search_term = "";
$where_clause = "";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);
    // Search in Title or Heading
    $where_clause = "WHERE title LIKE '%$search_term%' OR heading LIKE '%$search_term%'";
}

// 1. Get Total Count (For Pagination Calculation)
// We need to know the total matching rows to calculate how many pages exist
$count_sql = "SELECT COUNT(*) as total FROM blogs $where_clause";
$count_query = mysqli_query($conn, $count_sql);
$count_data = mysqli_fetch_assoc($count_query);
$total_records = $count_data['total'];
$total_pages = ceil($total_records / $limit);

// 2. Fetch Data (With Limit & Offset)
// This query fetches only the 20 rows for the current page
$sql = "SELECT * FROM blogs $where_clause ORDER BY created_at DESC LIMIT $offset, $limit";
$result = mysqli_query($conn, $sql);
$count_current = mysqli_num_rows($result);

// Helper function to keep search params in pagination links
function get_page_link($p, $s) {
    $link = "?page=" . $p;
    if (!empty($s)) {
        $link .= "&search=" . urlencode($s);
    }
    return $link;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Blogs | Lexora Admin</title>
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
        body { background: var(--bg-body); color: var(--text-main); transition: 0.3s ease; }
        a { text-decoration: none; color: inherit; }
        
        /* --- LAYOUT --- */
        .dashboard-container { display: flex; min-height: 100vh; }
        
        .sidebar {
            width: var(--sidebar-width); background: var(--bg-sidebar); color: #fff; position: fixed; height: 100vh;
            left: 0; top: 0; z-index: 100; display: flex; flex-direction: column; padding: 20px;
            border-right: 1px solid rgba(255,255,255,0.05); transition: 0.3s ease;
        }
        .main-content { flex: 1; margin-left: var(--sidebar-width); display: flex; flex-direction: column; }
        
        .brand { display: flex; align-items: center; gap: 12px; margin-bottom: 40px; padding: 0 10px; }
        .brand img { height: 32px; width: auto; }
        .brand span { font-size: 18px; font-weight: 700; color: #fff; }
        .menu-label { font-size: 12px; text-transform: uppercase; color: #666; margin-bottom: 10px; padding-left: 10px; font-weight: 600; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 15px; border-radius: 8px; color: #a0a0a0; transition: 0.3s; margin-bottom: 5px; }
        .nav-item:hover, .nav-item.active { background: rgba(255, 180, 0, 0.1); color: var(--primary); }
        .nav-item i { width: 20px; text-align: center; font-size: 16px; }

        header {
            height: var(--header-height); background: var(--bg-card); border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between; padding: 0 30px; position: sticky; top: 0; z-index: 90;
        }
        .header-left h2 { font-size: 20px; font-weight: 600; }
        .user-profile { display: flex; align-items: center; gap: 10px; }
        .avatar { width: 35px; height: 35px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #000; font-weight: bold; }

        /* --- TABLE STYLES --- */
        .content-wrapper { padding: 30px; }

        .table-container {
            background: var(--bg-card); border-radius: 12px; border: 1px solid var(--border); overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.02);
        }

        .toolbar {
            padding: 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;
        }

        /* Search Form */
        .search-filter { position: relative; width: 300px; }
        .search-filter input {
            width: 100%; padding: 10px 10px 10px 40px; border-radius: 8px; border: 1px solid var(--border);
            background: var(--bg-body); color: var(--text-main); outline: none; transition: 0.3s;
        }
        .search-filter input:focus { border-color: var(--primary); }
        .search-button {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 0; font-size: 14px;
        }

        .btn-new {
            background: var(--primary); color: #000; padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 14px; display: flex; align-items: center; gap: 8px; transition: 0.3s;
        }
        .btn-new:hover { background: var(--primary-hover); transform: translateY(-2px); }

        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: rgba(0,0,0,0.02); }
        th { text-align: left; padding: 15px 20px; font-size: 12px; text-transform: uppercase; color: var(--text-muted); font-weight: 600; border-bottom: 1px solid var(--border); }
        td { padding: 15px 20px; border-bottom: 1px solid var(--border); vertical-align: middle; font-size: 14px; }
        tbody tr:hover { background: rgba(0,0,0,0.02); }
        tbody tr:last-child td { border-bottom: none; }

        .blog-info { display: flex; align-items: center; gap: 15px; }
        .blog-thumb { width: 50px; height: 50px; border-radius: 8px; object-fit: cover; background: #eee; }
        .blog-text { display: flex; flex-direction: column; }
        .blog-title-text { font-weight: 600; color: var(--text-main); margin-bottom: 2px; }
        .blog-id { font-size: 11px; color: var(--text-muted); }

        .status-badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; background: rgba(16, 185, 129, 0.1); color: var(--success); display: inline-block; }

        .action-btns { display: flex; gap: 8px; }
        
        .act-btn {
            width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border); color: var(--text-muted); transition: 0.2s; cursor: pointer; background: transparent; text-decoration: none;
        }
        .act-btn:hover { color: var(--primary); border-color: var(--primary); }

        /* Pagination Footer */
        .table-footer { padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border); color: var(--text-muted); font-size: 13px; }
        .pagination { display: flex; gap: 5px; }
        .page-link { 
            width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; 
            border: 1px solid var(--border); border-radius: 6px; cursor: pointer; text-decoration: none; color: var(--text-main);
            transition: 0.2s;
        }
        .page-link:hover { border-color: var(--primary); color: var(--primary); }
        .page-link.active { background: var(--primary); color: #000; border-color: var(--primary); font-weight: bold; }

        /* --- MODAL --- */
        .modal {
            display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.6); z-index: 2000; backdrop-filter: blur(4px); justify-content: center; align-items: center; animation: fadeIn 0.3s ease;
        }
        .modal-content {
            background: var(--bg-card); padding: 30px; border-radius: 16px; width: 90%; max-width: 400px; text-align: center; border: 1px solid var(--border); box-shadow: 0 20px 50px rgba(0,0,0,0.2); transform: translateY(20px); animation: slideUp 0.3s ease forwards;
        }
        .modal-icon {
            width: 60px; height: 60px; background: rgba(239, 68, 68, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: var(--danger); font-size: 24px;
        }
        .modal h3 { margin-bottom: 10px; color: var(--text-main); font-size: 20px; }
        .modal p { color: var(--text-muted); font-size: 14px; margin-bottom: 25px; line-height: 1.5; }
        .modal-actions { display: flex; gap: 15px; justify-content: center; }
        .btn-modal { padding: 12px 24px; border-radius: 8px; font-weight: 600; font-size: 14px; border: none; cursor: pointer; transition: 0.2s; }
        .btn-cancel { background: var(--bg-body); color: var(--text-main); border: 1px solid var(--border); }
        .btn-cancel:hover { background: var(--border); }
        .btn-confirm-delete { background: var(--danger); color: #fff; }
        .btn-confirm-delete:hover { background: #dc2626; }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        /* Toast */
        .toast-container { position: fixed; bottom: 30px; right: 30px; z-index: 3000; }
        .toast { background: #333; color: #fff; padding: 15px 20px; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); display: flex; align-items: center; gap: 10px; animation: slideIn 0.3s ease; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        /* Theme Toggle */
        .theme-switch { position: relative; width: 40px; height: 20px; cursor: pointer; }
        .theme-switch input { display: none; }
        .slider { position: absolute; inset: 0; background: #ccc; border-radius: 20px; transition: .4s; }
        .slider:before { content: ""; position: absolute; height: 16px; width: 16px; left: 2px; bottom: 2px; background: white; border-radius: 50%; transition: .4s; }
        input:checked + .slider { background: var(--primary); }
        input:checked + .slider:before { transform: translateX(20px); }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>

<body>

    <div class="dashboard-container">
        
        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <img src="../img/logo/logo.jpg" alt="Logo">
                <span>Lexora Admin</span>
            </div>

            <div class="menu-label">Main Menu</div>
            <a href="dashboard.php" class="nav-item">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
            <a href="#" class="nav-item active">
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
                    <i class="fas fa-bars" id="menuToggle" style="font-size:24px; cursor:pointer; margin-right:15px; display:none;"></i>
                    <h2>Blog Management</h2>
                </div>

                <div style="display: flex; align-items: center; gap: 20px;">
                    <label class="theme-switch">
                        <input type="checkbox" id="themeToggle">
                        <span class="slider"></span>
                    </label>
                    <div class="user-profile">
                        <div class="avatar"><?php echo strtoupper(substr($_SESSION['admin'], 0, 1)); ?></div>
                    </div>
                </div>
            </header>

            <div class="content-wrapper">
                
                <div class="table-container">
                    
                    <div class="toolbar">
                        <!-- SEARCH FORM -->
                        <form class="search-filter" method="GET" action="">
                            <button type="submit" class="search-button"><i class="fas fa-search"></i></button>
                            <input type="text" name="search" placeholder="Search blog titles..." value="<?= htmlspecialchars($search_term) ?>">
                        </form>
                        
                        <a href="add_blog.php" class="btn-new">
                            <i class="fas fa-plus"></i> Add New Blog
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Blog Details</th>
                                    <th>Status</th>
                                    <th>Date Published</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if ($count_current > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) { 
                                ?>
                                    <tr id="row-<?= $row['id'] ?>">
                                        <td>
                                            <div class="blog-info">
                                                <img src="../uploads/<?= htmlspecialchars($row['cover_image']) ?>" class="blog-thumb" alt="thumb">
                                                <div class="blog-text">
                                                    <span class="blog-title-text"><?= htmlspecialchars($row['title']) ?></span>
                                                    <span class="blog-id">ID: #<?= $row['id'] ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-badge">Published</span>
                                        </td>
                                        <td style="color: var(--text-muted);">
                                            <?= date("M d, Y", strtotime($row['created_at'])) ?>
                                        </td>
                                        <td>
                                            <div class="action-btns">
                                                <a href="edit_blog.php?id=<?= $row['id'] ?>" class="act-btn" title="Edit">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <!-- Delete Button -->
                                                <button type="button" class="act-btn delete-trigger" data-id="<?= $row['id'] ?>" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <a href="#" class="act-btn" title="View Live">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='4' style='text-align:center; padding: 40px; color:var(--text-muted);'>";
                                    if(!empty($search_term)) {
                                        echo "No blogs found matching '<b>" . htmlspecialchars($search_term) . "</b>'. <a href='all_blogs.php' style='color:var(--primary);'>View All</a>";
                                    } else {
                                        echo "No blogs found. <a href='add_blog.php' style='color:var(--primary); text-decoration:underline;'>Create one now.</a>";
                                    }
                                    echo "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- PAGINATION -->
                    <div class="table-footer">
                        <span>Showing <?= $count_current ?> of <?= $total_records ?> results</span>
                        <div class="pagination">
                            
                            <!-- Prev Link -->
                            <?php if($page > 1): ?>
                                <a href="<?= get_page_link($page-1, $search_term) ?>" class="page-link"><i class="fas fa-chevron-left"></i></a>
                            <?php endif; ?>

                            <!-- Page Numbers -->
                            <?php 
                            $start = max(1, $page - 2);
                            $end = min($total_pages, $page + 2);
                            
                            if ($start > 1) echo '<span class="page-link" style="border:none;">...</span>';
                            
                            for($i = $start; $i <= $end; $i++): 
                            ?>
                                <a href="<?= get_page_link($i, $search_term) ?>" class="page-link <?= $i==$page ? 'active' : '' ?>"><?= $i ?></a>
                            <?php endfor; 
                            
                            if ($end < $total_pages) echo '<span class="page-link" style="border:none;">...</span>';
                            ?>

                            <!-- Next Link -->
                            <?php if($page < $total_pages): ?>
                                <a href="<?= get_page_link($page+1, $search_term) ?>" class="page-link"><i class="fas fa-chevron-right"></i></a>
                            <?php endif; ?>
                            
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <div class="modal-icon">
                <i class="fas fa-trash-alt"></i>
            </div>
            <h3>Delete This Blog?</h3>
            <p>This action will permanently remove this blog post from your website. This cannot be undone.</p>
            <div class="modal-actions">
                <button class="btn-modal btn-cancel" id="cancelDelete">Cancel</button>
                <button class="btn-modal btn-confirm-delete" id="confirmDelete">Yes, Delete</button>
            </div>
        </div>
    </div>

    <div id="toastContainer" class="toast-container"></div>

    <script>
        // --- DELETE LOGIC ---
        let deleteId = null;
        const deleteModal = document.getElementById('deleteModal');
        const confirmBtn = document.getElementById('confirmDelete');
        const cancelBtn = document.getElementById('cancelDelete');

        document.querySelectorAll('.delete-trigger').forEach(button => {
            button.addEventListener('click', function() {
                deleteId = this.getAttribute('data-id');
                deleteModal.style.display = 'flex';
            });
        });

        cancelBtn.addEventListener('click', () => {
            deleteModal.style.display = 'none';
            deleteId = null;
        });

        confirmBtn.addEventListener('click', () => {
            if (deleteId) {
                fetch(`delete_blog.php?id=${deleteId}`)
                    .then(response => {
                        deleteModal.style.display = 'none';
                        const row = document.getElementById(`row-${deleteId}`);
                        if(row) {
                            row.style.opacity = '0';
                            setTimeout(() => row.remove(), 300);
                        }
                        showToast("Blog deleted successfully");
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast("Error deleting blog");
                    });
            }
        });

        function showToast(msg) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.innerHTML = `<i class="fas fa-check-circle" style="color:var(--success)"></i> <span>${msg}</span>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        window.onclick = function(event) {
            if (event.target == deleteModal) {
                deleteModal.style.display = "none";
            }
        }

        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        if (window.innerWidth <= 768) { menuToggle.style.display = 'block'; }
        menuToggle.addEventListener('click', () => { sidebar.classList.toggle('active'); });

        const themeToggle = document.getElementById("themeToggle");
        const body = document.body;
        if (localStorage.getItem("theme") === "dark") { body.classList.add("dark"); themeToggle.checked = true; }
        themeToggle.addEventListener("change", () => {
            if (themeToggle.checked) { body.classList.add("dark"); localStorage.setItem("theme", "dark"); }
            else { body.classList.remove("dark"); localStorage.setItem("theme", "light"); }
        });
    </script>
</body>
</html>