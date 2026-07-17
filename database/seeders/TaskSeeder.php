<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        Task::create([
            'title' => 'Buy groceries',
            'description' => 'Milk, eggs, bread, chicken',
            'status' => 'todo',
        ]);

        Task::create([
            'title' => 'Complete project documentation',
            'description' => 'Write API docs and setup guide',
            'status' => 'in-progress',
        ]);

        Task::create([
            'title' => 'Review pull requests',
            'description' => null,
            'status' => 'todo',
        ]);

        Task::create([
            'title' => 'Deploy to production',
            'description' => 'Backup database first',
            'status' => 'done',
        ]);

        Task::create([
            'title' => 'Fix bug in authentication',
            'description' => 'Session timeout not working correctly',
            'status' => 'in-progress',
        ]);

        Task::create([
            'title' => 'Schedule team meeting',
            'description' => 'Sprint planning for next week',
            'status' => 'todo',
        ]);

        Task::create([
            'title' => 'Update dependencies',
            'description' => 'Run composer update and npm update',
            'status' => 'done',
        ]);

        Task::create([
            'title' => 'Write unit tests',
            'description' => 'Aim for 80% coverage',
            'status' => 'in-progress',
        ]);

        Task::create([
            'title' => 'Optimize database queries',
            'description' => 'Add indexes to slow queries',
            'status' => 'todo',
        ]);

        Task::create([
            'title' => 'Set up monitoring',
            'description' => 'Configure Sentry and monitoring tools',
            'status' => 'done',
        ]);

        Task::create([
            'title' => 'Refactor legacy code',
            'description' => 'Modernize old authentication module',
            'status' => 'todo',
        ]);
    }
}
