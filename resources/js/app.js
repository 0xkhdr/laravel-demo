import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.data('portfolioUi', () => ({
    menuOpen: false,
    theme: matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light',
    init() {
        try { this.theme = localStorage.getItem('portfolio-theme') || this.theme; } catch {}
        document.documentElement.dataset.theme = this.theme;
    },
    toggleTheme() {
        this.theme = this.theme === 'dark' ? 'light' : 'dark';
        document.documentElement.dataset.theme = this.theme;
        try { localStorage.setItem('portfolio-theme', this.theme); } catch {}
    },
}));
Alpine.start();
