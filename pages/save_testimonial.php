<?php
header('Content-Type: application/json');

$host = '127.0.0.1';
$port = 3307;
$dbname = 'lolosebbd';
$user = 'root';
$pass = '3mp@sseDesCygnesBlancs';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur BDD']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

$nom = trim($_POST['name'] ?? '');
$musique = trim($_POST['music'] ?? '');
$message = trim($_POST['message'] ?? '');

if (strlen($nom) < 2 || strlen($message) < 2) {
    http_response_code(400);
    echo json_encode(['error' => 'Nom et message requis']);
    exit;
}

$photoDir = dirname(__DIR__) . '/photos/';
if (!is_dir($photoDir)) mkdir($photoDir, 0755, true);

// On prépare une liste pour les photos
$uploadedPhotos = [];

if (!empty($_FILES['photo']) && is_array($_FILES['photo']['name'])) {
    foreach ($_FILES['photo']['name'] as $i => $name) {
        if ($_FILES['photo']['error'][$i] === UPLOAD_ERR_NO_FILE) continue;

        $tmpName = $_FILES['photo']['tmp_name'][$i];
        $error = $_FILES['photo']['error'][$i];
        $size = $_FILES['photo']['size'][$i];
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if ($error === UPLOAD_ERR_OK && in_array($ext, $allowed) && $size < 10 * 1024 * 1024) {
            $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($name, PATHINFO_FILENAME));
            $fileName = uniqid('photo_') . '_' . $safeName . '.' . $ext;
            if (move_uploaded_file($tmpName, $photoDir . $fileName)) {
                $uploadedPhotos[] = $fileName;
            }
        }
    }
}

// 1ère image = principale
$mainPhoto = $uploadedPhotos[0] ?? null;

try {
    $stmt = $pdo->prepare("INSERT INTO temoignages (nom, musique, message, photo) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $musique ?: null, $message, $mainPhoto]);
    $temoignageId = $pdo->lastInsertId();

    // Si d'autres images, on les ajoute dans la table liée
    if (count($uploadedPhotos) > 1) {
        $stmtImg = $pdo->prepare("INSERT INTO temoignage_photos (temoignage_id, filename) VALUES (?, ?)");
        foreach (array_slice($uploadedPhotos, 1) as $img) {
            $stmtImg->execute([$temoignageId, $img]);
        }
    }

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de l\'enregistrement']);
}