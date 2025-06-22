document.addEventListener('DOMContentLoaded', function() {
  const el = document.getElementById('countdown');
  if (!el) return;
  const eventDate = new Date('2025-12-20T14:00:00').getTime();
  let interval;
  function update() {
    const now = Date.now();
    const diff = eventDate - now;
    if (diff <= 0) {
      el.textContent = "C'est le grand jour !";
      clearInterval(interval);
      return;
    }
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((diff % (1000 * 60)) / 1000);
    el.textContent = `${days}j ${hours}h ${minutes}m ${seconds}s`;
    el.classList.remove('countdown-animate');
    void el.offsetWidth; // restart animation
    el.classList.add('countdown-animate');
  }
  update();
  interval = setInterval(update, 1000);
});

