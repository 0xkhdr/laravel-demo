<header class="site-header" id="top">
    <a class="brand" href="#top" aria-label="{{ $portfolio['brand']['name'] }}">
        <span class="brand__mark">N</span>
        <span class="brand__copy">
            <strong>{{ $portfolio['brand']['name'] }}</strong>
            <span>{{ $portfolio['brand']['label'] }}</span>
        </span>
    </a>

    <nav class="site-nav" aria-label="Primary">
        @foreach ($portfolio['navigation'] as $item)
            <x-nav-link :href="$item['href']">{{ $item['label'] }}</x-nav-link>
        @endforeach
    </nav>
</header>
