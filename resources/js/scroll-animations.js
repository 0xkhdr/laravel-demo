// Performance Optimization: minify and defer scroll animation scripts
// IntersectionObserver for efficient Largest Contentful Paint and animation triggering
// Usage: add class 'reveal' to elements that should animate on scroll

(function() {
  // ponytail: check once for prefers-reduced-motion, global ref avoids repeated queries
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // ponytail: single IntersectionObserver instance with throttled callback, not per-element
  const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: [0.1, 0.5] // Fire at 10% and 50% visibility
  };

  const revealElements = new Set();
  let pendingRender = false;

  function handleIntersection(entries) {
    entries.forEach(entry => {
      if (entry.isIntersecting && !entry.target.classList.contains('visible')) {
        revealElements.add(entry.target);
        if (!pendingRender) {
          pendingRender = true;
          // Batch DOM updates using requestAnimationFrame
          requestAnimationFrame(() => {
            revealElements.forEach(el => {
              if (prefersReducedMotion) {
                // Skip animation for users who prefer reduced motion
                el.classList.add('visible');
              } else {
                el.classList.add('visible');
              }
            });
            revealElements.clear();
            pendingRender = false;
          });
        }
      }
    });
  }

  const observer = new IntersectionObserver(handleIntersection, observerOptions);

  document.addEventListener('DOMContentLoaded', function() {
    const elementsToReveal = document.querySelectorAll('.reveal');
    elementsToReveal.forEach(el => observer.observe(el));
  });

  // Cleanup on unload
  window.addEventListener('beforeunload', () => observer.disconnect());
})();
