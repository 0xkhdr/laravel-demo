<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $featuredProjects = collect();
        $recentArticles = collect();
        $featuredPackages = collect();

        try {
            if (class_exists('App\Models\Project')) {
                $featuredProjects = \App\Models\Project::where('featured', true)
                    ->orderBy('created_at', 'desc')
                    ->limit(4)
                    ->get();
            }
        } catch (\Exception $e) {
            // Table doesn't exist yet
        }

        try {
            if (class_exists('App\Models\Article')) {
                $recentArticles = \App\Models\Article::orderBy('published_at', 'desc')
                    ->limit(6)
                    ->get();
            }
        } catch (\Exception $e) {
            // Table doesn't exist yet
        }

        try {
            if (class_exists('App\Models\Package')) {
                $featuredPackages = \App\Models\Package::where('featured', true)
                    ->limit(4)
                    ->get();
            }
        } catch (\Exception $e) {
            // Table doesn't exist yet
        }

        return view('landing', [
            'featuredProjects' => $featuredProjects,
            'recentArticles' => $recentArticles,
            'featuredPackages' => $featuredPackages,
        ]);
    }
}
