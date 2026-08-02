<nav class="fixed top-0 left-0 right-0 z-50 backdrop-blur-md bg-white bg-opacity-80 border-b border-black border-opacity-10 h-16 flex items-center">
  <div class="container max-w-6xl mx-auto px-6 w-full flex items-center justify-between">
    <div class="font-display font-bold text-lg tracking-wider">
      DEV.KHEDR
    </div>

    <div class="flex items-center gap-8">
      <div class="hidden md:flex gap-8">
        <a href="#about" class="text-xs uppercase tracking-wider transition-colors duration-200 hover:text-accent">About</a>
        <a href="#experience" class="text-xs uppercase tracking-wider transition-colors duration-200 hover:text-accent">Experience</a>
        <a href="#projects" class="text-xs uppercase tracking-wider transition-colors duration-200 hover:text-accent">Projects</a>
        <a href="#skills" class="text-xs uppercase tracking-wider transition-colors duration-200 hover:text-accent">Skills</a>
      </div>

      <button id="theme-toggle" class="text-xs uppercase tracking-wider transition-colors duration-200 hover:text-accent focus-ring" aria-label="Toggle dark mode">
        ☀️
      </button>
    </div>
  </div>
</nav>

<script>
  // Dark mode toggle icon update
  const themeToggle = document.getElementById('theme-toggle');
  const htmlElement = document.documentElement;

  const updateToggleIcon = () => {
    const theme = htmlElement.getAttribute('data-theme') || 'light';
    themeToggle.textContent = theme === 'dark' ? '🌙' : '☀️';
  };

  updateToggleIcon();

  // Observer for theme changes
  const observer = new MutationObserver(updateToggleIcon);
  observer.observe(htmlElement, { attributes: true, attributeFilter: ['data-theme'] });
</script>

<style>
  [data-theme="dark"] nav {
    @apply bg-black bg-opacity-90 border-white border-opacity-10;
  }
</style>
