// Performance Optimization: minify and defer loading of theme toggle
// Reduces Largest Contentful Paint by deferring non-critical script load

(function() {
  // ponytail: uses native localStorage instead of external library
  const THEME_KEY = 'site-theme';
  const DARK_THEME = 'dark';
  const LIGHT_THEME = 'light';

  function getInitialTheme() {
    // Check localStorage first for user preference
    const stored = localStorage.getItem(THEME_KEY);
    if (stored) return stored;

    // Check system preference
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    return prefersDark ? DARK_THEME : LIGHT_THEME;
  }

  function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem(THEME_KEY, theme);
  }

  function toggleTheme() {
    const current = document.documentElement.getAttribute('data-theme') || getInitialTheme();
    const next = current === DARK_THEME ? LIGHT_THEME : DARK_THEME;
    applyTheme(next);
  }

  // Initialize on load
  document.addEventListener('DOMContentLoaded', function() {
    applyTheme(getInitialTheme());

    // Attach toggle handler
    const toggleBtn = document.querySelector('[data-toggle-theme]');
    if (toggleBtn) {
      toggleBtn.addEventListener('click', toggleTheme);
    }
  });

  // Expose for external use
  window.toggleTheme = toggleTheme;
})();
