<?php
  $base = isset($base) ? $base : '';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="<?= $base ?>index.php">Lolo &amp; Seb</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="<?= $base ?>index.php">Accueil</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $base ?>galerie.php">Galerie</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $base ?>pages/temoignage.php">Témoignage</a></li>
      </ul>
    </div>
  </div>
</nav>

<header class="hero" data-aos="fade-down" style="margin-top:56px;">
  <div class="hero-content">
    <img src="<?= $base ?>data/logo_header.png" alt="Lolo &amp; Seb" class="header-logo" loading="lazy">
    <h1>Lolo &amp; Seb</h1>
    <p>20&nbsp;Décembre&nbsp;2025 – Saint-Paul</p>
    <div class="countdown-box">
      <span id="countdown" class="countdown-text"></span>
    </div>
  </div>
</header>
