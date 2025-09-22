<?php
include("../includes/auth.php");
include("../includes/db.php");

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM blogs WHERE id=$id");
$blog = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $heading = $_POST['heading'];
    $headingbrief = $_POST['headingbrief'];
    $p1 = $_POST['p1'];
    $p2 = $_POST['p2'];
    $conclusion = $_POST['conclusion'];

    // Start building SQL
    $fields = "title='$title', heading='$heading', headingbrief='$headingbrief', p1='$p1', p2='$p2', conclusion='$conclusion'";

    // Handle cover image
    if (!empty($_FILES['cover_image']['name'])) {
        $cover = time() . "_cover_" . basename($_FILES["cover_image"]["name"]);
        if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], "../uploads/" . $cover)) {
            $fields .= ", cover_image='$cover'";
        } else {
            echo "Failed to upload cover image";
        }
    }

    // Handle image1
    if (!empty($_FILES['image1']['name'])) {
        $img1 = (time()+1) . "_img1_" . basename($_FILES["image1"]["name"]);
        if (move_uploaded_file($_FILES["image1"]["tmp_name"], "../uploads/" . $img1)) {
            $fields .= ", image1='$img1'";
        } else {
            echo "Failed to upload image1";
        }
    }

    // Handle image2
    if (!empty($_FILES['image2']['name'])) {
        $img2 = (time()+2) . "_img2_" . basename($_FILES["image2"]["name"]);
        if (move_uploaded_file($_FILES["image2"]["tmp_name"], "../uploads/" . $img2)) {
            $fields .= ", image2='$img2'";
        } else {
            echo "Failed to upload image2";
        }
    }

    // Execute the update
    $update_sql = "UPDATE blogs SET $fields WHERE id=$id";
    if (mysqli_query($conn, $update_sql)) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error updating blog: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Blog</title>
</head>

<body>
    <h2>Edit Blog</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Title:</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($blog['title']); ?>" required><br><br>

        <label>Heading:</label><br>
        <input type="text" name="heading" value="<?= htmlspecialchars($blog['heading']); ?>" required><br><br>

        <label>Heading Brief:</label><br>
        <textarea name="headingbrief" required><?= htmlspecialchars($blog['headingbrief']); ?></textarea><br><br>

        <label>Paragraph 1:</label><br>
        <textarea name="p1" required><?= htmlspecialchars($blog['p1']); ?></textarea><br><br>

        <label>Paragraph 2:</label><br>
        <textarea name="p2" required><?= htmlspecialchars($blog['p2']); ?></textarea><br><br>

        <label>Conclusion:</label><br>
        <textarea name="conclusion" required><?= htmlspecialchars($blog['conclusion']); ?></textarea><br><br>

        <label>Cover Image:</label><br>
        <img src="../uploads/<?= $blog['cover_image']; ?>" width="120"><br>
        <input type="file" name="cover_image"><br><br>

        <label>Image 1:</label><br>
        <img src="../uploads/<?= $blog['image1']; ?>" width="120"><br>
        <input type="file" name="image1"><br><br>

        <label>Image 2:</label><br>
        <img src="../uploads/<?= $blog['image2']; ?>" width="120"><br>
        <input type="file" name="image2"><br><br>

        <button type="submit">Update</button>
    </form>
</body>

</html>