<?php
include("includes/db.php");
$result = mysqli_query($conn, "SELECT * FROM blogs ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head><title>My Blog</title></head>
<body>
  <h1>My Blog</h1>
  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <div>
      <h2><a href="blog2.php?id=<?= $row['id']; ?>"><?= $row['title']; ?></a></h2>
      <img src="uploads/<?= $row['cover_image']; ?>" width="300"><br>
      <p><?= $row['description']; ?></p>
      <small>Posted on <?= $row['created_at']; ?></small>
    </div>
    <hr>
  <?php } ?>
</body>
</html>