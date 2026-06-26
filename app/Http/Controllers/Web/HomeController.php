<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.home', [
            'profile' => config('portfolio'),
            'articles' => Article::published()->latestPublished()->take(3)->get(),
        ]);
    }
}
