<?php
header('Content-Type: application/json');

// Config DB
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

    // Requête principale
    $stmt = $pdo->query("SELECT id, nom, musique, message, photo, date_depot FROM temoignages ORDER BY date_depot DESC");
    $temoignages = $stmt->fetchAll();

    // Construction des URLs
    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/lolosebcelebration/photos/';

    foreach ($temoignages as &$t) {
        // Photo principale
        $t['photo'] = $t['photo'] ? $baseUrl . ltrim($t['photo'], '/') : null;

        // Charger les autres photos
        $stmt2 = $pdo->prepare("SELECT filename FROM temoignage_photos WHERE temoignage_id = ?");
        $stmt2->execute([$t['id']]);
        $t['photos'] = array_map(function ($row) use ($baseUrl) {
            return $baseUrl . ltrim($row['filename'], '/');
        }, $stmt2->fetchAll());
    }

    echo json_encode(['success' => true, 'temoignages' => $temoignages]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erreur BDD',
        'details' => $e->getMessage()
    ]);
}