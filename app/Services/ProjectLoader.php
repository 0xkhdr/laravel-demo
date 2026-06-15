<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use RuntimeException;

class ProjectLoader
{
    /**
     * Load projects from JSON file(s).
     *
     * @throws RuntimeException
     */
    public function loadProjects(?string $path = null): Collection
    {
        $projects = collect();

        // 1. If a specific file path is provided, load just that.
        if ($path) {
            return $this->loadFile($path);
        }

        $defaultFile = database_path('data/projects.json');
        $hasDefaultFile = File::exists($defaultFile);

        // 2. Also check if there's a directory of JSON files (e.g. database/data/projects/*.json)
        $directory = database_path('data/projects');
        $hasDirectory = File::isDirectory($directory);

        if (! $hasDefaultFile && ! $hasDirectory) {
            throw new RuntimeException("Projects JSON file not found at [{$defaultFile}] and no projects directory found at [{$directory}].");
        }

        if ($hasDefaultFile) {
            $projects = $projects->merge($this->loadFile($defaultFile));
        }

        if ($hasDirectory) {
            $files = File::files($directory);
            foreach ($files as $file) {
                if ($file->getExtension() === 'json') {
                    $projects = $projects->merge($this->loadFile($file->getRealPath()));
                }
            }
        }

        return $projects;
    }

    /**
     * Load and parse a single JSON file.
     *
     * @throws RuntimeException
     */
    protected function loadFile(string $path): Collection
    {
        if (! File::exists($path)) {
            throw new RuntimeException("File not found at [{$path}].");
        }

        $content = File::get($path);
        $decoded = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException("Failed to parse JSON in [{$path}]: ".json_last_error_msg());
        }

        if (! is_array($decoded)) {
            throw new RuntimeException("JSON content in [{$path}] must be an array.");
        }

        return collect($decoded)->map(function ($item, $index) use ($path) {
            if (! is_array($item)) {
                throw new RuntimeException("Project item at index [{$index}] in [{$path}] must be an object.");
            }

            // Validate required fields
            foreach (['title', 'description', 'technologies'] as $field) {
                if (! array_key_exists($field, $item)) {
                    throw new RuntimeException("Missing required field '{$field}' in project item at index [{$index}] in [{$path}].");
                }
            }

            if (! is_array($item['technologies'])) {
                throw new RuntimeException("Field 'technologies' in project item at index [{$index}] in [{$path}] must be an array.");
            }

            // Return as an object (stdClass)
            return (object) [
                'title' => $item['title'],
                'description' => $item['description'],
                'github_url' => $item['github_url'] ?? null,
                'live_url' => $item['live_url'] ?? null,
                'technologies' => $item['technologies'],
            ];
        });
    }
}
