<?php
include("../includes/auth.php");
include("../includes/db.php");

$result = mysqli_query($conn, "SELECT * FROM blogs ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>LexoraTech | Admin Dashboard</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/logo/logo.png" />
    <style>
        /* --- common styles --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text);
            transition: 0.3s
        }

        :root {
            --bg: #f1f5f9;
            --card: #fff;
            --text: #1e293b;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --border: #e2e8f0;
            --success: #10b981;
            --danger: #ef4444
        }

        body.dark {
            --bg: #0f172a;
            --card: #1e293b;
            --text: #f1f5f9;
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --border: #334155;
            --success: #22c55e;
            --danger: #f87171
        }

        header {
            padding: 1rem 2rem;
            background: var(--card);
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05)
        }

        header h2 {
            color: var(--primary)
        }

        .nav-links {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center
        }

        .btn {
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px
        }

        .btn-primary {
            background: var(--primary);
            color: #fff
        }

        .btn-danger {
            background: var(--danger);
            color: #fff
        }

        main {
            padding: 2rem
        }

        h3 {
            margin-bottom: 1rem
        }

        /* Toggle Switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 54px;
            height: 28px
        }

        .switch input {
            display: none
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 28px
        }

        .slider:before {
            position: absolute;
            content: "☀️";
            height: 24px;
            width: 24px;
            left: 2px;
            bottom: 2px;
            background: white;
            border-radius: 50%;
            transition: .4s;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .2)
        }

        input:checked+.slider {
            background-color: var(--primary);
            box-shadow: 0 0 8px var(--primary)
        }

        input:checked+.slider:before {
            transform: translateX(26px);
            content: "🌙"
        }

        /* Desktop Table */
        .table-desktop {
            width: 100%;
            overflow-x: auto
        }

        .table-desktop table {
            width: 100%;
            border-collapse: collapse;
            background: var(--card);
            border-radius: 8px;
            overflow: hidden
        }

        .table-desktop thead {
            background: var(--primary);
            color: #fff
        }

        .table-desktop th,
        .table-desktop td {
            padding: 10px;
            border-bottom: 1px solid var(--border);
            text-align: left
        }

        .table-desktop tbody tr:hover {
            background: rgba(0, 0, 0, 0.03)
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .actions a {
            flex: 1;
            min-width: 70px;
            text-align: center;
            padding: 8px 0;
            border-radius: 4px;
            font-size: 13px;
            color: #fff;
            text-decoration: none;
            display: inline-block;
            transition: 0.2s;
        }

        /* Edit button */
        .actions a.edit-btn {
            background: var(--success);
        }

        .actions a.edit-btn:hover {
            background: #059669;
        }

        /* Delete button */
        .actions a.delete-btn {
            background: var(--danger);
        }

        .actions a.delete-btn:hover {
            background: #dc2626;
        }

        /* Share button */
        .actions a.share-btn {
            background: var(--primary);
        }

        .actions a.share-btn:hover {
            background: var(--primary-dark);
        }

        /* Mobile Cards */
        .table-mobile {
            display: none
        }

        .card {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px;
            background: var(--card);
            margin-bottom: 12px;
            cursor: pointer
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .card-header strong {
            color: var(--primary)
        }

        .card-details {
            margin-top: 8px;
            display: none;
            font-size: 14px
        }

        .card.expanded .card-details {
            display: block
        }

        .card .actions {
            margin-top: 8px
        }

        /* Delete Confirmation Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000
        }

        .modal-content {
            background: var(--card);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            max-width: 350px
        }

        .modal-content h3 {
            margin-bottom: 15px;
            color: var(--danger)
        }

        .modal-content button {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            margin: 0 8px
        }

        .modal-content .yes {
            background: var(--danger);
            color: #fff
        }

        .modal-content .no {
            background: var(--success);
            color: #fff
        }

        /* Responsive Switch */
        @media(max-width:768px) {
            .table-desktop {
                display: none
            }

            .table-mobile {
                display: block
            }
        }

        /* Toast Styles */
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column-reverse;
            gap: 10px;
            z-index: 2000;
        }

        .toast {
            padding: 12px 16px 16px;
            border-radius: 8px;
            font-size: 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-width: 240px;
            opacity: 0;
            transform: translateY(20px);
            animation: slideIn 0.3s forwards;
            color: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .toast.info {
            background: #2563eb;
        }

        .toast.success {
            background: #16a34a;
        }

        .toast.error {
            background: #dc2626;
        }

        .toast-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .toast-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .toast-icon {
            font-size: 18px;
        }

        .toast-close {
            background: none;
            border: none;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .toast-progress {
            height: 3px;
            width: 100%;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 2px;
            overflow: hidden;
        }

        .toast-progress-bar {
            height: 100%;
            background: #fff;
            width: 100%;
            transform-origin: left;
            animation: shrink linear forwards;
            animation-play-state: running;
        }

        .toast:hover .toast-progress-bar {
            animation-play-state: paused;
        }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        @keyframes shrink {
            from {
                transform: scaleX(1);
            }

            to {
                transform: scaleX(0);
            }
        }

        .fade-out {
            animation: fadeOut 0.4s forwards;
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
                <input type="checkbox" id="themeToggle">
                <span class="slider"></span>
            </label>
        </div>
    </header>

    <main>
        <h3>All Blogs</h3>

        <!-- Desktop Table -->
        <div class="table-desktop">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Heading</th>
                        <th>Heading Brief</th>
                        <th>Paragraph One</th>
                        <th>Paragraph Two</th>
                        <th>Conclusion</th>
                        <th>Cover</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['title'] ?></td>
                            <td><?= $row['heading'] ?></td>
                            <td><?= $row['headingbrief'] ?></td>
                            <td><?= $row['p1'] ?></td>
                            <td><?= $row['p2'] ?></td>
                            <td><?= $row['conclusion'] ?></td>
                            <td><img src="../uploads/<?= $row['cover_image'] ?>" width="80"></td>
                            <td><?= date("M d, Y", strtotime($row['created_at'])) ?></td>
                            <td class="actions">
                                <a href="edit_blog.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                                <a href="#" class="delete-btn" data-id="<?= $row['id'] ?>">Delete</a>
                                <a class="share-btn" href="#" data-link="publication.php?id=<?= $row['id'] ?>">Share</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="table-mobile">
            <?php mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="card">
                    <div class="card-header">
                        <strong><?= $row['title'] ?></strong>
                        <small><?= date("M d, Y", strtotime($row['created_at'])) ?></small>
                    </div>
                    <div class="card-details">
                        <p><b>ID:</b> <?= $row['id'] ?></p>
                        <p><b>Heading:</b> <?= $row['heading'] ?></p>
                        <p><b>Brief:</b> <?= $row['headingbrief'] ?></p>
                        <p><b>P1:</b> <?= $row['p1'] ?></p>
                        <p><b>P2:</b> <?= $row['p2'] ?></p>
                        <p><b>Conclusion:</b> <?= $row['conclusion'] ?></p>
                        <img src="../uploads/<?= $row['cover_image'] ?>" width="100">
                        <div class="actions">
                            <a href="edit_blog.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                            <a href="#" class="delete-btn" data-id="<?= $row['id'] ?>">Delete</a>
                            <a class="share-btn" href="#" data-link="publication.php?id=<?= $row['id'] ?>">Share</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>


    <!-- Toast Container -->
    <div id="toastContainer" class="toast-container"></div>

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <h3>Are You Sure You Want To Delete This Blog?</h3>
            <div>
                <button class="yes" id="confirmYes">Yes</button>
                <button class="no" id="confirmNo">No</button>
            </div>
        </div>
    </div>

    <script>
        // Expand cards on mobile
        document.querySelectorAll('.card').forEach(c => {
            c.addEventListener('click', e => {
                if (e.target.closest('.actions')) return;
                c.classList.toggle('expanded');
            })
        });

        // Theme toggle
        const toggle = document.getElementById("themeToggle");
        if (localStorage.getItem("theme") === "dark") {
            document.body.classList.add("dark");
            toggle.checked = true;
        }
        toggle.addEventListener("change", () => {
            if (toggle.checked) {
                document.body.classList.add("dark");
                localStorage.setItem("theme", "dark");
            } else {
                document.body.classList.remove("dark");
                localStorage.setItem("theme", "light");
            }
        });

        // Delete confirmation modal
        let blogIdToDelete = null;
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                blogIdToDelete = btn.getAttribute('data-id');
                document.getElementById('deleteModal').style.display = 'flex';
            });
        });
        document.getElementById('confirmNo').onclick = () => {
            document.getElementById('deleteModal').style.display = 'none';
        };
        document.getElementById('confirmYes').onclick = () => {
            window.location.href = 'delete_blog.php?id=' + blogIdToDelete;
        };

        const toastIcons = {
            success: "✅",
            error: "❌",
            info: "🔗"
        };
        const TOAST_DURATION = 3000;

        function showToast(message, type = "info") {
            const container = document.getElementById("toastContainer");
            const toast = document.createElement("div");
            toast.className = `toast ${type}`;
            toast.innerHTML = `
                <div class="toast-content">
                  <div class="toast-left">
                    <span class="toast-icon">${toastIcons[type]}</span>
                    <span>${message}</span>
                  </div>
                  <button class="toast-close">&times;</button>
                </div>
                <div class="toast-progress">
                  <div class="toast-progress-bar" style="animation-duration:${TOAST_DURATION}ms"></div>
                </div>
            `;
            container.appendChild(toast);

            let autoRemove = setTimeout(() => fadeOutToast(toast), TOAST_DURATION);

            toast.addEventListener("mouseenter", () => clearTimeout(autoRemove));
            toast.addEventListener("mouseleave", () => {
                autoRemove = setTimeout(() => fadeOutToast(toast), getRemainingTime(toast));
            });

            toast.querySelector(".toast-close").addEventListener("click", () => {
                clearTimeout(autoRemove);
                fadeOutToast(toast);
            });
        }

        function fadeOutToast(toast) {
            toast.classList.add("fade-out");
            toast.addEventListener("animationend", () => toast.remove());
        }

        function getRemainingTime(toast) {
            const bar = toast.querySelector(".toast-progress-bar");
            const computed = getComputedStyle(bar);
            const width = parseFloat(computed.width);
            const totalWidth = parseFloat(getComputedStyle(toast.querySelector(".toast-progress")).width);
            return (width / totalWidth) * TOAST_DURATION;
        }

        // Share link copy with toast
        document.querySelectorAll('.share-btn').forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                const link = btn.getAttribute('data-link');
                navigator.clipboard.writeText(window.location.origin + "/" + link)
                    .then(() => showToast("Link Copied To Clipboard!", "info"))
                    .catch(() => showToast("Failed To Copy Link!", "error"));
            });
        });
    </script>
</body>

</html>