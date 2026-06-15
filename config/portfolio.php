<?php

return [
    'name' => 'MOHAMED KHEDR',
    'role' => 'BACKEND ENGINEER',
    'tagline' => 'I build systems that scale. Clean architecture. Clean code.',
    'about' => [
        'paragraphs' => [
            'I design and implement high-performance backend systems, distributed architectures, and robust APIs. My engineering focus is on simplicity, scalability, and code discipline.',
            'Using modern PHP, Go, and cloud-native tools, I build services that process data efficiently and stay maintainable under heavy load.',
        ],
    ],
    'experience' => [
        [
            'company' => 'Nothing Tech',
            'role' => 'Senior Backend Engineer',
            'duration' => '2024 - PRESENT',
            'points' => [
                'Designed and scaled core product APIs supporting millions of active monthly users.',
                'Refactored legacy monolith systems into high-performance microservices, reducing response latency by 35%.',
                'Championed developer tooling and CI/CD pipelines to enforce code quality and clean architecture.',
            ],
        ],
        [
            'company' => 'Core Systems Inc.',
            'role' => 'Backend Developer',
            'duration' => '2021 - 2024',
            'points' => [
                'Developed scalable backend features using Laravel, PHP, and MySQL.',
                'Integrated multiple third-party APIs and implemented asynchronous job processing pipelines.',
                'Implemented database query optimizations resulting in a 40% reduction in query execution times.',
            ],
        ],
    ],
    'skills' => [
        'Languages' => ['PHP', 'Go', 'JavaScript', 'SQL', 'Bash'],
        'Frameworks' => ['Laravel', 'Symfony', 'Gin'],
        'Databases' => ['MySQL', 'PostgreSQL', 'Redis', 'MongoDB'],
        'DevOps' => ['Docker', 'Kubernetes', 'AWS', 'CI/CD'],
        'Tools' => ['Git', 'Vite', 'Nginx', 'Horizon'],
    ],
    'contact' => [
        'email' => 'hello@khedr.dev',
        'github' => 'https://github.com/0xkhdr',
        'linkedin' => 'https://linkedin.com/in/0xkhdr',
        'twitter' => 'https://x.com/0xkhdr',
    ],
    'fallback_projects' => [
        [
            'title' => 'Nothing OS Cloud Backend (Config Fallback)',
            'description' => 'A highly scalable, stateless backend API gateway for Nothing OS notification services. Built with Symfony and Redis, managing 100k+ concurrent websocket connections.',
            'github_url' => 'https://github.com/0xkhdr/nothing-cloud',
            'live_url' => 'https://nothing.tech',
            'technologies' => ['Symfony', 'Redis', 'Websockets', 'Docker'],
        ],
    ],
];
