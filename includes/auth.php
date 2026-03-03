<?php
session_start();
if (!isset($_SESSION['admin'])) {
    // Get the base path dynamically so it works from any subfolder
    $base = str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname(dirname(__FILE__)));
    header("Location: " . $base . "/admin/index.php");
    exit();
}
?>