<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Articles Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Articles Dashboard</h1>
            <div class="flex gap-4">
                <a href="{{ route('articles.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    New Article
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-600 hover:text-gray-900">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8">
        @if ($articles->count() > 0)
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-left">Title</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Status</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Created</th>
                            <th class="border border-gray-300 px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $article)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2 font-semibold">{{ $article->title }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                        @if ($article->published_at) bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">
                                        @if ($article->published_at)
                                            Published
                                        @else
                                            Draft
                                        @endif
                                    </span>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">{{ $article->created_at->format('M d, Y') }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-right flex gap-2 justify-end">
                                    <a href="{{ route('articles.edit', $article) }}" class="text-blue-600 hover:text-blue-900 font-semibold">Edit</a>
                                    <form method="POST" action="{{ route('articles.destroy', $article) }}" class="inline"
                                          onsubmit="return confirm('Delete this article?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden space-y-4">
                @foreach ($articles as $article)
                    <div class="bg-white p-4 rounded-lg shadow">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-semibold">{{ $article->title }}</h3>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                @if ($article->published_at) bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">
                                @if ($article->published_at)
                                    Published
                                @else
                                    Draft
                                @endif
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">{{ $article->created_at->format('M d, Y') }}</p>
                        <div class="flex gap-2">
                            <a href="{{ route('articles.edit', $article) }}" class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">Edit</a>
                            <form method="POST" action="{{ route('articles.destroy', $article) }}" class="flex-1"
                                  onsubmit="return confirm('Delete this article?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $articles->links() }}
            </div>
        @else
            <div class="bg-white p-8 rounded-lg shadow text-center">
                <p class="text-gray-600 mb-4">No articles yet. Create your first article to get started!</p>
                <a href="{{ route('articles.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg inline-block">
                    Create Article
                </a>
            </div>
        @endif
    </main>
</body>
</html>
