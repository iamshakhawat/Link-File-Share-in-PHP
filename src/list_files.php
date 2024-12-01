<?php
$uploadDir = __DIR__ . '/upload/';
$files = [];
$allowedIcons = [
    'image/' => 'bi-file-image',
    'video/' => 'bi-file-play',
    'audio/' => 'bi-file-music',
    'application/pdf' => 'bi-file-earmark-pdf',
    'default' => 'bi-file-earmark'
];

if (is_dir($uploadDir)) {
    foreach (scandir($uploadDir) as $file) {
        if ($file === '.' || $file === '..' || $file === '.htaccess') continue;

        $filePath = $uploadDir . $file;
        $fileSize = round(filesize($filePath) / (1024 * 1024), 2); // Size in MB
        $fileTime = date('Y-m-d H:i:s', filemtime($filePath));
        $fileType = mime_content_type($filePath);
        $fileIcon = $allowedIcons['default'];

        foreach ($allowedIcons as $type => $icon) {
            if (strpos($fileType, $type) === 0) {
                $fileIcon = $icon;
                break;
            }
        }

        $files[] = [
            'name' => $file,
            'size' => $fileSize,
            'time' => $fileTime,
            'icon' => $fileIcon
        ];
    }
}

echo json_encode($files);
