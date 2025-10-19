<?php include("../includes/auth.php"); ?>
<?php
$success = isset($_GET['success']); // Use ?success=1 after successful upload
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Lexora Tech | Admin Add Blog</title>
  <link rel="shortcut icon" type="image/x-icon" href="../img/logo/logo.png" />
  <style>
    /* --- Keep your original styles --- */
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
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    h2 {
      text-align: center;
      margin-bottom: 2rem;
      color: var(--primary);
    }

    .header-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
    }

    .back-link {
      text-decoration: none;
      color: var(--primary);
      font-size: 14px;
      font-weight: 600;
    }

    .back-link:hover {
      text-decoration: underline;
    }

    /* Toggle */
    .switch {
      position: relative;
      display: inline-block;
      width: 54px;
      height: 28px;
    }

    .switch input {
      display: none;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      transition: 0.4s;
      border-radius: 28px;
    }

    .slider:before {
      position: absolute;
      content: "☀️";
      height: 24px;
      width: 24px;
      left: 2px;
      bottom: 2px;
      background-color: white;
      border-radius: 50%;
      transition: 0.4s;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    input:checked+.slider {
      background-color: var(--primary);
    }

    input:checked+.slider:before {
      transform: translateX(26px);
      content: "🌙";
    }

    /* Form Grid */
    .form-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 2rem;
    }

    .form-section {
      background: var(--card);
      padding: 1.5rem;
      border-radius: 10px;
      border: 1px solid var(--border);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .form-group {
      margin-bottom: 1.2rem;
      position: relative;
    }

    .form-group label {
      position: absolute;
      top: -10px;
      left: 12px;
      background: var(--card);
      padding: 0 6px;
      font-size: 13px;
      color: var(--primary);
      font-weight: 500;
    }

    input[type="text"],
    textarea,
    input[type="file"] {
      width: 100%;
      padding: 12px;
      border: 1px solid var(--border);
      border-radius: 8px;
      background: transparent;
      color: var(--text);
      font-size: 14px;
    }

    textarea {
      min-height: 100px;
      resize: vertical;
    }

    .image-preview {
      margin-top: 0.5rem;
    }

    .image-preview img {
      border-radius: 8px;
      max-width: 100%;
      height: auto;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn {
      display: block;
      background: var(--primary);
      color: #fff;
      border: none;
      padding: 14px;
      border-radius: 10px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 2rem;
      width: 100%;
      font-weight: 600;
    }

    .btn:hover {
      background: var(--primary-dark);
    }

    /* Progress Bar */
    #progressContainer {
      margin-top: 15px;
      width: 100%;
      background: #e2e8f0;
      border-radius: 8px;
      display: none;
      overflow: hidden;
    }

    #progressBar {
      height: 18px;
      width: 0;
      background: var(--primary);
      text-align: center;
      color: #fff;
      line-height: 18px;
      border-radius: 8px;
      font-size: 14px;
    }

    @media (max-width: 900px) {
      .form-grid {
        grid-template-columns: 1fr;
      }
    }

    /* Center Modal */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .modal-content {
      background: var(--card);
      padding: 2rem;
      border-radius: 12px;
      text-align: center;
      width: 90%;
      max-width: 400px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .modal-content h3 {
      margin-bottom: 1.5rem;
      color: var(--success);
    }

    .modal-content button {
      background: var(--primary);
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
    }

    .modal-content button:hover {
      background: var(--primary-dark);
    }
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
      <div class="form-grid">
        <!-- Left: Content -->
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
        <!-- Right: Images -->
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

      <div id="progressContainer">
        <div id="progressBar">0%</div>
      </div>

      <button type="submit" class="btn">Upload Blog</button>
    </form>
  </div>

  <!-- Success Modal -->
  <?php if ($success): ?>
    <div class="modal" id="successModal">
      <div class="modal-content">
        <h3>Blog Added Successfully</h3>
        <button onclick="redirectDashboard()">Close</button>
      </div>
    </div>
  <?php endif; ?>

  <script>
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

      const modal = document.getElementById('successModal');
      if (modal) modal.style.display = 'flex';
    }

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

    // --- AJAX Form Submission with Loader ---
    const form = document.getElementById('blog-form');
    const progressContainer = document.getElementById('progressContainer');
    const progressBar = document.getElementById('progressBar');

    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(form);
      const xhr = new XMLHttpRequest();

      xhr.open('POST', 'upload.php', true);

      xhr.upload.onprogress = function(event) {
        if (event.lengthComputable) {
          progressContainer.style.display = 'block';
          const percent = Math.round((event.loaded / event.total) * 100);
          progressBar.style.width = percent + '%';
          progressBar.textContent = percent + '%';
        }
      };

      xhr.onload = function() {
        if (xhr.status === 200) {
          window.location.href = "add_blog.php?success=1";
        } else {
          alert('Upload Failed: ' + xhr.responseText);
        }
      };

      xhr.send(formData);
    });
  </script>
</body>

</html>