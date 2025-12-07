<?php
include("../includes/auth.php");
include("../includes/db.php");

// Get Blog ID
if (!isset($_GET['id'])) { header("Location: all_blogs.php"); exit(); }
$id = intval($_GET['id']);

// Fetch existing data
$result = mysqli_query($conn, "SELECT * FROM blogs WHERE id=$id");
$blog = mysqli_fetch_assoc($result);
if (!$blog) { header("Location: all_blogs.php"); exit(); }

// --- WebP Conversion Function ---
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

// --- Handle Form Submission (AJAX) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $heading = mysqli_real_escape_string($conn, $_POST['heading']);
    $headingbrief = mysqli_real_escape_string($conn, $_POST['headingbrief']);
    $p1 = mysqli_real_escape_string($conn, $_POST['p1']);
    $p2 = mysqli_real_escape_string($conn, $_POST['p2']);
    $conclusion = mysqli_real_escape_string($conn, $_POST['conclusion']);

    $fields = "title='$title', heading='$heading', headingbrief='$headingbrief', p1='$p1', p2='$p2', conclusion='$conclusion'";
    $uploadDir = "../uploads/";

    $images = ['cover_image', 'image1', 'image2'];
    foreach ($images as $imgField) {
        if (!empty($_FILES[$imgField]['name'])) {
            $tmp = $_FILES[$imgField]['tmp_name'];
            $name = time() . '_' . $imgField . '.webp';
            if (convertToWebP($tmp, $uploadDir . $name)) {
                $fields .= ", $imgField='$name'";
            }
        }
    }

    $update_sql = "UPDATE blogs SET $fields WHERE id=$id";
    if (mysqli_query($conn, $update_sql)) {
        exit("success"); // Send clean response to JS
    } else {
        http_response_code(500);
        exit("Error updating blog: " . mysqli_error($conn));
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog | Lexora Admin</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/logo/logo.png" />
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- VARIABLES (MATCHING ADD BLOG) --- */
        :root {
            --primary: #ffb400;
            --primary-hover: #e5a300;
            --bg-body: #f8f9fa;
            --bg-sidebar: #121212;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --danger: #ef4444;
            --success: #10b981;
            --sidebar-width: 260px;
            --header-height: 70px;
        }

        body.dark {
            --bg-body: #0b0b0b;
            --bg-sidebar: #000000;
            --bg-card: #1e1e1e;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border: #333333;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg-body); color: var(--text-main); transition: 0.3s ease; }
        a { text-decoration: none; color: inherit; }

        /* --- LAYOUT --- */
        .dashboard-container { display: flex; min-height: 100vh; }
        
        .sidebar {
            width: var(--sidebar-width); background: var(--bg-sidebar); color: #fff; position: fixed; height: 100vh;
            left: 0; top: 0; z-index: 100; display: flex; flex-direction: column; padding: 20px;
            border-right: 1px solid rgba(255,255,255,0.05); transition: 0.3s ease;
        }
        .brand { display: flex; align-items: center; gap: 12px; margin-bottom: 40px; padding: 0 10px; }
        .brand img { height: 32px; width: auto; }
        .brand span { font-size: 18px; font-weight: 700; color: #fff; }
        .menu-label { font-size: 12px; text-transform: uppercase; color: #666; margin-bottom: 10px; padding-left: 10px; font-weight: 600; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 15px; border-radius: 8px; color: #a0a0a0; transition: 0.3s; margin-bottom: 5px; }
        .nav-item:hover, .nav-item.active { background: rgba(255, 180, 0, 0.1); color: var(--primary); }
        .nav-item i { width: 20px; text-align: center; font-size: 16px; }
        
        .main-content { flex: 1; margin-left: var(--sidebar-width); display: flex; flex-direction: column; }

        header {
            height: var(--header-height); background: var(--bg-card); border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between; padding: 0 30px; position: sticky; top: 0; z-index: 90;
        }
        .header-title h2 { font-size: 20px; font-weight: 600; }
        .user-profile { display: flex; align-items: center; gap: 10px; }
        .avatar { width: 35px; height: 35px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #000; font-weight: bold; }

        /* --- FORM STYLES --- */
        .content-wrapper { padding: 30px; max-width: 1400px; margin: 0 auto; width: 100%; }

        .form-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        }

        .card-header { margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 15px; }
        .card-header h3 { font-size: 16px; font-weight: 700; color: var(--text-main); }

        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; }
        
        .form-input, .form-textarea {
            width: 100%;
            background: var(--bg-body);
            border: 1px solid var(--border);
            padding: 12px 15px;
            border-radius: 8px;
            color: var(--text-main);
            font-size: 14px;
            transition: 0.3s;
            outline: none;
        }

        .form-input:focus, .form-textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(255, 180, 0, 0.1); }
        .form-textarea { min-height: 120px; resize: vertical; line-height: 1.6; }

        /* Upload Zones */
        .upload-zone {
            border: 2px dashed var(--border);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
            position: relative;
            background: var(--bg-body);
            height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .upload-zone.small { height: 140px; }
        .upload-zone:hover { border-color: var(--primary); }

        .upload-icon { font-size: 24px; color: var(--text-muted); margin-bottom: 10px; position: relative; z-index: 10; text-shadow: 0 2px 5px rgba(0,0,0,0.5); }
        .upload-text { font-size: 12px; color: var(--text-muted); position: relative; z-index: 10; text-shadow: 0 2px 5px rgba(0,0,0,0.5); }
        .upload-input { display: none; }

        .preview-img {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;
            display: block; /* Always show existing image */
        }

        .form-actions { margin-top: 20px; display: flex; gap: 15px; align-items: center; }
        .btn-submit {
            background: var(--primary); color: #000; padding: 12px 30px; border-radius: 8px; 
            font-weight: 700; border: none; cursor: pointer; transition: 0.3s;
            display: flex; align-items: center; gap: 8px;
        }
        .btn-submit:hover { background: var(--primary-hover); transform: translateY(-2px); }

        .progress-container { flex: 1; height: 6px; background: var(--border); border-radius: 10px; overflow: hidden; display: none; }
        .progress-bar { height: 100%; background: var(--primary); width: 0%; transition: width 0.3s; }

        .toast-container { position: fixed; bottom: 30px; right: 30px; z-index: 2000; }
        .toast { background: #333; color: #fff; padding: 15px 20px; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); display: flex; align-items: center; gap: 10px; animation: slideIn 0.3s ease; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        @media (max-width: 900px) {
            .form-grid { grid-template-columns: 1fr; }
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>

<body>

    <div class="dashboard-container">
        
        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <img src="../img/logo/logo.jpg" alt="Logo">
                <span>Lexora Admin</span>
            </div>

            <div class="menu-label">Main Menu</div>
            <a href="dashboard.php" class="nav-item">
               <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
            <a href="all_blogs.php" class="nav-item">
                <i class="fas fa-layer-group"></i> <span>All Blogs</span>
            </a>
            <a href="add_blog.php" class="nav-item">
                <i class="fas fa-plus-circle"></i> <span>Add New</span>
            </a>

            <div class="menu-label" style="margin-top: 20px;">System</div>
            <a href="settings.php" class="nav-item">
                <i class="fas fa-cog"></i> <span>Settings</span>
            </a>
            <a href="quote_requests.php" class="nav-item">
                <i class="fas fa-envelope"></i> <span>Inquiries</span>
            </a>

            <div class="sidebar-footer" style="margin-top: auto;">
                <a href="logout.php" class="nav-item" style="color: var(--danger);">
                    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                </a>
            </div>
        </aside>

        <div class="main-content">
            
            <header>
                <div class="header-left" style="display:flex; align-items:center;">
                    <i class="fas fa-bars" id="menuToggle" style="font-size:24px; cursor:pointer; margin-right:15px; display:none;"></i>
                    <div class="header-title">
                        <h2>Edit Blog: <span style="font-weight:400; color:var(--text-muted);">#<?= $id ?></span></h2>
                    </div>
                </div>

                <div class="user-profile">
                    <div class="avatar"><?php echo strtoupper(substr($_SESSION['admin'], 0, 1)); ?></div>
                </div>
            </header>

            <div class="content-wrapper">
                
                <form id="editBlogForm" enctype="multipart/form-data">
                    <div class="form-grid">
                        
                        <div class="card">
                            <div class="card-header">
                                <h3><i class="fas fa-pen-nib"></i> Edit Content</h3>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Main Title</label>
                                <input type="text" name="title" class="form-input" value="<?= htmlspecialchars($blog['title']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Sub-Heading</label>
                                <input type="text" name="heading" class="form-input" value="<?= htmlspecialchars($blog['heading']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Brief Description</label>
                                <textarea name="headingbrief" class="form-textarea" style="min-height:80px;" required><?= htmlspecialchars($blog['headingbrief']) ?></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Content Section 1</label>
                                <textarea name="p1" class="form-textarea" required><?= htmlspecialchars($blog['p1']) ?></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Content Section 2</label>
                                <textarea name="p2" class="form-textarea" required><?= htmlspecialchars($blog['p2']) ?></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Conclusion</label>
                                <textarea name="conclusion" class="form-textarea" style="min-height:80px;" required><?= htmlspecialchars($blog['conclusion']) ?></textarea>
                            </div>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 30px;">
                            
                            <div class="card">
                                <div class="card-header">
                                    <h3><i class="fas fa-image"></i> Media Assets</h3>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Cover Image</label>
                                    <label class="upload-zone" id="zone-cover">
                                        <input type="file" name="cover_image" class="upload-input" accept="image/*" onchange="handlePreview(this, 'preview-cover')">
                                        <div style="position:relative; z-index:10; color:#fff; text-shadow:0 0 5px #000;">
                                            <i class="fas fa-pen"></i> Change Cover
                                        </div>
                                        <img id="preview-cover" src="../uploads/<?= $blog['cover_image'] ?>" class="preview-img">
                                    </label>
                                </div>

                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                    <div class="form-group">
                                        <label class="form-label">Image 1</label>
                                        <label class="upload-zone small" id="zone-1">
                                            <input type="file" name="image1" class="upload-input" accept="image/*" onchange="handlePreview(this, 'preview-1')">
                                            <div style="position:relative; z-index:10; color:#fff; text-shadow:0 0 5px #000;">Change</div>
                                            <img id="preview-1" src="../uploads/<?= $blog['image1'] ?>" class="preview-img">
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Image 2</label>
                                        <label class="upload-zone small" id="zone-2">
                                            <input type="file" name="image2" class="upload-input" accept="image/*" onchange="handlePreview(this, 'preview-2')">
                                            <div style="position:relative; z-index:10; color:#fff; text-shadow:0 0 5px #000;">Change</div>
                                            <img id="preview-2" src="../uploads/<?= $blog['image2'] ?>" class="preview-img">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h3><i class="fas fa-save"></i> Save Changes</h3>
                                </div>
                                
                                <div class="form-actions" style="flex-direction: column; align-items: stretch;">
                                    <div id="progressContainer" class="progress-container">
                                        <div id="progressBar" class="progress-bar"></div>
                                    </div>
                                    
                                    <button type="submit" class="btn-submit" style="justify-content: center;">
                                        <i class="fas fa-check-circle"></i> Update Blog
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div id="toastContainer" class="toast-container"></div>

    <script>
        // Sidebar Mobile Toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        if(window.innerWidth <= 768) menuToggle.style.display = 'block';
        menuToggle.addEventListener('click', () => sidebar.classList.toggle('active'));

        // Theme Logic
        if (localStorage.getItem("theme") === "dark") document.body.classList.add("dark");

        // Image Preview Logic
        function handlePreview(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById(previewId);
                    img.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function showToast(msg, type) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'toast';
            const icon = type === 'success' ? '<i class="fas fa-check-circle" style="color:var(--success)"></i>' : '<i class="fas fa-exclamation-circle" style="color:var(--danger)"></i>';
            toast.innerHTML = `${icon} <span>${msg}</span>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // AJAX Update
        const form = document.getElementById('editBlogForm');
        const progressContainer = document.getElementById('progressContainer');
        const progressBar = document.getElementById('progressBar');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const xhr = new XMLHttpRequest();
            // Post to same file
            xhr.open('POST', 'edit_blog.php?id=<?= $id ?>', true);

            xhr.upload.onprogress = function(event) {
                if (event.lengthComputable) {
                    progressContainer.style.display = 'block';
                    const percent = Math.round((event.loaded / event.total) * 100);
                    progressBar.style.width = percent + '%';
                }
            };

            xhr.onload = function() {
                if (xhr.status === 200 && xhr.responseText.includes('success')) {
                    showToast("Blog updated successfully!", "success");
                    // Wait 1.5s then go back to dashboard
                    setTimeout(() => window.location.href = "dashboard.php", 1500);
                } else {
                    showToast("Error updating blog. Check console.", "error");
                    console.error(xhr.responseText);
                    progressContainer.style.display = 'none';
                }
            };

            xhr.send(formData);
        });
    </script>
</body>
</html>