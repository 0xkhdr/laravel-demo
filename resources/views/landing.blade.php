<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Unified portfolio shell with projects, articles, and packages rendered on a shared design system.">
    <title>{{ config('app.name', 'Laravel Demo') }}</title>
    @vite(['resources/css/design-system.css', 'resources/js/nav.js', 'resources/js/menu.js'])
</head>
@php
    $placeholderImage = 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22800%22 height=%22600%22 viewBox=%220 0 800 600%22%3E%3Crect width=%22800%22 height=%22600%22 fill=%22%23f3f4f6%22/%3E%3Cpath d=%22M0 0L800 600%22 stroke=%22%23e5e7eb%22 stroke-width=%2232%22/%3E%3Cpath d=%22M800 0L0 600%22 stroke=%22%23e5e7eb%22 stroke-width=%2232%22/%3E%3C/svg%3E';
@endphp
<body class="page-shell">
    <header class="navbar" id="navbar">
        <div class="navbar-inner">
            <a href="#overview" class="navbar-logo">{{ config('app.name', 'Portfolio') }}</a>

            <nav class="navbar-links" aria-label="Primary">
                <a href="#overview" class="navbar-link">Overview</a>
                <a href="#projects" class="navbar-link">Projects</a>
                <a href="#articles" class="navbar-link">Articles</a>
                <a href="#packages" class="navbar-link">Packages</a>
                <a href="#contact" class="navbar-link">Contact</a>
            </nav>

            <button class="hamburger" id="hamburger" type="button" aria-controls="mobile-menu" aria-expanded="false" aria-label="Open menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <div class="mobile-menu" id="mobile-menu" aria-hidden="true">
        <button class="mobile-menu-close" id="close-menu" type="button" aria-label="Close menu">&times;</button>
        <a href="#overview" class="mobile-menu-link">Overview</a>
        <a href="#projects" class="mobile-menu-link">Projects</a>
        <a href="#articles" class="mobile-menu-link">Articles</a>
        <a href="#packages" class="mobile-menu-link">Packages</a>
        <a href="#contact" class="mobile-menu-link">Contact</a>
    </div>

    <main>
        <section id="overview" class="section hero-shell">
            <div class="hero-grid">
                <div class="hero-copy">
                    <p class="eyebrow">Unified UI system</p>
                    <h1 class="hero-title">One visual language for the portfolio shell.</h1>
                    <p class="hero-description">
                        A compact, token-driven interface for projects, writing, and packages.
                        The page keeps one rhythm across layout, cards, navigation, and motion.
                    </p>

                    <div class="cta-buttons">
                        <a href="#projects" class="btn btn-primary">Explore work</a>
                        <a href="{{ route('profile.show') }}" class="btn btn-outline">Open profile</a>
                    </div>

                    <dl class="stats-grid" aria-label="Summary metrics">
                        <div class="stat-card">
                            <dt>Featured projects</dt>
                            <dd>{{ is_countable($featuredProjects) ? count($featuredProjects) : 0 }}</dd>
                        </div>
                        <div class="stat-card">
                            <dt>Recent articles</dt>
                            <dd>{{ is_countable($recentArticles) ? count($recentArticles) : 0 }}</dd>
                        </div>
                        <div class="stat-card">
                            <dt>Shared system</dt>
                            <dd>1 stack</dd>
                        </div>
                    </dl>
                </div>

                <aside class="hero-aside" aria-label="Design system highlights">
                    <div class="hero-preview">
                        <p class="hero-preview-label">System notes</p>
                        <ul class="hero-notes">
                            <li>Monochrome shell with red accent.</li>
                            <li>Cards share the same spacing rhythm.</li>
                            <li>Mobile menu uses the same navigation links.</li>
                            <li>Reduced-motion users keep the full layout.</li>
                        </ul>
                    </div>
                </aside>
            </div>
        </section>

        <section id="projects" class="section section-block">
            <x-section-heading
                eyebrow="Featured work"
                title="Projects share the same card, spacing, and button language."
                description="The grid below keeps project content readable while the chrome stays consistent with the rest of the page."
            />

            <div class="content-grid content-grid--projects">
                @forelse($featuredProjects as $project)
                    <article class="content-card content-card--project">
                        <div class="content-card__media">
                            <img
                                src="{{ $project->image ?? $placeholderImage }}"
                                alt="Screenshot of {{ $project->title ?? 'Featured Project' }}"
                                class="content-card__image"
                                loading="lazy"
                                decoding="async"
                            >
                        </div>
                        <div class="content-card__body">
                            <p class="content-card__eyebrow">Project</p>
                            <h3 class="content-card__title">{{ $project->title ?? 'Project Title' }}</h3>
                            <p class="content-card__description">{{ $project->description ?? 'Project description' }}</p>
                            <a
                                href="{{ data_get($project, 'url') ?: data_get($project, 'link') ?: route('profile.show') }}"
                                class="content-card__link"
                            >
                                View project
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="empty-state">
                        <p class="empty-state__title">No projects yet.</p>
                        <p class="empty-state__copy">Add featured projects to populate this section.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <section id="articles" class="section section-block">
            <x-section-heading
                eyebrow="Writing"
                title="Articles use the same surface and hierarchy as the project cards."
                description="Short metadata, crisp titles, and a single action keep the article list aligned with the rest of the shell."
            />

            <div class="content-grid content-grid--articles">
                @forelse($recentArticles as $article)
                    <article class="content-card content-card--article">
                        <div class="content-card__body">
                            <p class="content-card__eyebrow">
                                {{ $article->published_at ? \Illuminate\Support\Carbon::parse($article->published_at)->format('M d, Y') : 'Recent article' }}
                            </p>
                            <h3 class="content-card__title">{{ $article->title ?? 'Article Title' }}</h3>
                            <p class="content-card__description">{{ $article->excerpt ?? 'Article excerpt goes here' }}</p>
                            <a href="{{ data_get($article, 'url') ?: route('profile.show') }}" class="content-card__link">
                                Read article
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="empty-state">
                        <p class="empty-state__title">No articles yet.</p>
                        <p class="empty-state__copy">Publish a post to surface it here.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <section id="packages" class="section section-block">
            <x-section-heading
                eyebrow="Packages"
                title="Package cards stay visually aligned with the rest of the content system."
                description="Icons, titles, and descriptions use the same spacing and type scale as the other sections."
            />

            <div class="content-grid content-grid--packages">
                @forelse($featuredPackages as $package)
                    <article class="content-card content-card--package">
                        <div class="content-card__badge" aria-hidden="true">
                            <span></span>
                        </div>
                        <div class="content-card__body">
                            <p class="content-card__eyebrow">Package</p>
                            <h3 class="content-card__title">{{ $package->name ?? 'Package' }}</h3>
                            <p class="content-card__description">{{ $package->description ?? 'Package description' }}</p>
                            <a href="{{ data_get($package, 'url') ?: route('profile.show') }}" class="content-card__link">
                                Explore package
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="empty-state">
                        <p class="empty-state__title">No packages yet.</p>
                        <p class="empty-state__copy">Seed the catalog to fill this grid.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <section id="contact" class="section section-block">
            <div class="cta-panel">
                <div>
                    <p class="eyebrow">Contact</p>
                    <h2 class="cta-title">Need the same system across more views?</h2>
                    <p class="cta-copy">
                        The shell is now unified around one token set, one card language, and one navigation pattern.
                    </p>
                </div>
                <div class="cta-buttons">
                    <a href="{{ route('profile.show') }}" class="btn btn-primary">Open profile</a>
                    <a href="#overview" class="btn btn-outline">Back to top</a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
