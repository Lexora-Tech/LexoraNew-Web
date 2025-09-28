<?php include("../includes/auth.php"); ?>
<?php
$success = isset($_GET['success']); // fallback success for non-AJAX
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>LexoraTech | Admin Add Blog</title>
  <link rel="shortcut icon" type="image/x-icon" href="../img/logo/logo.png" />
  <style>
    /* (kept your styles, plus small additions for progress) */
    body { font-family: 'Segoe UI', sans-serif; background: var(--bg); color: var(--text); margin: 0; padding: 2rem; transition: background 0.4s, color 0.4s; }
    :root { --bg: #f1f5f9; --card: #fff; --text: #1e293b; --primary: #2563eb; --primary-dark: #1d4ed8; --border: #e2e8f0; --success: #10b981; }
    body.dark { --bg: #0f172a; --card: #1e293b; --text: #f1f5f9; --primary: #3b82f6; --primary-dark: #2563eb; --border: #334155; --success: #22c55e; }
    .container { max-width: 1100px; margin: auto; background: var(--card); padding: 2rem; border-radius: 14px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15); }
    h2 { text-align: center; margin-bottom: 2rem; color: var(--primary); }
    .header-bar { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; }
    .back-link { text-decoration:none; color:var(--primary); font-size:14px; font-weight:600; }
    .btn { display:block; background:var(--primary); color:#fff; border:none; padding:14px; border-radius:10px; cursor:pointer; font-size:16px; margin-top:2rem; width:100%; font-weight:600; }
    .btn:disabled { opacity:0.6; cursor:not-allowed; }

    /* image preview */
    .image-preview img { border-radius:8px; max-width:100%; height:auto; box-shadow:0 4px 12px rgba(0,0,0,0.1); }

    /* progress */
    #progressContainer { display:none; margin-top: 1rem; background: #e6eefc; border-radius: 8px; padding:8px; }
    #progressBarOuter { width:100%; height:16px; background: rgba(0,0,0,0.06); border-radius: 8px; overflow:hidden; }
    #progressBar { height:100%; width:0%; background: var(--primary); transition: width .2s ease; }
    #progressPercent { margin-top: 6px; font-size: 13px; color: var(--text); }

    /* modal fallback */
    .modal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999; }
    .modal-content { background:var(--card); padding:2rem; border-radius:12px; text-align:center; width:90%; max-width:400px; box-shadow:0 8px 25px rgba(0,0,0,0.2); }
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

    <h2>Add New Blog</h2>

    <form id="blog-form" action="upload.php" method="POST" enctype="multipart/form-data">
      <div class="form-grid" style="display:grid; grid-template-columns:2fr 1fr; gap:2rem;">
        <div class="form-section">
          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" placeholder="Blog Title" required>
          </div>
          <div class="form-group">
            <label>Heading</label>
            <input type="text" name="heading" placeholder="Blog Heading" required>
          </div>
          <div class="form-group">
            <label>Heading Brief</label>
            <input type="text" name="headingbrief" placeholder="Blog Heading Brief" required>
          </div>
          <div class="form-group">
            <label>Paragraph 1</label>
            <textarea name="p1" placeholder="Blog Para 1" required></textarea>
          </div>
          <div class="form-group">
            <label>Paragraph 2</label>
            <textarea name="p2" placeholder="Blog Para 2" required></textarea>
          </div>
          <div class="form-group">
            <label>Conclusion</label>
            <textarea name="conclusion" placeholder="Conclusion" required></textarea>
          </div>
        </div>

        <div class="form-section">
          <div class="form-group">
            <label>Cover Image</label>
            <input type="file" name="cover_image" accept="image/*" required onchange="previewImage(event, 'coverPreview')">
            <div class="image-preview" id="coverPreview"></div>
          </div>
          <div class="form-group">
            <label>Image 1</label>
            <input type="file" name="image1" accept="image/*" required onchange="previewImage(event, 'img1Preview')">
            <div class="image-preview" id="img1Preview"></div>
          </div>
          <div class="form-group">
            <label>Image 2</label>
            <input type="file" name="image2" accept="image/*" required onchange="previewImage(event, 'img2Preview')">
            <div class="image-preview" id="img2Preview"></div>
          </div>
        </div>
      </div>

      <!-- Progress -->
      <div id="progressContainer">
        <div id="progressBarOuter"><div id="progressBar"></div></div>
        <div id="progressPercent">0%</div>
      </div>

      <button type="submit" class="btn" id="uploadBtn">Upload Blog</button>
    </form>
  </div>

  <!-- success modal (AJAX) -->
  <div class="modal" id="successModal">
    <div class="modal-content">
      <h3>Blog Added Successfully ✅</h3>
      <p>The blog was uploaded as WEBP images and saved.</p>
      <button onclick="redirectDashboard()" class="btn">Back to Dashboard</button>
    </div>
  </div>

  <?php if ($success): ?>
    <div class="modal" id="successModalFallback" style="display:flex;">
      <div class="modal-content">
        <h3>Blog Added Successfully</h3>
        <button onclick="redirectDashboard()" class="btn">Back to Dashboard</button>
      </div>
    </div>
  <?php endif; ?>

  <script>
    // theme
    function toggleTheme() {
      let checkbox = document.getElementById("themeToggle");
      document.body.classList.toggle("dark", checkbox.checked);
      localStorage.setItem("theme", checkbox.checked ? "dark" : "light");
    }
    window.onload = function() {
      if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark");
        document.getElementById("themeToggle").checked = true;
      }
      // for fallback modal
      const modal = document.getElementById('successModalFallback');
      if (modal) modal.style.display = 'flex';
    }

    // preview image
    function previewImage(event, previewId) {
      const previewDiv = document.getElementById(previewId);
      previewDiv.innerHTML = '';
      const file = event.target.files[0];
      if (file) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        previewDiv.appendChild(img);
      }
    }

    function redirectDashboard() {
      window.location.href = "dashboard.php";
    }

    // small toast utility
    function showToast(msg) {
      alert(msg); // keep simple - you can replace with fancier toast
    }

    // AJAX upload with progress
    const form = document.getElementById('blog-form');
    const btn = document.getElementById('uploadBtn');
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      uploadBlog();
    });

    function uploadBlog() {
      const formData = new FormData(form);
      btn.disabled = true;
      btn.innerText = 'Uploading...';

      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'upload.php', true);
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      xhr.responseType = 'json';

      xhr.upload.onprogress = function (e) {
        if (e.lengthComputable) {
          const percent = Math.round((e.loaded / e.total) * 100);
          document.getElementById('progressContainer').style.display = 'block';
          document.getElementById('progressBar').style.width = percent + '%';
          document.getElementById('progressPercent').innerText = percent + '%';
        }
      };

      xhr.onload = function () {
        btn.disabled = false;
        btn.innerText = 'Upload Blog';
        if (xhr.status === 200) {
          const res = xhr.response;
          if (res && res.success) {
            // show success modal
            document.getElementById('successModal').style.display = 'flex';
            // optionally auto-redirect after a short delay:
            // setTimeout(() => window.location.href='dashboard.php', 1600);
          } else {
            showToast(res && res.message ? res.message : 'Upload failed.');
          }
        } else {
          showToast('Upload failed — server error.');
        }
      };

      xhr.onerror = function () {
        btn.disabled = false;
        btn.innerText = 'Upload Blog';
        showToast('Network error during upload.');
      };

      xhr.send(formData);
    }
  </script>
</body>
</html>
