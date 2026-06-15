<?php

use App\Services\ProjectLoader;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->loader = new ProjectLoader;
    $this->tempDir = database_path('data/temp_test');
    if (! File::isDirectory($this->tempDir)) {
        File::makeDirectory($this->tempDir, 0755, true);
    }
});

afterEach(function () {
    if (File::isDirectory($this->tempDir)) {
        File::deleteDirectory($this->tempDir);
    }
});

it('loads projects from a valid JSON file', function () {
    $filePath = $this->tempDir.'/valid.json';
    $data = [
        [
            'title' => 'Test Project 1',
            'description' => 'Test Description 1',
            'github_url' => 'https://github.com',
            'live_url' => 'https://live.com',
            'technologies' => ['PHP', 'Laravel'],
        ],
    ];
    File::put($filePath, json_encode($data));

    $projects = $this->loader->loadProjects($filePath);

    expect($projects)->toHaveCount(1);
    expect($projects->first()->title)->toBe('Test Project 1');
    expect($projects->first()->technologies)->toBe(['PHP', 'Laravel']);
});

it('throws exception if JSON file is missing', function () {
    $this->loader->loadProjects($this->tempDir.'/missing.json');
})->throws(RuntimeException::class, 'File not found');

it('throws exception if JSON file content is not an array', function () {
    $filePath = $this->tempDir.'/invalid_shape.json';
    File::put($filePath, json_encode('string value'));

    $this->loader->loadProjects($filePath);
})->throws(RuntimeException::class, 'must be an array');

it('throws exception if project item is not an object', function () {
    $filePath = $this->tempDir.'/invalid_item.json';
    File::put($filePath, json_encode(['not an object']));

    $this->loader->loadProjects($filePath);
})->throws(RuntimeException::class, 'must be an object');

it('throws exception if JSON file is malformed', function () {
    $filePath = $this->tempDir.'/corrupt.json';
    File::put($filePath, '{invalid json');

    $this->loader->loadProjects($filePath);
})->throws(RuntimeException::class, 'Failed to parse JSON');

it('throws exception if required fields are missing', function () {
    $filePath = $this->tempDir.'/missing_field.json';
    $data = [
        [
            'title' => 'Missing Description',
            // 'description' is missing
            'technologies' => ['PHP'],
        ],
    ];
    File::put($filePath, json_encode($data));

    $this->loader->loadProjects($filePath);
})->throws(RuntimeException::class, "Missing required field 'description'");

it('throws exception if technologies is not an array', function () {
    $filePath = $this->tempDir.'/invalid_tech.json';
    $data = [
        [
            'title' => 'Invalid Tech',
            'description' => 'Description',
            'technologies' => 'not an array',
        ],
    ];
    File::put($filePath, json_encode($data));

    $this->loader->loadProjects($filePath);
})->throws(RuntimeException::class, 'must be an array');
