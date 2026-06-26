document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('navbar');

    function handleScroll() {
        if (window.scrollY > 100) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }

        // Detect background color of current section and adjust navbar text
        updateNavbarColor();
    }

    function updateNavbarColor() {
        const sections = document.querySelectorAll('section');
        const scrollPosition = window.scrollY + 80; // Offset for navbar height

        let currentBg = 'light';

        sections.forEach(section => {
            const rect = section.getBoundingClientRect();
            if (rect.top <= 80 && rect.bottom > 80) {
                const bgColor = window.getComputedStyle(section).backgroundColor;
                // Check if background is dark
                if (bgColor.includes('0, 0, 0') || bgColor === 'rgb(0, 0, 0)') {
                    currentBg = 'dark';
                } else {
                    currentBg = 'light';
                }
            }
        });

        navbar.classList.remove('light-bg', 'dark-bg');
        navbar.classList.add(currentBg + '-bg');
    }

    window.addEventListener('scroll', handleScroll, { passive: true });

    // Initialize on load
    handleScroll();
});
