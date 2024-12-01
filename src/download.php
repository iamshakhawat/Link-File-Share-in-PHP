<?php
$uploadDir = __DIR__ . '/upload/';
$filename = $_GET['file'] ?? '';

if ($filename && file_exists($uploadDir . $filename)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($uploadDir . $filename));
    readfile($uploadDir . $filename);
    exit;
} else {
    http_response_code(404);
    echo 'File not found';
}
