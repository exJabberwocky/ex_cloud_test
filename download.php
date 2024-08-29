<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$file = isset($_GET['file']) ? $_GET['file'] : '';
$path = '/var/www/ex_cloud/cloud_share/' . $file;

if (file_exists($path) && is_file($path)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($path) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($path));
    
    $file = fopen($path, 'rb');
    while (!feof($file)) {
        echo fread($file, 8192);
        ob_flush();
        flush();
    }
    fclose($file);
    exit;
} else {
    header('Location: files.php');
    exit;
}
