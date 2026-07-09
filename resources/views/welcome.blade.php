@extends('layouts.app')

@section('title', $portfolio['brand']['name'] . ' | ' . $portfolio['brand']['label'])
@section('description', $portfolio['brand']['tagline'])

@section('content')
    @include('sections.navigation', ['portfolio' => $portfolio])

    <main id="content" class="stack" tabindex="-1">
        @include('sections.hero', ['portfolio' => $portfolio])
        @include('sections.about', ['portfolio' => $portfolio])
        @include('sections.experience', ['portfolio' => $portfolio])
        @include('sections.projects', ['portfolio' => $portfolio])
        @include('sections.skills', ['portfolio' => $portfolio])
        @include('sections.contact', ['portfolio' => $portfolio])
    </main>
@endsection
