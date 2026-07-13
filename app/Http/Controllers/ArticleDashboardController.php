<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleDashboardController extends Controller
{
    public function index(): View
    {
        $articles = auth()->user()->articles()->latest()->paginate(10);
        return view('articles.index', compact('articles'));
    }

    public function create(): View
    {
        return view('articles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3',
            'content' => 'required|string|min:10',
            'publish' => 'boolean',
        ]);

        $article = auth()->user()->articles()->create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'published_at' => $validated['publish'] ? now() : null,
        ]);

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    public function edit(Article $article): View
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3',
            'content' => 'required|string|min:10',
            'publish' => 'boolean',
        ]);

        $article->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'published_at' => $validated['publish'] ? now() : null,
        ]);

        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }
}
