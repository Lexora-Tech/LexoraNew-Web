<?php
include("../includes/db.php");
include("../includes/auth.php");

// Respond JSON for AJAX
header('Content-Type: application/json');

// Basic checks
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// config
$maxFileSize = 8 * 1024 * 1024; // 8 MB per image (adjust if needed)
$allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$uploadDir = __DIR__ . '/../uploads/';

// ensure upload dir exists
if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
    echo json_encode(['success' => false, 'message' => 'Failed to create upload directory.']);
    exit;
}

// helper: convert using GD
function convertToWebpWithGD($tmpPath, $destPath, $quality = 80) {
    $info = @getimagesize($tmpPath);
    if (!$info) return false;
    $mime = $info['mime'];

    switch ($mime) {
        case 'image/jpeg':
            $img = @imagecreatefromjpeg($tmpPath);
            break;
        case 'image/png':
            $img = @imagecreatefrompng($tmpPath);
            if ($img) {
                // ensure alpha preserved
                imagepalettetotruecolor($img);
                imagealphablending($img, true);
                imagesavealpha($img, true);
            }
            break;
        case 'image/gif':
            $img = @imagecreatefromgif($tmpPath);
            break;
        case 'image/webp':
            if (function_exists('imagecreatefromwebp')) {
                $img = @imagecreatefromwebp($tmpPath);
            } else {
                $img = false;
            }
            break;
        default:
            return false;
    }

    if (!$img) return false;

    // Save as WebP
    $saved = false;
    if (function_exists('imagewebp')) {
        $saved = imagewebp($img, $destPath, $quality);
    }
    imagedestroy($img);
    return $saved;
}

// helper: convert using Imagick fallback
function convertToWebpWithImagick($tmpPath, $destPath, $quality = 80) {
    if (!class_exists('Imagick')) return false;
    try {
        $im = new Imagick($tmpPath);
        $im->setImageFormat('webp');
        $im->setImageCompressionQuality($quality);
        $im->writeImage($destPath);
        $im->clear();
        $im->destroy();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// process three images
$fields = ['cover_image', 'image1', 'image2'];
$storedFiles = [];

foreach ($fields as $field) {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        // Clean up any files created earlier:
        foreach ($storedFiles as $f) { if (file_exists($uploadDir . $f)) @unlink($uploadDir . $f); }
        echo json_encode(['success' => false, 'message' => "Missing or error in file: $field"]);
        exit;
    }

    $file = $_FILES[$field];
    if ($file['size'] > $maxFileSize) {
        foreach ($storedFiles as $f) { if (file_exists($uploadDir . $f)) @unlink($uploadDir . $f); }
        echo json_encode(['success' => false, 'message' => "File $field is too large. Max: {$maxFileSize} bytes"]);
        exit;
    }

    $tmpPath = $file['tmp_name'];
    $info = @getimagesize($tmpPath);
    if (!$info || !in_array($info['mime'], $allowedMimes)) {
        foreach ($storedFiles as $f) { if (file_exists($uploadDir . $f)) @unlink($uploadDir . $f); }
        echo json_encode(['success' => false, 'message' => "File $field is not a permitted image type."]);
        exit;
    }

    $newFilename = time() . '_' . uniqid() . '_' . $field . '.webp';
    $destPath = $uploadDir . $newFilename;

    $converted = false;
    // try GD first
    if (function_exists('imagewebp')) {
        $converted = convertToWebpWithGD($tmpPath, $destPath, 80);
    }
    // fallback: Imagick
    if (!$converted) {
        $converted = convertToWebpWithImagick($tmpPath, $destPath, 80);
    }

    if (!$converted) {
        // cleanup
        foreach ($storedFiles as $f) { if (file_exists($uploadDir . $f)) @unlink($uploadDir . $f); }
        echo json_encode([
            'success' => false,
            'message' => "Failed to convert $field to WebP. Ensure PHP GD with WebP support or Imagick is installed."
        ]);
        exit;
    }

    // set permission
    @chmod($destPath, 0644);

    // store filename to save into DB (relative path)
    $storedFiles[$field] = $newFilename;
}

// sanitize inputs (basic, because we use prepared statements)
$title = $_POST['title'] ?? '';
$heading = $_POST['heading'] ?? '';
$headingbrief = $_POST['headingbrief'] ?? '';
$p1 = $_POST['p1'] ?? '';
$p2 = $_POST['p2'] ?? '';
$conclusion = $_POST['conclusion'] ?? '';

// Insert into DB using prepared statement
$sql = "INSERT INTO blogs (title, heading, headingbrief, p1, p2, conclusion, cover_image, image1, image2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    // cleanup
    foreach ($storedFiles as $f) { if (file_exists($uploadDir . $f)) @unlink($uploadDir . $f); }
    echo json_encode(['success' => false, 'message' => 'DB prepare error: ' . $conn->error]);
    exit;
}

$coverFile = $storedFiles['cover_image'];
$image1File = $storedFiles['image1'];
$image2File = $storedFiles['image2'];

$stmt->bind_param('sssssssss', $title, $heading, $headingbrief, $p1, $p2, $conclusion, $coverFile, $image1File, $image2File);

if ($stmt->execute()) {
    // if Ajax, JSON; otherwise redirect back as fallback
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        echo json_encode(['success' => true, 'message' => 'Blog uploaded successfully']);
        exit;
    } else {
        header("Location: add_blog.php?success=1");
        exit;
    }
} else {
    // cleanup files
    foreach ($storedFiles as $f) { if (file_exists($uploadDir . $f)) @unlink($uploadDir . $f); }
    echo json_encode(['success' => false, 'message' => 'DB insert failed: ' . $stmt->error]);
    exit;
}
