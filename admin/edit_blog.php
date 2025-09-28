<?php
include("../includes/auth.php");
include("../includes/db.php");

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM blogs WHERE id=$id");
$blog = mysqli_fetch_assoc($result);

$success = false;

function convertToWebP($sourcePath, $destPath, $quality = 80) {
    $info = getimagesize($sourcePath);
    $mime = $info['mime'];

    switch ($mime) {
        case 'image/jpeg': $image = imagecreatefromjpeg($sourcePath); break;
        case 'image/png': 
            $image = imagecreatefrompng($sourcePath);
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
            break;
        case 'image/gif': $image = imagecreatefromgif($sourcePath); break;
        default: return false;
    }

    imagewebp($image, $destPath, $quality);
    imagedestroy($image);
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $heading = $_POST['heading'];
    $headingbrief = $_POST['headingbrief'];
    $p1 = $_POST['p1'];
    $p2 = $_POST['p2'];
    $conclusion = $_POST['conclusion'];

    $fields = "title='$title', heading='$heading', headingbrief='$headingbrief', p1='$p1', p2='$p2', conclusion='$conclusion'";
    $uploadDir = "../uploads/";

    $images = ['cover_image','image1','image2'];
    foreach ($images as $imgField) {
        if (!empty($_FILES[$imgField]['name'])) {
            $tmp = $_FILES[$imgField]['tmp_name'];
            $name = time().'_'.$imgField.'.webp';
            if (convertToWebP($tmp, $uploadDir.$name)) {
                $fields .= ", $imgField='$name'";
            }
        }
    }

    $update_sql = "UPDATE blogs SET $fields WHERE id=$id";
    if (mysqli_query($conn, $update_sql)) {
        $success = true;
        $result = mysqli_query($conn, "SELECT * FROM blogs WHERE id=$id");
        $blog = mysqli_fetch_assoc($result);
    } else {
        echo "Error updating blog: ".mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>LexoraTech | Admin Edit Blog</title>
<link rel="shortcut icon" type="image/x-icon" href="../img/logo/logo.png" />
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: var(--bg);
        color: var(--text);
        margin: 0;
        padding: 2rem;
        transition: background 0.4s, color 0.4s;
    }
    :root {
        --bg: #f1f5f9;
        --card: #fff;
        --text: #1e293b;
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --border: #e2e8f0;
        --success: #10b981;
    }
    body.dark {
        --bg: #0f172a;
        --card: #1e293b;
        --text: #f1f5f9;
        --primary: #3b82f6;
        --primary-dark: #2563eb;
        --border: #334155;
        --success: #22c55e;
    }
    .container {
        max-width: 1100px;
        margin: auto;
        background: var(--card);
        padding: 2rem;
        border-radius: 14px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    h2 { text-align:center; color:var(--primary); margin-bottom:2rem; }
    .header-bar { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; }
    .back-link { color: var(--primary); text-decoration:none; font-weight:600; font-size:14px; }
    .back-link:hover { text-decoration: underline; }
    .switch { position: relative; display:inline-block; width:54px; height:28px; }
    .switch input { display:none; }
    .slider {
        position:absolute; cursor:pointer; top:0; left:0; right:0; bottom:0;
        background-color:#ccc; border-radius:28px; transition:0.4s;
    }
    .slider:before {
        position:absolute; content:"☀️"; height:24px; width:24px; left:2px; bottom:2px;
        background:white; border-radius:50%; transition:0.4s; display:flex; align-items:center; justify-content:center;
        box-shadow:0 2px 6px rgba(0,0,0,0.2);
    }
    input:checked+.slider { background-color: var(--primary); }
    input:checked+.slider:before { transform:translateX(26px); content:"🌙"; }
    .form-grid { display:grid; grid-template-columns:2fr 1fr; gap:2rem; }
    .form-section {
        background: var(--card); padding:1.5rem; border-radius:10px; border:1px solid var(--border);
        box-shadow:0 4px 12px rgba(0,0,0,0.05);
    }
    .form-group { margin-bottom:1.2rem; position:relative; }
    .form-group label {
        position:absolute; top:-10px; left:12px; background:var(--card); padding:0 6px;
        font-size:13px; color:var(--primary); font-weight:500;
    }
    input[type="text"], textarea, input[type="file"] {
        width:100%; padding:12px; border:1px solid var(--border); border-radius:8px;
        background:transparent; color:var(--text); font-size:14px;
    }
    textarea { min-height:100px; resize:vertical; }
    .image-preview img { border-radius:8px; max-width:100%; height:auto; box-shadow:0 4px 12px rgba(0,0,0,0.1); margin-top:0.5rem;}
    .btn {
        display:block; background: var(--primary); color:#fff; border:none; padding:14px;
        border-radius:10px; cursor:pointer; font-size:16px; margin-top:2rem; width:100%; font-weight:600;
    }
    .btn:hover { background: var(--primary-dark); transform:translateY(-2px); }
    #progressContainer { margin-top:15px; width:100%; background:#e2e8f0; border-radius:8px; overflow:hidden; display:none; }
    #progressBar { height:18px; width:0%; background: var(--primary); text-align:center; color:#fff; line-height:18px; font-size:14px; }
    @media(max-width:900px) { .form-grid { grid-template-columns:1fr; } }
    .modal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999; }
    .modal-content { background:var(--card); padding:2rem; border-radius:12px; text-align:center; width:90%; max-width:400px; box-shadow:0 8px 25px rgba(0,0,0,0.2); }
    .modal-content h3 { margin-bottom:1.5rem; color:var(--success); }
    .modal-content button { background:var(--primary); color:#fff; border:none; padding:10px 20px; border-radius:8px; cursor:pointer; }
    .modal-content button:hover { background: var(--primary-dark); }
</style>
</head>
<body>
<div class="container">
    <div class="header-bar">
        <a href="dashboard.php" class="back-link">Back To Dashboard</a>
        <label class="switch">
            <input type="checkbox" id="themeToggle" onchange="toggleTheme()">
            <span class="slider"></span>
        </label>
    </div>

    <h2>Edit Blog</h2>

    <form id="editBlogForm" enctype="multipart/form-data">
        <div class="form-grid">
            <div class="form-section">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" value="<?=htmlspecialchars($blog['title'])?>" required>
                </div>
                <div class="form-group">
                    <label>Heading</label>
                    <input type="text" name="heading" value="<?=htmlspecialchars($blog['heading'])?>" required>
                </div>
                <div class="form-group">
                    <label>Heading Brief</label>
                    <textarea name="headingbrief" required><?=htmlspecialchars($blog['headingbrief'])?></textarea>
                </div>
                <div class="form-group">
                    <label>Paragraph 1</label>
                    <textarea name="p1" required><?=htmlspecialchars($blog['p1'])?></textarea>
                </div>
                <div class="form-group">
                    <label>Paragraph 2</label>
                    <textarea name="p2" required><?=htmlspecialchars($blog['p2'])?></textarea>
                </div>
                <div class="form-group">
                    <label>Conclusion</label>
                    <textarea name="conclusion" required><?=htmlspecialchars($blog['conclusion'])?></textarea>
                </div>
            </div>

            <div class="form-section">
                <div class="form-group">
                    <label>Cover Image</label>
                    <input type="file" name="cover_image" accept="image/*" onchange="previewImage(event,'coverPreview')">
                    <div class="image-preview" id="coverPreview">
                        <img src="../uploads/<?=$blog['cover_image']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label>Image 1</label>
                    <input type="file" name="image1" accept="image/*" onchange="previewImage(event,'img1Preview')">
                    <div class="image-preview" id="img1Preview">
                        <img src="../uploads/<?=$blog['image1']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label>Image 2</label>
                    <input type="file" name="image2" accept="image/*" onchange="previewImage(event,'img2Preview')">
                    <div class="image-preview" id="img2Preview">
                        <img src="../uploads/<?=$blog['image2']?>">
                    </div>
                </div>
            </div>
        </div>

        <div id="progressContainer">
            <div id="progressBar">0%</div>
        </div>

        <button type="submit" class="btn">Update Blog</button>
    </form>
</div>

<div class="modal" id="successModal">
    <div class="modal-content">
        <h3>Blog Updated Successfully</h3>
        <button onclick="redirectDashboard()">Close</button>
    </div>
</div>

<script>
function toggleTheme() {
    let checkbox = document.getElementById("themeToggle");
    document.body.classList.toggle("dark", checkbox.checked);
    localStorage.setItem("theme", checkbox.checked ? "dark" : "light");
}

function previewImage(event, id) {
    const div = document.getElementById(id);
    div.innerHTML = '';
    const file = event.target.files[0];
    if (file) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        div.appendChild(img);
    }
}

function redirectDashboard() {
    window.location.href = "dashboard.php";
}

document.getElementById('editBlogForm').addEventListener('submit', function(e){
    e.preventDefault();
    const formData = new FormData(this);
    const xhr = new XMLHttpRequest();
    xhr.open('POST','edit_blog.php?id=<?=$id?>',true);

    xhr.upload.onprogress = function(e){
        if(e.lengthComputable){
            document.getElementById('progressContainer').style.display='block';
            const percent = Math.round((e.loaded/e.total)*100);
            const bar = document.getElementById('progressBar');
            bar.style.width = percent + '%';
            bar.innerHTML = percent + '%';
        }
    };

    xhr.onload = function(){
        if(xhr.status===200){
            document.getElementById('successModal').style.display='flex';
        } else {
            alert('Error updating blog');
        }
    };

    xhr.send(formData);
});

window.onload = function() {
    if(localStorage.getItem("theme")==="dark"){
        document.body.classList.add("dark");
        document.getElementById("themeToggle").checked = true;
    }
    <?php if($success): ?>
        document.getElementById('successModal').style.display='flex';
    <?php endif; ?>
}
</script>
</body>
</html>