@extends('layouts.app')

@section('title', 'Articles · '.config('app.name'))

@section('content')
    <section class="section">
        <div class="page">
            <x-section-header
                id="articles"
                eyebrow="Articles"
                title="Articles"
                description="Published notes, ordered from newest to oldest."
            />

            <div class="article-grid" aria-labelledby="articles">
                @forelse ($articles as $article)
                    <x-article-card :article="$article" />
                @empty
                    <p>No published articles yet.</p>
                @endforelse
            </div>

            {{ $articles->links() }}
        </div>
    </section>
@endsection
