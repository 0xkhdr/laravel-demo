<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Services\ProjectLoader;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(ProjectLoader $loader): void
    {
        // Truncate existing projects to ensure idempotency
        Project::truncate();

        $projects = $loader->loadProjects();

        foreach ($projects as $projectData) {
            Project::create([
                'title' => $projectData->title,
                'description' => $projectData->description,
                'github_url' => $projectData->github_url,
                'live_url' => $projectData->live_url,
                'technologies' => $projectData->technologies,
            ]);
        }
    }
}
