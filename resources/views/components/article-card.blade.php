@props(['article'])

<article class="article-card reveal" data-reveal>
    <p class="article-card__meta">
        <time datetime="{{ $article->published_at?->toDateString() }}">{{ $article->published_at?->format('F j, Y') }}</time>
    </p>
    <h3 class="article-card__title">
        <a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
    </h3>
    <p class="article-card__excerpt">{{ $article->excerpt }}</p>
</article>
