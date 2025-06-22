document.addEventListener('DOMContentLoaded', () => {
  const gallery = document.getElementById('gallery');
  let medias = [];

  // Charger les médias depuis medias.json
  fetch('data/medias.json')
    .then(res => res.json())
    .then(data => {
      medias = data;
      window.renderGallery(medias); // accessible globalement
    });

  // Filtres
  const filterButtons = document.querySelectorAll('.filter-btn');
  const subfilter = document.getElementById('subfilter');

  filterButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      filterButtons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const category = btn.getAttribute('data-filter');
      const type = subfilter.value;
      applyFilters(category, type);
    });
  });

  subfilter.addEventListener('change', () => {
    const activeBtn = document.querySelector('.filter-btn.active');
    const category = activeBtn ? activeBtn.getAttribute('data-filter') : 'all';
    const type = subfilter.value;
    applyFilters(category, type);
  });

  function applyFilters(category, type) {
    const filtered = medias.filter(m =>
      (category === 'all' || m.category === category) &&
      (type === 'all' || m.type === type || m.year.toString() === type)
    );
    window.renderGallery(filtered);
  }

  window.renderGallery = function(items) {
    gallery.innerHTML = '';
    if (items.length === 0) {
      gallery.innerHTML = '<p class="text-center text-muted">Aucun média trouvé.</p>';
      return;
    }

    items.forEach(item => {
      const col = document.createElement('div');
      col.className = 'col-6 col-md-4 col-lg-3';

      let content = '';
      if (item.type === 'photo') {
        content = `
          <a href="${item.src}" class="glightbox" data-gallery="media-gallery" data-title="${item.title}">
            <img src="${item.src}" alt="${item.title}" class="img-fluid media-thumb shadow-sm rounded" />
          </a>
        `;
      } else if (item.type === 'video') {
        content = `
          <video controls class="media-thumb shadow-sm rounded w-100" preload="metadata">
            <source src="${item.src}" type="video/mp4">
            Votre navigateur ne prend pas en charge la vidéo.
          </video>
        `;
      }

      col.innerHTML = `
        <div class="media-card">
          ${content}
          <p class="mt-2 mb-0 text-muted small text-center">${item.title}</p>
        </div>
      `;
      gallery.appendChild(col);
    });

    if (window.glightboxGallery) {
      window.glightboxGallery.destroy();
    }
    
    window.glightboxGallery = GLightbox({ selector: '.glightbox' });
    
    setTimeout(() => {
      if (window.glightboxGallery) {
        console.log('GLightbox actif');
      } else {
        console.warn('GLightbox non initialisé');
      }
    }, 500);
  };

  // Admin (triple A)
  let adminKeySequence = [];
  document.addEventListener('keydown', (e) => {
    adminKeySequence.push(e.key.toLowerCase());
    if (adminKeySequence.slice(-3).join('') === 'aaa') {
      document.getElementById('admin-tools').style.display = 'block';
    }
  });

  // Bouton admin : génération JSON
  const regenBtn = document.getElementById('regenerate-json');
  const adminStatus = document.getElementById('admin-status');

  regenBtn?.addEventListener('click', () => {
    adminStatus.textContent = 'Mise à jour...';
    fetch('../generate_medias.php?key=123monsecret')
      .then(res => res.json())
      .then(data => {
        adminStatus.textContent = `✅ ${data.count || 0} médias mis à jour.`;
        medias = data.items || data;
        window.renderGallery(medias);
      })
      .catch(err => {
        adminStatus.textContent = '❌ Erreur lors de la mise à jour.';
        console.error(err);
      });
  });
});
