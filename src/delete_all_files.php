<?php
$uploadDir = __DIR__ . '/upload/';
$response = ['success' => false, 'message' => ''];

if (is_dir($uploadDir)) {
    $filesDeleted = 0;

    foreach (scandir($uploadDir) as $file) {
        // Skip "." and ".." as well as ".htaccess" files
        if ($file === '.' || $file === '..' || $file === '.htaccess') continue;

        $filePath = $uploadDir . $file;

        // Delete the file
        if (is_file($filePath) && unlink($filePath)) {
            $filesDeleted++;
        }
    }

    if ($filesDeleted > 0) {
        $response['success'] = true;
        $response['message'] = "Deleted $filesDeleted files.";
    } else {
        $response['message'] = 'No files to delete or deletion failed.';
    }
} else {
    $response['message'] = 'Upload directory does not exist.';
}

echo json_encode($response);
