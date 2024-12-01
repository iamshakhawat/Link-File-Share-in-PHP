<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the content from the AJAX request
    $content = $_POST['content'] ?? '';

    // Define the file path
    $filePath = __DIR__ . '/text.txt';

    // Save the content to the file (overwrite mode)
    if (file_put_contents($filePath, $content) !== false) {
        // Respond back to the AJAX request
        echo json_encode(['status' => 'success', 'message' => 'Content saved']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save content']);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
