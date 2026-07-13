<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Edit Article</h1>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-gray-600 hover:text-gray-900">Logout</button>
            </form>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8">
        <x-article-form
            :article="$article"
            action="{{ route('articles.update', $article) }}"
            method="PUT"
        />
    </main>
</body>
</html>
