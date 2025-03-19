document.addEventListener('DOMContentLoaded', function () {
  const tooltips = document.querySelectorAll('.tooltip');

  tooltips.forEach(tooltip => {
    const button = tooltip.querySelector('button');
    const tooltipText = tooltip.querySelector('.tooltiptext');

    // Lorsque la souris entre sur le bouton
    button.addEventListener('mouseenter', () => {
      const rect = button.getBoundingClientRect(); // Dimensions et position du bouton
      const tooltipRect = tooltipText.getBoundingClientRect(); // Dimensions du tooltip

      // Calculer la position au-dessus du bouton
      let top = rect.top - tooltipRect.height - 10; // Position au-dessus avec un espace de 10px
      let left = rect.left + (rect.width / 2) - (tooltipRect.width / 2); // Centrer horizontalement

      // Ajustements pour éviter les débordements
      if (top < 0) { 
        // Si pas assez d'espace en haut, placer en dessous
        top = rect.bottom + 10; 
      }
      if (left < 0) { 
        // Si déborde à gauche, aligner sur le bord gauche
        left = 10; // Ajouter un petit espace de sécurité
      }
      if (left + tooltipRect.width > window.innerWidth) { 
        // Si déborde à droite, aligner sur le bord droit
        left = window.innerWidth - tooltipRect.width - 10; // Ajouter un petit espace de sécurité
      }

      // Appliquer les styles calculés au tooltip
      tooltipText.style.top = `${top}px`;
      tooltipText.style.left = `${left}px`;
    });

    // Réinitialiser les styles lorsque la souris quitte le bouton
    button.addEventListener('mouseleave', () => {
      tooltipText.style.top = '';
      tooltipText.style.left = '';
    });
  });
});
