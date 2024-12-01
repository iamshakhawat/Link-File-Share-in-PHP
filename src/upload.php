<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the upload directory
$uploadDir = 'upload/';

// Create the upload directory if it doesn't exist
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Response structure
$response = [
    'uploaded' => [],
    'errors' => []
];

// Check if files are received
if (isset($_FILES['files']) && !empty($_FILES['files']['name'][0])) {
    // Loop through each uploaded file
    foreach ($_FILES['files']['name'] as $index => $fileName) {
        $tmpName = $_FILES['files']['tmp_name'][$index];
        $error = $_FILES['files']['error'][$index];
        $fileSize = $_FILES['files']['size'][$index];
        $targetPath = $uploadDir . basename($fileName);

        // Check for upload errors
        if ($error === UPLOAD_ERR_OK) {
            // Validate file size (e.g., max 5MB)
            if ($fileSize <= 1024 * 1024 * 1024) { 
                // Move the uploaded file
                if (move_uploaded_file($tmpName, $targetPath)) {
                    $response['uploaded'][] = $fileName;
                } else {
                    $response['errors'][] = "Failed to upload file: $fileName.";
                }
            } else {
                $response['errors'][] = "File too large: $fileName (max 5MB).";
            }
        } else {
            $response['errors'][] = "Error uploading file: $fileName (Error Code: $error).";
        }
    }
} else {
    $response['errors'][] = "No files received.";
}

// Return response as JSON
header('Content-Type: application/json');
echo json_encode($response);
