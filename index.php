<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Le Mariage de Lolo & Seb</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- AOS Animations CSS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

  <!-- peros -->
  <link href="styles/style.css" rel="stylesheet">

</head>
<body>

  <?php $base = ''; include 'includes/header.php'; ?>

  <main class="container">
    <section data-aos="zoom-in">
      <video controls preload="metadata" poster="video/preview.jpg" aria-label="Souvenirs vidéo">
        <source src="video/video.mp4" type="video/mp4">
        Votre navigateur ne supporte pas la vidéo.
      </video>
    </section>

    <section class="text-center" data-aos="fade-up">
      <h2>Partagez un mot ou participez !</h2>
         <a href="pages/temoignage.php" class="btn btn-custom">
            <i class="fa-solid fa-pen"></i> Témoignage
        </a>
        <a href="galerie.php" class="btn btn-outline-secondary">
          <i class="fa-solid fa-image"></i> Galerie Photos
        </a>
    </section>

    <section data-aos="fade-up">
      <h2>Programme des festivités</h2>
      <div class="list-group list-group-flush">
        <div class="list-group-item">
          <h5 class="mb-1">Vendredi 19.12</h5>
          <p class="mb-1">Mariage à la mairie.</p>
        </div>
        <div class="list-group-item">
          <h5 class="mb-1">Samedi 20 décembre</h5>
          <p class="mb-1">La Java... mais aussi le jazz, le rock, le maloya, le raggae...</p>
        </div>
      </div>
    </section>

    <section data-aos="fade-up">
      <h2>Lieu du Mariage</h2>
      <div class="map-container mt-3">
        <iframe title="Carte de localisation"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.857927302779!2d55.31328421618141!3d-20.9707037563349!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x21787e3b3e7e7e7f%3A0x0!2sPaul%20et%20Virginie!5e0!3m2!1sfr!2sfr!4v1716570000001"
          width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Lolo & Seb – Tous droits réservés</p>
  </footer>

  <!-- Modal Témoignage -->
  <div class="modal fade" id="temoignageModal" tabindex="-1" aria-labelledby="temoignageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="temoignageModalLabel">Laisser un témoignage</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="name" class="form-label">Votre nom</label>
              <input type="text" class="form-control" id="name" placeholder="Ex : Marie">
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Votre message</label>
              <textarea class="form-control" id="message" rows="4" placeholder="Votre mot doux..."></textarea>
            </div>
            <button type="button" class="btn btn-custom w-100" data-bs-dismiss="modal" onclick="alert('Merci pour votre mot 🥰')">Envoyer</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="scripts/src/bootstrap.bundle.min.js"></script>
  <script src="scripts/src/aos.js"></script>
  <script>
    AOS.init({ once: true, duration: 1000, offset: 100 });
  </script>
  <script src="scripts/countdown.js"></script>
</body>
</html>
