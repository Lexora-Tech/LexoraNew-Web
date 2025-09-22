<?php
include("../includes/db.php");
include("../includes/auth.php");

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $target_dir = "../uploads/";

    $cover_image = time() . "_cover_" . basename($_FILES["cover_image"]["name"]);
    $image1 = time() . "_img1_" . basename($_FILES["image1"]["name"]);
    $image2 = time() . "_img2_" . basename($_FILES["image2"]["name"]);

    move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_dir . $cover_image);
    move_uploaded_file($_FILES["image1"]["tmp_name"], $target_dir . $image1);
    move_uploaded_file($_FILES["image2"]["tmp_name"], $target_dir . $image2);

    $sql = "INSERT INTO blogs (title, description, cover_image, image1, image2) 
            VALUES ('$title', '$description', '$cover_image', '$image1', '$image2')";

    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php");
    } else {
        echo "DB Error: " . mysqli_error($conn);
    }
}
?>
