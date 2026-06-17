<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;

class PortfolioController extends Controller
{
    /**
     * Render the portfolio homepage.
     */
    public function index(): View
    {
        $projects = collect();
        $dbConnected = true;

        try {
            $projects = Project::all();
        } catch (Exception $e) {
            Log::error('Database error in PortfolioController: '.$e->getMessage());
            $dbConnected = false;
        }

        // Fallback projects from config if DB is offline or projects collection is empty
        if (! $dbConnected || $projects->isEmpty()) {
            $projects = collect(config('portfolio.fallback_projects', []))->map(function ($proj) {
                return (object) $proj;
            });
        }

        return view('welcome', [
            'portfolio' => config('portfolio'),
            'projects' => $projects,
        ]);
    }
}
