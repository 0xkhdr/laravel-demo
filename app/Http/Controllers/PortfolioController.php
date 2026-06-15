<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\ProjectLoader;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;

class PortfolioController extends Controller
{
    /**
     * Render the portfolio homepage.
     */
    public function index(ProjectLoader $loader): View
    {
        $projects = collect();
        $dbConnected = true;

        try {
            $projects = Project::all();
        } catch (Exception $e) {
            Log::error('Database error in PortfolioController: '.$e->getMessage());
            $dbConnected = false;
        }

        // Fallback flow: DB -> JSON file -> Config
        if (! $dbConnected || $projects->isEmpty()) {
            try {
                $projects = $loader->loadProjects();
            } catch (Exception $e) {
                Log::error('JSON Projects loader error in PortfolioController: '.$e->getMessage());
                // Last-resort fallback to config projects
                $projects = collect(config('portfolio.fallback_projects', []))->map(function ($proj) {
                    return (object) $proj;
                });
            }
        }

        return view('welcome', [
            'portfolio' => config('portfolio'),
            'projects' => $projects,
        ]);
    }
}
