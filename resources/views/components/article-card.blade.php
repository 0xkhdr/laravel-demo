@props(['article'])

<article class="mb-8 p-6 bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
    <h3 class="text-2xl font-bold text-gray-900 mb-2">
        {{ $article->title }}
    </h3>
    <p class="text-gray-600 mb-4 line-clamp-3">
        {{ Str::limit($article->content, 150) }}
    </p>
    <a href="/articles/{{ $article->id }}" class="inline-block text-blue-600 hover:text-blue-800 font-semibold">
        Read Article →
    </a>
</article>
