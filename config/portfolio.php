<?php

return [
    'name' => 'MOHAMED KHEDR',
    'role' => 'SENIOR BACKEND & SYSTEMS ENGINEER',
    'tagline' => 'I architect distributed backend systems, design event-driven pipelines, and build developer-focused tools.',
    'about' => [
        'paragraphs' => [
            'Senior Backend & Systems Engineer with over 5 years of professional experience architecting distributed systems, real-time message streams, and high-concurrency APIs.',
            'Deeply focused on the PHP/Laravel ecosystem and building open-source developer tooling (DX) in Go and Python. Dedicated to writing clean, modular, and highly testable code.',
        ],
    ],
    'experience' => [
        [
            'company' => 'Afaqy',
            'role' => 'Senior Backend & Systems Engineer',
            'duration' => 'MAY 2024 - PRESENT',
            'points' => [
                'Architected and deployed production-grade Apache Kafka consumers to synchronize fleet telemetry and core data in near real-time across 3 decoupled domains.',
                'Designed and integrated Saudi Arabia\'s WASL regulatory compliance system, implementing idempotent request handling and fail-safe retry mechanics to guarantee 100% compliance audits.',
                'Optimized Laravel/MySQL APIs using composite indexing and Nginx reverse proxying, achieving optimal performance under high-concurrency workloads.',
                'Assumed sole backend ownership, serving as the technical anchor for a cross-functional team of 15+ members.',
            ],
        ],
        [
            'company' => 'Rowaad',
            'role' => 'Backend Developer (Sole Engineer)',
            'duration' => 'FEB 2022 - APR 2024',
            'points' => [
                'Served as the sole backend engineer, owning database schema design, API implementation, server configuration, and deployments for 5 distinct production platforms.',
                'Built Khedma freelancing marketplace from scratch using Laravel, Mongez repository patterns, MongoDB, and NoonPayments.',
                'Decoupled third-party payment, shipping (Aramex), and SMS latencies by implementing Redis-backed Laravel Horizon queue worker pipelines.',
            ],
        ],
        [
            'company' => 'Sectors',
            'role' => 'Laravel Backend Developer',
            'duration' => 'JUL 2021 - FEB 2022',
            'points' => [
                'Developed the backend core for the 3almny EdTech platform, servicing teachers, students, parents, and schools with complex scheduling systems.',
                'Integrated Zoom and Google Meet APIs to automate virtual classroom generation and session scheduling.',
            ],
        ],
        [
            'company' => 'Giraffe Code',
            'role' => 'Backend Developer',
            'duration' => 'FEB 2021 - JUL 2021',
            'points' => [
                'Contributed to backend API design and implementation for an innovative in-store scan-and-shop e-commerce mobile application (No.Q) and tech retail website.',
                'Wrote PHPUnit test suites and maintained API endpoints using repository patterns and Swagger documentation.',
            ],
        ],
    ],
    'skills' => [
        'Languages' => ['PHP (Expert)', 'Go (Advanced)', 'Python (Advanced)', 'SQL', 'Bash'],
        'Architecture' => ['Event-Driven (EDA)', 'CQRS', 'Event Sourcing', 'Modular Monoliths', 'DDD'],
        'Databases' => ['MySQL/MariaDB', 'MongoDB', 'Redis', 'SQLite'],
        'DevOps' => ['Docker', 'Podman', 'Nginx', 'Apache Kafka', 'Linux Administration'],
        'Testing & DX' => ['Pest', 'PHPUnit', 'Mockery', 'Static Analysis', 'CI/CD Gates'],
    ],
    'contact' => [
        'email' => 'mohamedkhedr700@gmail.com',
        'github' => 'https://github.com/0xkhdr',
        'linkedin' => 'https://linkedin.com/in/mohamed-khedr-6959831ba',
        'twitter' => null,
    ],
    'fallback_projects' => [
        [
            'title' => 'specd (Config Fallback)',
            'description' => 'A spec-driven developer harness CLI featuring validation gates, DAG-based task execution, and evidence-gated completion checks.',
            'github_url' => 'https://github.com/0xkhdr/specd',
            'live_url' => null,
            'technologies' => ['Go', 'CLI', 'DAG', 'JSON Schema'],
        ],
        [
            'title' => 'revive (Config Fallback)',
            'description' => 'A transaction-safe developer environment manager with journaling for 7-step rollbacks, Age secret encryption, and a security plugin sandbox.',
            'github_url' => 'https://github.com/0xkhdr/revive',
            'live_url' => null,
            'technologies' => ['Python', 'Cryptography', 'Security Sandbox', 'CLI'],
        ],
        [
            'title' => 'Khedma (Config Fallback)',
            'description' => 'A full-featured freelancing marketplace built from scratch with custom job matching algorithms, wallet transaction ledgers, and NoonPayments integration.',
            'github_url' => null,
            'live_url' => 'https://5edmah.com/',
            'technologies' => ['Laravel', 'MongoDB', 'NoonPayments', 'HMVC'],
        ],
    ],
];
