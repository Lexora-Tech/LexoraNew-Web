<?php include("../includes/auth.php"); ?>
<!DOCTYPE html>
<html>
<head><title>Add Blog</title></head>
<body>
  <h2>Add New Blog</h2>
  <form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Blog Title" required><br><br>
    <textarea name="description" placeholder="Blog Description" required></textarea><br><br>
    <label>Cover Image:</label><br>
    <input type="file" name="cover_image" accept="image/*" required><br><br>
    <label>Image 1:</label><br>
    <input type="file" name="image1" accept="image/*" required><br><br>
    <label>Image 2:</label><br>
    <input type="file" name="image2" accept="image/*" required><br><br>
    <button type="submit" name="submit">Upload</button>
  </form>
</body>
</html>
