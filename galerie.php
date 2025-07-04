<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Galerie Photos - Lolo & Seb</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- AOS Animations CSS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet" />
  <!-- GLightbox CSS -->
  <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet" />
  <!-- Style personnalisé -->
  <link href="styles/style.css" rel="stylesheet" />
</head>
<body>

  <?php $base = ''; include 'includes/header.php'; ?>

  <!-- Titre + bouton retour -->
  <section class="container text-start my-4" style="max-width: 1140px;">
    <div class="mb-3">
      <a href="index.php" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left"></i> Retour à l'accueil
      </a>
    </div>
    <h1 style="font-family: 'Playfair Display', serif; font-size: 3.5rem; color: #222;">
      Galerie Photos
    </h1>
  </section>

  <!-- Admin -->
  <div id="admin-tools" style="display: none; text-align: right; margin-bottom: 1rem; max-width: 1140px; margin-left: auto; margin-right: auto;">
    <button id="regenerate-json" class="btn btn-sm btn-warning">🔄 Régénérer medias.json</button>
    <span id="admin-status" style="margin-left: 1rem; font-style: italic;"></span>
  </div>

  <!-- Galerie -->
  <main class="container bg-white p-4 rounded shadow" data-aos="fade-up" style="max-width: 1140px; margin: 2rem auto 3rem;">
    <div class="row mb-4" data-aos="fade-up">
      <div class="col-md-8">
        <div class="btn-group" role="group" aria-label="Catégories">
          <button class="btn btn-outline-primary filter-btn active" data-filter="all">Toutes</button>
          <button class="btn btn-outline-primary filter-btn" data-filter="souvenirs">Souvenirs</button>
          <button class="btn btn-outline-primary filter-btn" data-filter="temoignages">Témoignages</button>
        </div>
      </div>
      <div class="col-md-4">
        <select id="subfilter" class="form-select">
          <option value="all">Tous types</option>
          <option value="photo">Photos</option>
          <option value="video">Vidéos</option>
        </select>
      </div>
    </div>

    <div id="gallery" class="row g-3" data-aos="fade-up">
      <!-- JS injecte ici -->
    </div>
  </main>

  <footer style="background: #1e1e2f; color: white; text-align: center; padding: 2rem 1rem; border-radius: 0 0 12px 12px; max-width: 1140px; margin: 0 auto 2rem;">
    <p>&copy; 2025 Lolo & Seb – Tous droits réservés</p>
  </footer>

  <!-- Scripts -->
  <script src="scripts/src/bootstrap.bundle.min.js"></script>
  <script src="scripts/src/aos.js"></script>
  <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
  <script src="scripts/src/glightbox.min.js"></script>
  <script src="scripts/src/galery.js"></script>
  <script src="scripts/countdown.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      AOS.init({ duration: 300, once: true });

      const regenBtn = document.getElementById('regenerate-json');
      if (regenBtn) {
        regenBtn.addEventListener('click', () => {
          document.getElementById('admin-status').textContent = 'Mise à jour...';
          fetch('generate_medias.php')
            .then(resp => resp.json())
            .then(data => {
              if (data.status === 'success') {
                document.getElementById('admin-status').textContent = `Médias régénérés avec succès (${data.count})`;
                if (window.renderGallery) {
                  fetch('data/medias.json')
                    .then(res => res.json())
                    .then(data => window.renderGallery(data));
                }
              } else {
                document.getElementById('admin-status').textContent = 'Erreur lors de la régénération.';
              }
            })
            .catch(() => {
              document.getElementById('admin-status').textContent = 'Erreur réseau.';
            });
        });
      }
    });
  </script>

</body>
</html>