<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        return view('pages.articles.index', [
            'articles' => Article::published()->latestPublished()->paginate(10),
        ]);
    }

    public function show(Article $article): View
    {
        abort_unless($article->is_published && $article->published_at !== null, 404);

        return view('pages.articles.show', [
            'article' => $article,
        ]);
    }
}
