<?php
include("includes/db.php");
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM blogs WHERE id=$id");
$blog = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head><title><?= $blog['title']; ?></title></head>
<body>
  <h1><?= $blog['title']; ?></h1>
  <img src="uploads/<?= $blog['cover_image']; ?>" width="400"><br><br>
  <p><?= nl2br($blog['description']); ?></p>
  <br>
  <img src="uploads/<?= $blog['image1']; ?>" width="300"><br><br>
  <img src="uploads/<?= $blog['image2']; ?>" width="300"><br><br>
  <small>Posted on <?= $blog['created_at']; ?></small>
  <br><br>
  <a href="index.php">← Back</a>
</body>
</html>