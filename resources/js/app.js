// Dark mode toggle
const themeToggle = document.getElementById('theme-toggle');
const htmlElement = document.documentElement;

// Initialize theme from localStorage or system preference
const initTheme = () => {
  const stored = localStorage.getItem('theme');
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const theme = stored || (prefersDark ? 'dark' : 'light');

  htmlElement.setAttribute('data-theme', theme);
};

initTheme();

// Theme toggle handler
if (themeToggle) {
  themeToggle.addEventListener('click', () => {
    const current = htmlElement.getAttribute('data-theme') || 'light';
    const next = current === 'dark' ? 'light' : 'dark';

    htmlElement.setAttribute('data-theme', next);
    localStorage.setItem('theme', next);
  });
}
