<?php
// temoignage_detail.php
$host = '127.0.0.1';
$port = 3307;
$dbname = 'lolosebbd';
$user = 'root';
$pass = '3mp@sseDesCygnesBlancs';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $stmt = $pdo->prepare("SELECT * FROM temoignages WHERE id = ?");
    $stmt->execute([$id]);
    $temoignage = $stmt->fetch();

    if (!$temoignage) {
        echo "Témoignage introuvable.";
        exit;
    }

    $stmt2 = $pdo->prepare("SELECT filename FROM temoignage_photos WHERE temoignage_id = ?");
    $stmt2->execute([$id]);
    $photos = $stmt2->fetchAll(PDO::FETCH_COLUMN);

    $baseUrl = '../photos/'; // adapte ce chemin selon ta config
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Témoignage de <?= htmlspecialchars($temoignage['nom']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
</head>
<body class="bg-light py-4">

<div class="container bg-white p-4 rounded shadow-sm">
  <h1 class="mb-3">Témoignage de <?= htmlspecialchars($temoignage['nom']) ?></h1>
  <?php if ($temoignage['musique']): ?>
    <p><strong>Morceau favori :</strong> <?= htmlspecialchars($temoignage['musique']) ?></p>
  <?php endif; ?>
  <p><?= nl2br(htmlspecialchars($temoignage['message'])) ?></p>

  <?php
    $allPhotos = array_filter(array_merge(
        [$temoignage['photo']],
        $photos
    ));
  ?>

  <?php if ($allPhotos): ?>
    <h4 class="mt-4">Photos associées :</h4>
    <div class="d-flex flex-wrap gap-2">
      <?php foreach ($allPhotos as $i => $img): ?>
        <a href="<?= $baseUrl . $img ?>" class="glightbox" data-gallery="galerie" data-title="Photo <?= $i+1 ?>">
          <img src="<?= $baseUrl . $img ?>" alt="" style="width: 100px; height: 100px; object-fit: cover; border-radius: 6px;">
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <a href="temoignage.php" class="btn btn-secondary mt-4">← Retour aux témoignages</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
  GLightbox({ selector: '.glightbox' });
</script>

</body>
</html>