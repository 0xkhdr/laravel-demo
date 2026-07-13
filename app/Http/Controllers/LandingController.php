<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\GitHubRepo;
use Illuminate\Support\Facades\Log;

class LandingController extends Controller
{
    public function __invoke()
    {
        $articles = Article::published()->latest()->limit(5)->get();

        $repos = [];
        try {
            $repos = GitHubRepo::orderBy('updated_at', 'desc')->limit(5)->get();
        } catch (\Exception $e) {
            Log::warning('Failed to fetch GitHub repos', ['exception' => $e->getMessage()]);
        }

        return view('landing', compact('articles', 'repos'));
    }
}
