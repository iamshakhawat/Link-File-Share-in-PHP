<?php
$uploadDir = __DIR__ . '/upload/';
$filename = $_POST['filename'] ?? '';

if ($filename && file_exists($uploadDir . $filename)) {
    unlink($uploadDir . $filename);
    echo 'File deleted';
} else {
    http_response_code(400);
    echo 'Invalid file';
}
