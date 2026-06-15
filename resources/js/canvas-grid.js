// Monochromatic Dot-Matrix Grid Background for Nothing Portfolio
class CanvasGrid {
    constructor() {
        this.canvas = document.getElementById('canvas-grid');
        if (!this.canvas) return;

        this.ctx = this.canvas.getContext('2d');
        this.dots = [];
        this.spacing = 32; // Distance between dots
        this.mouse = { x: null, y: null, radius: 100 };

        // Respect reduced motion
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReducedMotion) {
            this.canvas.style.display = 'none';
            return;
        }

        this.init();
        this.events();
        this.animate();
    }

    init() {
        this.resize();
    }

    resize() {
        this.width = this.canvas.width = window.innerWidth;
        this.height = this.canvas.height = window.innerHeight;
        this.cols = Math.ceil(this.width / this.spacing);
        this.rows = Math.ceil(this.height / this.spacing);
    }

    events() {
        window.addEventListener('resize', () => this.resize());
        window.addEventListener('mousemove', (e) => {
            this.mouse.x = e.clientX;
            this.mouse.y = e.clientY;
        });
        window.addEventListener('mouseleave', () => {
            this.mouse.x = null;
            this.mouse.y = null;
        });
    }

    animate() {
        this.ctx.clearRect(0, 0, this.width, this.height);

        // Determine current theme color for dots (subtle black in light theme, subtle white in dark)
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        const dotColor = isDark ? 255 : 0;

        for (let c = 0; c < this.cols; c++) {
            for (let r = 0; r < this.rows; r++) {
                const x = c * this.spacing + (this.spacing / 2);
                const y = r * this.spacing + (this.spacing / 2);

                let radius = 1;
                let opacity = 0.15;

                // Mouse interaction / hover effect
                if (this.mouse.x !== null && this.mouse.y !== null) {
                    const dx = this.mouse.x - x;
                    const dy = this.mouse.y - y;
                    const dist = Math.sqrt(dx * dx + dy * dy);

                    if (dist < this.mouse.radius) {
                        const factor = 1 - (dist / this.mouse.radius);
                        radius = 1 + factor * 2.5; // Grow dots close to mouse
                        opacity = 0.15 + factor * 0.45; // Brighten dots close to mouse
                    }
                }

                this.ctx.beginPath();
                this.ctx.arc(x, y, radius, 0, Math.PI * 2);
                this.ctx.fillStyle = `rgba(${dotColor}, ${dotColor}, ${dotColor}, ${opacity})`;
                this.ctx.fill();
            }
        }

        requestAnimationFrame(() => this.animate());
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new CanvasGrid();
});
