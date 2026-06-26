<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Landing</title>
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
    @vite(['resources/css/design-system.css', 'resources/js/nav.js', 'resources/js/menu.js'])
</head>
<body>
    <header>
        <!-- Navigation will go here -->
    </header>

    <nav class="navbar" id="navbar">
        <div class="navbar-container">
            <div class="navbar-logo">Portfolio</div>
            <div class="navbar-links" id="navbar-links">
                <a href="#projects" class="navbar-link">Projects</a>
                <a href="#articles" class="navbar-link">Articles</a>
                <a href="#packages" class="navbar-link">Packages</a>
                <a href="#cta" class="navbar-link">Contact</a>
            </div>
            <button class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <div class="mobile-menu" id="mobile-menu">
        <div class="mobile-menu-header">
            <h2>Menu</h2>
            <button class="close-button" id="close-menu">×</button>
        </div>
        <div class="mobile-menu-links">
            <a href="#projects" class="mobile-menu-link">Projects</a>
            <a href="#articles" class="mobile-menu-link">Articles</a>
            <a href="#packages" class="mobile-menu-link">Packages</a>
            <a href="#cta" class="mobile-menu-link">Contact</a>
        </div>
    </div>

    <main>
        <section id="hero" class="hero">
            <div class="hero-content">
                <h1 class="text-hero">Your Portfolio Showcase</h1>
                <p class="text-body-large">Create stunning landing pages with Nothing.tech design system</p>
                <a href="#projects" class="btn btn-primary" aria-label="Go to featured projects section">Explore Projects</a>
            </div>
            <div class="scroll-indicator">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>
        </section>

        <section id="projects" class="projects-section">
            <div class="section-container">
                <h2 class="section-title">Featured Projects</h2>
                <div class="projects-grid">
                    @forelse($featuredProjects as $project)
                        <article class="project-card">
                            <div class="project-image">
                                <img src="{{ $project->image ?? 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22%3E%3Crect fill=%22%23f3f4f6%22 width=%22400%22 height=%22300%22/%3E%3C/svg%3E' }}"
                                     alt="Screenshot of {{ $project->title ?? 'Featured Project' }}" aspect-ratio="4/3">
                            </div>
                            <div class="project-content">
                                <h4 class="project-title">{{ $project->title ?? 'Project Title' }}</h4>
                                <p class="project-description">{{ $project->description ?? 'Project description' }}</p>
                                <a href="#" class="project-link">View Project →</a>
                            </div>
                        </article>
                    @empty
                        <p>No projects yet</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="articles" class="articles-section">
            <div class="section-container">
                <h2 class="section-title">Recent Articles</h2>
                <div class="articles-grid">
                    @forelse($recentArticles as $article)
                        <article class="article-card">
                            <h5 class="article-title">{{ $article->title ?? 'Article Title' }}</h5>
                            <p class="article-date">{{ $article->published_at ?? date('M d, Y') }}</p>
                            <p class="article-excerpt">{{ $article->excerpt ?? 'Article excerpt goes here' }}</p>
                        </article>
                    @empty
                        <p>No articles yet</p>
                    @endforelse
                </div>
                <div class="articles-footer">
                    <a href="#" class="view-all-link">View All Articles →</a>
                </div>
            </div>
        </section>

        <section id="packages" class="packages-section">
            <div class="section-container">
                <h2 class="section-title">Featured Packages</h2>
                <div class="packages-grid">
                    @forelse($featuredPackages as $package)
                        <div class="package-card">
                            <div class="package-icon">
                                <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor">
                                    <rect width="48" height="48" rx="4" fill="var(--color-gray-200)"/>
                                </svg>
                            </div>
                            <h4 class="package-title">{{ $package->name ?? 'Package' }}</h4>
                            <p class="package-description">{{ $package->description ?? 'Package description' }}</p>
                        </div>
                    @empty
                        <p>No packages yet</p>
                    @endforelse
                </div>
                <div class="packages-footer">
                    <a href="#" class="btn btn-outline">Explore All Packages</a>
                </div>
            </div>
        </section>

        <section id="cta" class="cta-section cta-black">
            <div class="section-container">
                <h2 class="section-title">Ready to Get Started?</h2>
                <p class="cta-text">Build amazing things with our design system</p>
                <div class="cta-buttons">
                    <a href="#" class="btn btn-primary">Get Started</a>
                    <a href="#" class="btn btn-outline">Learn More</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="section-container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Links</h4>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Projects</a></li>
                        <li><a href="#">Articles</a></li>
                        <li><a href="#">About</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Social</h4>
                    <ul class="social-links">
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">GitHub</a></li>
                        <li><a href="#">LinkedIn</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-copyright">
                <p>&copy; 2026 Portfolio. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
