<?php

return [
    'name' => 'Mohamed Khedr', 'role' => 'Mid-Level Backend Engineer', 'location' => 'Cairo, Egypt',
    'intro' => 'Backend engineer building reliable Laravel systems, integrations, and data synchronization workflows.',
    'status' => 'Available for thoughtful backend work', 'email' => '0xkhdr@gmail.com', 'github' => 'https://github.com/0xkhdr',
    'about' => 'I design and own backend work from business understanding through production support. My strongest professional foundation is PHP and Laravel, with hands-on experience in APIs, transactional workflows, third-party integrations, Kafka, Debezium, queues, and production diagnosis.',
    'experience' => [
        ['period' => 'May 2024 — Present', 'company' => 'Afaqy', 'title' => 'Mid-Level Backend Engineer', 'text' => 'Complex backend architecture, integrations, synchronization, production troubleshooting, and mentoring within a 15+ engineer backend team.'],
        ['period' => 'Feb 2022 — Apr 2024', 'company' => 'Rowaad', 'title' => 'Junior Backend Developer', 'text' => 'Primary backend owner for six production products across marketplaces, digital cards, services, and e-commerce.'],
        ['period' => 'Jul 2021 — Jan 2022', 'company' => 'Sectors', 'title' => 'Junior Backend Developer', 'text' => 'Built the complete Laravel backend and architecture for an online-learning platform.'],
        ['period' => 'Feb 2021 — Jul 2021', 'company' => 'Giraffe Code', 'title' => 'Fresh Backend Developer', 'text' => 'Implemented e-commerce features, integrations, payments, notifications, and queued processing in an established architecture.'],
    ],
    'work' => [
        ['label' => 'AFAQY / SYNCHRONIZATION', 'title' => 'Kafka + Debezium CDC', 'text' => 'Helped design and configure near-real-time synchronization between operational systems. Debezium captures database changes; Kafka topics, partitions, consumer groups, and consumers deliver transformed data reliably, reducing missed events and inconsistencies.', 'stack' => 'Kafka · Debezium · Kafka Connect · PHP · Laravel · MySQL'],
        ['label' => 'AFAQY / RELIABILITY', 'title' => 'Offline-resilient trip sync', 'text' => 'Owned the API contract, schema, validation, batch processing, idempotency, duplicate protection, retries, partial success, mobile coordination, rollout, and production support for offline trip synchronization.', 'stack' => 'Laravel · MySQL · Batch APIs · Idempotency'],
        ['label' => 'ROWAAD / PAYMENTS', 'title' => 'Wallet and digital-card workflows', 'text' => 'Built payment, wallet, fulfillment, webhook, delivery, and compensating-refund flows across digital-card and commerce products.', 'stack' => 'Laravel · MongoDB · Redis · NoonPayments · STC'],
    ],
    'projects' => [
        ['name' => 'Frontier', 'text' => 'Laravel application foundations and reusable Action, Repository, caching, and modular architecture packages.', 'url' => 'https://github.com/0xkhdr/frontier', 'evidence' => 'Direct implementation'],
        ['name' => 'Guardian', 'text' => 'Pluggable Laravel authentication orchestration with composable identity, matching, sequences, and token drivers.', 'url' => 'https://github.com/0xkhdr/guardian', 'evidence' => 'Direct implementation'],
        ['name' => 'Pathframe', 'text' => 'A local, deterministic development-path protocol that makes structured software changes visible, executable, interruptible, and recoverable for humans and coding agents.', 'url' => 'https://github.com/0xkhdr/pathframe', 'evidence' => 'Architecture direction; AI-assisted implementation'],
        ['name' => 'Revive', 'text' => 'Reproducible developer-environment backup and restoration with manifests, planning, snapshots, verification, and rollback.', 'url' => 'https://github.com/0xkhdr/revive', 'evidence' => 'Architecture direction; AI-assisted implementation'],
    ],
    'skills' => ['PHP / Laravel', 'REST APIs', 'Kafka / Debezium', 'MySQL / MongoDB / Redis', 'Queues / Horizon', 'Integrations / Webhooks', 'Transactions / Idempotency', 'PHPUnit / Pest', 'Linux / Git / Docker', 'Production diagnosis'],
];
