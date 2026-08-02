// Scroll reveal animation using Intersection Observer
const revealElements = () => {
  const reveals = document.querySelectorAll('.reveal');

  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  reveals.forEach(reveal => observer.observe(reveal));
};

// Initialize on load
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', revealElements);
} else {
  revealElements();
}

// Hover effects on cards
const cardHovers = () => {
  const cards = document.querySelectorAll('.card');

  cards.forEach(card => {
    card.addEventListener('mouseenter', () => {
      // CSS handles the animation
    });
  });
};

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', cardHovers);
} else {
  cardHovers();
}
