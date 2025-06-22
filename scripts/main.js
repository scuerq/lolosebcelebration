// main.js file for the wedding site of Lolo & Seb
document.addEventListener('DOMContentLoaded', function() {
    const testimonyButton = document.getElementById('testimony-button');
    const participationButton = document.getElementById('participation-button');

    testimonyButton.addEventListener('click', function() {
        alert('Merci pour votre témoignage !');
        // Here you can add functionality to collect testimonials
    });

    participationButton.addEventListener('click', function() {
        alert('Merci de confirmer votre participation !');
        // Here you can add functionality to handle participation
    });
});
