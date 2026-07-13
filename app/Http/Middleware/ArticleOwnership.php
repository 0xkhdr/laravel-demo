<?php

namespace App\Http\Middleware;

use App\Models\Article;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleOwnership
{
    public function handle(Request $request, Closure $next): Response
    {
        $article = $request->route('article');

        if ($article && $article->author_id !== $request->user()->id) {
            abort(403, 'Unauthorized to modify this article.');
        }

        return $next($request);
    }
}
