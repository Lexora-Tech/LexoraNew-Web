<?php
include("../includes/auth.php");
include("../includes/db.php");

$result = mysqli_query($conn, "SELECT * FROM blogs ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body>
    <h2>Welcome, <?php echo $_SESSION['admin']; ?>!</h2>
    <a href="add_blog.php">Add Blog</a> | <a href="logout.php">Logout</a>
    <hr>
    <h3>All Blogs</h3>
    <table border="1" cellpadding="10">
        <tr><th>ID</th><th>Title</th><th>Cover</th><th>Date</th><th>Actions</th></tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['title']; ?></td>
            <td><img src="../uploads/<?= $row['cover_image']; ?>" width="80"></td>
            <td><?= $row['created_at']; ?></td>
            <td>
                <a href="edit_blog.php?id=<?= $row['id']; ?>">Edit</a> | 
                <a href="delete_blog.php?id=<?= $row['id']; ?>" onclick="return confirm('Delete this blog?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
