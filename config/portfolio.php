<?php

return [
    'owner' => [
        'name' => env('PORTFOLIO_NAME', 'Laravel Demo'),
        'title' => 'Senior Backend Engineer',
        'tagline' => 'I build reliable backend systems, clean APIs, and crisp product experiences.',
        'bio' => [
            'Senior backend engineer focused on Laravel, API design, data modeling, and operational clarity.',
            'I care about fast delivery, maintainable code, and systems that stay understandable as they grow.',
        ],
    ],

    'contact' => [
        [
            'label' => 'Email',
            'href' => 'mailto:hello@example.com',
            'value' => 'hello@example.com',
        ],
        [
            'label' => 'GitHub',
            'href' => 'https://github.com/example',
            'value' => 'github.com/example',
        ],
        [
            'label' => 'LinkedIn',
            'href' => 'https://www.linkedin.com/in/example',
            'value' => 'linkedin.com/in/example',
        ],
    ],

    'highlights' => [
        'Laravel 13',
        'PHP 8.3',
        'APIs',
        'MySQL',
        'Redis',
    ],
];
