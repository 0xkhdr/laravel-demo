const motionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
const revealElements = Array.from(document.querySelectorAll('[data-reveal]'));

const revealAll = () => {
    revealElements.forEach((element) => element.classList.add('visible'));
};

const observeReveals = () => {
    if (motionQuery.matches || !('IntersectionObserver' in window)) {
        revealAll();
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.15,
            rootMargin: '0px 0px -10% 0px',
        }
    );

    revealElements.forEach((element) => observer.observe(element));
};

const syncMotionState = () => {
    document.documentElement.dataset.motion = motionQuery.matches ? 'reduced' : 'full';
};

syncMotionState();
observeReveals();

if (typeof motionQuery.addEventListener === 'function') {
    motionQuery.addEventListener('change', () => {
        syncMotionState();
        revealAll();
    });
}
