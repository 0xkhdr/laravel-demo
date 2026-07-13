<?php

namespace App\Http;

use App\Http\Middleware\ArticleOwnership;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [];

    protected $middlewareGroups = [];

    protected $middlewareAliases = [
        'article.ownership' => ArticleOwnership::class,
    ];
}
