@props([
    'active' => null,
])

<nav class="nav" data-nav>
    <div class="nav__container">
        <!-- Logo -->
        <div class="nav__logo">
            <a href="/" class="nav__brand">Nothing</a>
        </div>

        <!-- Desktop Navigation Links -->
        <div class="nav__links nav__links--desktop">
            <x-nav-link href="/#about" class="nav__link {{ $active === 'about' ? 'nav__link--active' : '' }}">
                About
            </x-nav-link>
            <x-nav-link href="/#projects" class="nav__link {{ $active === 'projects' ? 'nav__link--active' : '' }}">
                Projects
            </x-nav-link>
            <x-nav-link href="/#contact" class="nav__link {{ $active === 'contact' ? 'nav__link--active' : '' }}">
                Contact
            </x-nav-link>
        </div>

        <!-- Mobile Menu Button & Theme Toggle -->
        <div class="nav__actions">
            <button class="nav__theme-toggle" id="theme-toggle" aria-label="Toggle dark mode">
                <span class="nav__theme-icon" aria-hidden="true">☀️</span>
            </button>
            <button class="nav__menu-toggle" id="mobile-menu" aria-label="Toggle mobile menu" aria-expanded="false">
                <span class="nav__hamburger">
                    <span class="nav__hamburger-line"></span>
                    <span class="nav__hamburger-line"></span>
                    <span class="nav__hamburger-line"></span>
                </span>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Links -->
    <div class="nav__links nav__links--mobile" id="mobile-nav" aria-hidden="true">
        <x-nav-link href="/#about" class="nav__link nav__link--mobile {{ $active === 'about' ? 'nav__link--active' : '' }}">
            About
        </x-nav-link>
        <x-nav-link href="/#projects" class="nav__link nav__link--mobile {{ $active === 'projects' ? 'nav__link--active' : '' }}">
            Projects
        </x-nav-link>
        <x-nav-link href="/#contact" class="nav__link nav__link--mobile {{ $active === 'contact' ? 'nav__link--active' : '' }}">
            Contact
        </x-nav-link>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuBtn = document.getElementById('mobile-menu');
        const mobileNav = document.getElementById('mobile-nav');
        const themeToggle = document.getElementById('theme-toggle');
        const nav = document.querySelector('[data-nav]');

        // Mobile menu toggle
        if (mobileMenuBtn && mobileNav) {
            mobileMenuBtn.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !isExpanded);
                mobileNav.setAttribute('aria-hidden', isExpanded);
                mobileNav.classList.toggle('nav__links--mobile-open');
            });
        }

        // Scroll effect for backdrop-filter blur(20px) and rgba(255,255,255,0.8)
        window.addEventListener('scroll', function() {
            if (window.scrollY > 0) {
                nav.classList.add('nav--scrolled');
            } else {
                nav.classList.remove('nav--scrolled');
            }
        });

        // Theme toggle
        if (themeToggle) {
            themeToggle.addEventListener('click', function() {
                const root = document.documentElement;
                const currentTheme = root.getAttribute('data-theme') || 'light';
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                root.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateThemeIcon(newTheme);
            });

            // Restore saved theme
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            updateThemeIcon(savedTheme);
        }

        function updateThemeIcon(theme) {
            const icon = document.querySelector('.nav__theme-icon');
            if (icon) {
                icon.textContent = theme === 'dark' ? '🌙' : '☀️';
            }
        }
    });
</script>
