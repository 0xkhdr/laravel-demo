@props(['article' => null, 'method' => 'POST', 'action' => null])

<div class="bg-white p-8 rounded-lg shadow max-w-2xl mx-auto">
    <form method="POST" action="{{ $action }}">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        <!-- Title -->
        <div class="mb-6">
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                Title <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title', $article?->title ?? '') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                placeholder="Article title (min. 3 characters)"
                required
                minlength="3"
            />
            @error('title')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Content -->
        <div class="mb-6">
            <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">
                Content <span class="text-red-500">*</span>
            </label>
            <textarea
                id="content"
                name="content"
                rows="10"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror"
                placeholder="Article content (min. 10 characters)"
                required
                minlength="10"
            >{{ old('content', $article?->content ?? '') }}</textarea>
            @error('content')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Publish Toggle -->
        <div class="mb-6 flex items-center">
            <input
                type="checkbox"
                id="publish"
                name="publish"
                value="1"
                @checked(old('publish', $article?->published_at ? true : false))
                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
            <label for="publish" class="ml-3 text-sm font-medium text-gray-700">
                Publish immediately
            </label>
        </div>

        <!-- Buttons -->
        <div class="flex gap-4 pt-4">
            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition-colors"
            >
                Save Article
            </button>
            <a
                href="{{ route('articles.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-lg transition-colors"
            >
                Cancel
            </a>
        </div>
    </form>
</div>
