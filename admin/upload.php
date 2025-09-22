<?php
include("../includes/db.php");
include("../includes/auth.php");

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $heading = $_POST['heading'];
    $headingbrief = $_POST['headingbrief'];
    $p1 = $_POST['p1'];
    $p2 = $_POST['p2'];
    $conclusion = $_POST['conclusion'];

    $target_dir = "../uploads/";

    $cover_image = time() . "_cover_" . basename($_FILES["cover_image"]["name"]);
    $image1 = (time()+1) . "_img1_" . basename($_FILES["image1"]["name"]);
    $image2 = (time()+2) . "_img2_" . basename($_FILES["image2"]["name"]);

    move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_dir . $cover_image);
    move_uploaded_file($_FILES["image1"]["tmp_name"], $target_dir . $image1);
    move_uploaded_file($_FILES["image2"]["tmp_name"], $target_dir . $image2);

    $sql = "INSERT INTO blogs (title, heading, headingbrief, p1, p2, conclusion, cover_image, image1, image2) 
            VALUES ('$title','$heading','$headingbrief', '$p1','$p2', '$conclusion','$cover_image', '$image1', '$image2')";

    if (mysqli_query($conn, $sql)) {
        // Redirect back to add_blog.php with success=1
        header("Location: add_blog.php?success=1");
        exit;
    } else {
        echo "DB Error: " . mysqli_error($conn);
    }
}
?>
