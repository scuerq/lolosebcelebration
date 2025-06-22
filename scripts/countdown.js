// Countdown timer shared across pages
(function() {
  document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('countdown');
    if (!el) return;

    const eventDate = new Date('2025-12-20T14:00:00').getTime();
    let interval;

    function pad(num) {
      return String(num).padStart(2, '0');
    }

    function update() {
      const now = Date.now();
      let diff = eventDate - now;

      if (diff <= 0) {
        el.textContent = "C'est le grand jour !";
        clearInterval(interval);
        return;
      }

      const days = Math.floor(diff / (1000 * 60 * 60 * 24));
      diff -= days * 1000 * 60 * 60 * 24;
      const hours = Math.floor(diff / (1000 * 60 * 60));
      diff -= hours * 1000 * 60 * 60;
      const minutes = Math.floor(diff / (1000 * 60));
      diff -= minutes * 1000 * 60;
      const seconds = Math.floor(diff / 1000);

      el.innerHTML =
        '<span class="countdown-number">' + pad(days) + '</span>j : ' +
        '<span class="countdown-number">' + pad(hours) + '</span>h : ' +
        '<span class="countdown-number">' + pad(minutes) + '</span>m : ' +
        '<span class="countdown-number">' + pad(seconds) + '</span>s';
    }

    interval = setInterval(update, 1000);
    update();
  });
})();
