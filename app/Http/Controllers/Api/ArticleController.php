<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(): ArticleCollection
    {
        return new ArticleCollection(Article::published()->latestPublished()->paginate(10));
    }

    public function show(Article $article): ArticleResource
    {
        abort_unless($article->is_published && $article->published_at !== null, 404);

        return new ArticleResource($article);
    }
}
