@extends('layouts.app')

@section('title', config('portfolio.owner.name').' · '.config('portfolio.owner.title'))

@section('content')
    <x-hero
        :eyebrow="config('portfolio.owner.title')"
        :title="config('portfolio.owner.name')"
        :description="config('portfolio.owner.tagline')"
        :cta-href="route('articles.index')"
        cta-label="Continue reading"
    />

    <section class="section section--dark">
        <div class="page">
            <x-section-header
                id="latest-articles"
                eyebrow="Writing"
                title="Latest articles"
                description="Recent thoughts on backend engineering, product delivery, and clean Laravel systems."
            />

            <div class="article-grid" aria-labelledby="latest-articles">
                @forelse ($articles as $article)
                    <x-article-card :article="$article" />
                @empty
                    <p>No articles yet.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
