<?php
header('Content-Type: application/json');

$folders = [
    'photos' => 'temoignages',
    'images' => 'souvenirs'
];

$media = [];

foreach ($folders as $folder => $category) {
    $dirPath = __DIR__ . '/' . $folder;

    if (!is_dir($dirPath)) continue;

    $files = scandir($dirPath);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;

        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $type = in_array($extension, ['jpg', 'jpeg', 'png', 'gif']) ? 'photo' :
                (in_array($extension, ['mp4', 'webm', 'ogg']) ? 'video' : null);

        if (!$type) continue;

        // Année supposée à partir du nom ou fallback à année courante
        preg_match('/\b(20\d{2})\b/', $file, $matches);
        $year = isset($matches[1]) ? $matches[1] : date('Y');

        $media[] = [
            'title' => ucfirst(str_replace(['_', '-', $extension], [' ', ' ', ''], pathinfo($file, PATHINFO_FILENAME))),
            'src'   => "$folder/$file",
            'type'  => $type,
            'category' => $category,
            'year'  => intval($year)
        ];
    }
}

// Écriture du JSON
$outputPath = __DIR__ . '/data/medias.json';
file_put_contents($outputPath, json_encode($media, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo json_encode([
    'status' => 'success',
    'count' => count($media),
    'message' => 'medias.json généré avec succès.',
    'output' => 'data/medias.json'
]);
