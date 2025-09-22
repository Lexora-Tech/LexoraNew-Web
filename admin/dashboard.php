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
        /* Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            padding: 2rem;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        header h2 {
            color: #1e3a8a;
        }
        .nav-links a {
            margin-left: 1rem;
            text-decoration: none;
            background: #2563eb;
            color: #fff;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 14px;
            transition: background 0.3s;
        }
        .nav-links a:hover {
            background: #1d4ed8;
        }

        h3 {
            margin-bottom: 1rem;
            color: #334155;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        thead {
            background: #1e3a8a;
            color: #fff;
        }
        thead th {
            padding: 14px;
            font-size: 14px;
            text-align: left;
        }
        tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
            vertical-align: middle;
        }
        tbody tr:hover {
            background: #f8fafc;
        }

        img {
            border-radius: 6px;
        }

        .actions a {
            text-decoration: none;
            margin-right: 8px;
            font-size: 13px;
            padding: 6px 10px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .actions a:first-child {
            background: #10b981;
            color: #fff;
        }
        .actions a:first-child:hover {
            background: #059669;
        }
        .actions a:last-child {
            background: #ef4444;
            color: #fff;
        }
        .actions a:last-child:hover {
            background: #dc2626;
        }
    </style>
</head>
<body>
    <header>
        <h2>Welcome, <?php echo $_SESSION['admin']; ?>!</h2>
        <div class="nav-links">
            <a href="add_blog.php">+ Add Blog</a>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <h3>All Blogs</h3>
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
                <td><img src="../uploads/<?= $row['cover_image']; ?>" width="80"></td>
                <td><?= $row['created_at']; ?></td>
                <td class="actions">
                    <a href="edit_blog.php?id=<?= $row['id']; ?>">Edit</a>
                    <a href="delete_blog.php?id=<?= $row['id']; ?>" onclick="return confirm('Delete this blog?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
