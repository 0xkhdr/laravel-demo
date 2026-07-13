@props(['repo'])

<div class="mb-8 p-6 bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
        <div>
            <h3 class="text-2xl font-bold text-gray-900">
                {{ $repo->name }}
            </h3>
            <p class="text-gray-600 mt-2">
                {{ $repo->description }}
            </p>
        </div>
        @if ($repo->language)
            <span class="inline-block text-sm font-semibold text-blue-600 bg-blue-100 px-3 py-1 rounded-full whitespace-nowrap">
                {{ $repo->language }}
            </span>
        @endif
    </div>

    <div class="flex flex-wrap gap-4 mb-4 text-gray-600 text-sm">
        @if ($repo->stars !== null)
            <span class="flex items-center gap-1">
                ⭐ {{ $repo->stars }} stars
            </span>
        @endif
        @if ($repo->forks !== null)
            <span class="flex items-center gap-1">
                🍴 {{ $repo->forks }} forks
            </span>
        @endif
    </div>

    <a href="{{ $repo->url }}" target="_blank" rel="noopener noreferrer" class="inline-block text-blue-600 hover:text-blue-800 font-semibold">
        View on GitHub →
    </a>
</div>
