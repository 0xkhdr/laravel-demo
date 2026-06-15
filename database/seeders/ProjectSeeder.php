<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::create([
            'title' => 'Nothing OS Cloud Backend',
            'description' => 'A highly scalable, stateless backend API gateway for Nothing OS notification services. Built with Symfony and Redis, managing 100k+ concurrent websocket connections.',
            'github_url' => 'https://github.com/0xkhdr/nothing-cloud',
            'live_url' => 'https://nothing.tech',
            'technologies' => ['Symfony', 'Redis', 'Websockets', 'Docker'],
        ]);

        Project::create([
            'title' => 'Distributed Task Queue Broker',
            'description' => 'A custom message broker and task queue engine implementing the AMQP protocol in Go. Supports delayed execution, priority queuing, and dead-letter exchanges.',
            'github_url' => 'https://github.com/0xkhdr/task-broker',
            'live_url' => null,
            'technologies' => ['Go', 'AMQP', 'gRPC', 'PostgreSQL'],
        ]);

        Project::create([
            'title' => 'Laravel REST API Boilerplate',
            'description' => 'A production-ready Laravel REST API boilerplate showcasing domain-driven design, JWT/Sanctum authentication, automated test suites, and Docker environment integration.',
            'github_url' => 'https://github.com/0xkhdr/laravel-ddd-boilerplate',
            'live_url' => 'https://boilerplate.khedr.dev',
            'technologies' => ['Laravel', 'MySQL', 'Docker', 'Pest'],
        ]);
    }
}
