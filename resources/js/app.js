import './canvas-grid.js';

document.addEventListener('DOMContentLoaded', () => {
    // ----------------------------------------------------------------------
    // 1. Theme Toggle Configuration
    // ----------------------------------------------------------------------
    const themeToggleBtn = document.getElementById('theme-toggle');
    
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('portfolio-theme', newTheme);
        });
    }

    // ----------------------------------------------------------------------
    // 2. Scroll Reveal Animations (IntersectionObserver)
    // ----------------------------------------------------------------------
    const revealElements = document.querySelectorAll('.reveal');
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion) {
        // Accessibility: Immediately reveal all sections, skip animations
        revealElements.forEach(el => el.classList.add('visible'));
    } else {
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.15
        };

        const observer = new IntersectionObserver((entries, self) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    self.unobserve(entry.target); // Trigger only once
                }
            });
        }, observerOptions);

        revealElements.forEach(el => observer.observe(el));
    }

    // ----------------------------------------------------------------------
    // 3. Smooth Anchored Scrolling for links
    // ----------------------------------------------------------------------
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: prefersReducedMotion ? 'auto' : 'smooth'
                });
            }
        });
    });
});
