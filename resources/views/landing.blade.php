<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <a href="/" class="text-xl font-bold text-gray-900">Portfolio</a>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="bg-gradient-to-b from-blue-50 to-white py-12 sm:py-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-4 sm:mb-6">
                    Welcome to My Portfolio
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto">
                    Exploring ideas, building projects, and sharing knowledge.
                </p>
            </div>
        </section>

        <!-- Articles Section -->
        <section class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-8 sm:mb-12">
                    Latest Articles
                </h2>
                @forelse ($articles as $article)
                    <x-article-card :article="$article" />
                @empty
                    <p class="text-gray-600 text-center py-8">No articles published yet.</p>
                @endforelse
            </div>
        </section>

        <!-- Repos Section -->
        <section class="bg-gray-100 py-12 sm:py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-8 sm:mb-12">
                    Featured Repositories
                </h2>
                @forelse ($repos as $repo)
                    <x-repo-card :repo="$repo" />
                @empty
                    <p class="text-gray-600 text-center py-8">No repositories found.</p>
                @endforelse
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto text-center">
                <h3 class="text-2xl font-bold mb-4">Get in Touch</h3>
                <p class="text-gray-300 mb-6 max-w-2xl mx-auto">
                    Interested in collaboration or have questions? Feel free to reach out.
                </p>
                <a href="mailto:contact@example.com" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                    Send me an email
                </a>
            </div>
        </footer>
    </main>
</body>
</html>
