@extends('layouts.app')

@section('title', $article->title.' · '.config('app.name'))

@section('content')
    <section class="section">
        <div class="page">
            <article class="article-page reveal" data-reveal aria-labelledby="article-heading">
                <header>
                    <p class="article-page__meta">Article</p>
                    <h1 id="article-heading" class="article-page__title">{{ $article->title }}</h1>
                    <time datetime="{{ $article->published_at?->toDateString() }}">
                        {{ $article->published_at?->format('F j, Y') }}
                    </time>
                </header>

                <div class="article-page__body">
                    <p class="article-page__summary">{{ $article->excerpt }}</p>
                    <div>{!! nl2br(e($article->body)) !!}</div>
                </div>
            </article>
        </div>
    </section>
@endsection
