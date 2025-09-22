<?php
include("../includes/auth.php");
include("../includes/db.php");

$result = mysqli_query($conn, "SELECT * FROM blogs ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: var(--bg);
    color: var(--text);
    padding: 0;
    transition: background 0.3s, color 0.3s;
}
:root {
    --bg: #f1f5f9;
    --card: #fff;
    --text: #1e293b;
    --primary: #2563eb;
    --primary-dark: #1d4ed8;
    --table-hover: #f8fafc;
    --border: #e2e8f0;
    --success: #10b981;
    --success-dark: #059669;
    --danger: #ef4444;
    --danger-dark: #dc2626;
}
body.dark {
    --bg: #0f172a;
    --card: #1e293b;
    --text: #f1f5f9;
    --primary: #3b82f6;
    --primary-dark: #2563eb;
    --table-hover: #1e293b;
    --border: #334155;
    --success: #22c55e;
    --success-dark: #16a34a;
    --danger: #f87171;
    --danger-dark: #ef4444;
}

header {
    position: sticky;
    top: 0;
    z-index: 50;
    background: var(--card);
    border-bottom: 1px solid var(--border);
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
header h2 { color: var(--primary); font-size: 20px; }

.nav-links {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn {
    text-decoration: none;
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    border: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-primary { background: var(--primary); color: #fff; }
.btn-primary:hover { background: var(--primary-dark); }
.btn-danger { background: var(--danger); color: #fff; }
.btn-danger:hover { background: var(--danger-dark); }

/* Toggle Switch */
.switch { position: relative; display: inline-block; width: 54px; height: 28px; }
.switch input { display: none; }
.slider {
    position: absolute; cursor: pointer; top: 0; left: 0;
    right: 0; bottom: 0; background-color: #ccc;
    transition: 0.4s; border-radius: 28px;
}
.slider:before {
    position: absolute;
    content: "☀️"; height: 24px; width: 24px;
    left: 2px; bottom: 2px;
    background-color: white;
    border-radius: 50%;
    transition: 0.4s;
    font-size: 14px;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}
input:checked + .slider { background-color: var(--primary); box-shadow: 0 0 12px var(--primary); }
input:checked + .slider:before { transform: translateX(26px); content: "🌙"; box-shadow: 0 0 12px var(--primary); }

main { padding: 2rem; }
h3 { margin-bottom: 1rem; color: var(--text); }

.table-container { width: 100%; overflow-x: auto; }
table {
    width: 100%; min-width: 800px;
    border-collapse: collapse;
    background: var(--card);
    border-radius: 12px; overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}
thead { background: var(--primary); color: #fff; }
thead th { padding: 14px; font-size: 14px; text-align: left; }
tbody td {
    padding: 12px 14px; border-bottom: 1px solid var(--border);
    font-size: 14px; vertical-align: middle;
    word-break: break-word; max-width: 200px; white-space: normal;
}
tbody tr:hover { background: var(--table-hover); }
img { border-radius: 6px; max-width: 80px; height: auto; }

.actions a { text-decoration: none; margin-right: 8px; font-size: 13px; padding: 6px 10px; border-radius: 5px; transition: 0.3s; }
.actions a:first-child { background: var(--success); color: #fff; }
.actions a:first-child:hover { background: var(--success-dark); }
.actions a:last-child { background: var(--danger); color: #fff; }
.actions a:last-child:hover { background: var(--danger-dark); }

/* Modal */
.modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; }
.modal-content { background: var(--card); padding: 2rem; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.2); text-align: center; max-width: 400px; }
.modal-content h3 { margin-bottom: 1rem; color: var(--danger); }
.modal-content button { padding: 10px 20px; border: none; border-radius: 8px; font-size: 14px; cursor: pointer; margin: 0 8px; }
.modal-content button:first-child { background: var(--danger); color: #fff; }
.modal-content button:last-child { background: var(--success); color: #fff; }

/* Mobile Responsiveness */
@media (max-width: 768px) {
    header { flex-direction: column; align-items: flex-start; padding: 1rem; }
    header h2 { font-size: 18px; }
    .nav-links { width: 100%; justify-content: space-between; }
    .btn { flex: 1; text-align: center; justify-content: center; font-size: 13px; padding: 8px 12px; }
    tbody td { max-width: 150px; font-size: 13px; }
}
@media (max-width: 480px) {
    header h2 { font-size: 16px; }
    .btn { font-size: 12px; padding: 6px 10px; }
    thead th, tbody td { font-size: 12px; padding: 8px; }
}
</style>
</head>
<body>
<header>
    <h2>Welcome, <?php echo $_SESSION['admin']; ?></h2>
    <div class="nav-links">
        <a href="add_blog.php" class="btn btn-primary">➕ Add Blog</a>
        <a href="logout.php" class="btn btn-danger">🚪 Logout</a>
        <label class="switch">
            <input type="checkbox" id="themeToggle" onchange="toggleTheme()">
            <span class="slider"></span>
        </label>
    </div>
</header>

<main>
    <h3>All Blogs</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Heading</th>
                    <th>Heading Brief</th>
                    <th>Para 1</th>
                    <th>Para 2</th>
                    <th>Conclusion</th>
                    <th>Cover</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['title']; ?></td>
                    <td><?= $row['heading']; ?></td>
                    <td><?= $row['headingbrief']; ?></td>
                    <td><?= $row['p1']; ?></td>
                    <td><?= $row['p2']; ?></td>
                    <td><?= $row['conclusion']; ?></td>
                    <td><img src="../uploads/<?= $row['cover_image']; ?>"></td>
                    <td><?= $row['created_at']; ?></td>
                    <td class="actions">
                        <a href="edit_blog.php?id=<?= $row['id']; ?>">Edit</a>
                        <a href="#" class="delete-btn" data-id="<?= $row['id']; ?>">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Delete Confirmation Modal -->
<div class="modal" id="confirmModal">
    <div class="modal-content">
        <h3>⚠️ Are you sure you want to delete this blog?</h3>
        <div>
            <button id="confirmYes">Yes</button>
            <button onclick="closeConfirmModal()">No</button>
        </div>
    </div>
</div>

<script>
function toggleTheme() {
    let checkbox = document.getElementById("themeToggle");
    document.body.classList.toggle("dark", checkbox.checked);
    localStorage.setItem("theme", checkbox.checked ? "dark" : "light");
}
window.onload = function() {
    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark");
        document.getElementById("themeToggle").checked = true;
    }
}

// Delete modal logic
let blogIdToDelete = null;
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        blogIdToDelete = this.getAttribute('data-id');
        document.getElementById('confirmModal').style.display = 'flex';
    });
});

function closeConfirmModal() {
    document.getElementById('confirmModal').style.display = 'none';
}

document.getElementById('confirmYes').addEventListener('click', function() {
    window.location.href = 'delete_blog.php?id=' + blogIdToDelete;
});
</script>
</body>
</html>
