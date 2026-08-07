<?php

return [
    'identity' => [
        'name' => env('PORTFOLIO_NAME'),
        'title' => env('PORTFOLIO_TITLE', 'Software Engineer'),
        'statement' => env('PORTFOLIO_STATEMENT'),
    ],

    'about' => [],

    'experience' => [],

    'projects' => [],

    'open_source' => [],

    'skills' => [
        'Languages' => [],
        'Frameworks' => [],
        'Databases' => [],
        'DevOps' => [],
        'Tools' => [],
    ],

    'articles' => [],

    'links' => [
        'email' => env('PORTFOLIO_EMAIL'),
        'github' => env('PORTFOLIO_GITHUB'),
        'linkedin' => env('PORTFOLIO_LINKEDIN'),
        'twitter' => env('PORTFOLIO_TWITTER'),
    ],
];
