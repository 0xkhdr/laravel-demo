<?php

return [
    'brand' => [
        'name' => 'Nothing Portfolio',
        'label' => 'Senior portfolio',
        'tagline' => 'Industrial minimalism for digital products.',
    ],

    'navigation' => [
        ['label' => 'About', 'href' => '#about'],
        ['label' => 'Experience', 'href' => '#experience'],
        ['label' => 'Projects', 'href' => '#projects'],
        ['label' => 'Skills', 'href' => '#skills'],
        ['label' => 'Contact', 'href' => '#contact'],
    ],

    'hero' => [
        'eyebrow' => 'Senior product designer and frontend engineer',
        'title' => 'Building precise interfaces with a quiet, technical edge.',
        'description' => 'I shape portfolio systems, product stories, and design languages that feel stripped back, highly legible, and fast to navigate.',
        'primary_cta' => [
            'label' => 'View selected work',
            'href' => '#projects',
        ],
        'secondary_cta' => [
            'label' => 'Start a conversation',
            'href' => '#contact',
        ],
        'details' => [
            ['label' => 'Based in', 'value' => 'Cairo, Egypt'],
            ['label' => 'Focus', 'value' => 'Design systems and frontend craft'],
            ['label' => 'Availability', 'value' => 'Open to select remote engagements'],
        ],
    ],

    'about' => [
        'eyebrow' => 'About',
        'title' => 'A portfolio built like a tool, not a brochure.',
        'description' => 'My work sits between product strategy and implementation. I prefer systems that leave no ambiguity for the user, and no friction for the team maintaining them.',
        'highlights' => [
            'Interface architecture that keeps content and layout readable at every size.',
            'Editorial hierarchy with restrained motion and deliberate visual pacing.',
            'Reusable patterns that let product copy, case studies, and contact details stay centralized.',
        ],
    ],

    'experience' => [
        [
            'period' => '2023 - Present',
            'role' => 'Senior Product Designer',
            'company' => 'Independent / Consulting',
            'summary' => 'Lead portfolio and product experiences for founders who need their work to feel premium, technical, and easy to update.',
        ],
        [
            'period' => '2020 - 2023',
            'role' => 'Frontend Engineer',
            'company' => 'Studio systems team',
            'summary' => 'Built design-system driven landing pages and internal tools with shared content models, accessible markup, and predictable release paths.',
        ],
        [
            'period' => '2018 - 2020',
            'role' => 'Interaction Designer',
            'company' => 'Product laboratory',
            'summary' => 'Shaped product narratives, content structure, and motion guidance for mobile and web products with a strong editorial identity.',
        ],
    ],

    'projects' => [
        [
            'title' => 'Signal Interface',
            'category' => 'Design system refresh',
            'summary' => 'A clean system for portfolio pages, project overviews, and contact flows with shared content and a deliberate monochrome palette.',
            'impact' => 'Reduced maintenance overhead by moving all copy into one data source.',
            'stack' => ['Laravel', 'Blade', 'CSS architecture'],
        ],
        [
            'title' => 'Archive Console',
            'category' => 'Content platform',
            'summary' => 'A content-first interface for long-form project histories that keeps navigation, section headings, and metadata easy to scan.',
            'impact' => 'Improved mobile readability through tighter hierarchy and responsive layout rules.',
            'stack' => ['Laravel', 'PHP', 'Accessible markup'],
        ],
        [
            'title' => 'Quiet Motion',
            'category' => 'Interaction system',
            'summary' => 'A restrained animation spec for loading, hover, and focus states that keeps the interface calm and predictable.',
            'impact' => 'Preserved polish while honoring reduced-motion preferences.',
            'stack' => ['CSS variables', 'Transitions', 'Progressive enhancement'],
        ],
    ],

    'skills' => [
        'Design systems',
        'Content modeling',
        'Laravel and Blade',
        'Accessible UI structure',
        'Editorial hierarchy',
        'Responsive layouts',
        'Motion restraint',
        'Frontend maintenance',
    ],

    'contact' => [
        'eyebrow' => 'Contact',
        'title' => 'If the work needs clarity, structure, and a sharp finish, let’s talk.',
        'description' => 'I keep contact options simple and centralized so the page stays easy to update and easy to trust.',
        'links' => [
            [
                'label' => 'Email',
                'value' => 'hello@nothingportfolio.test',
                'href' => 'mailto:hello@nothingportfolio.test',
            ],
            [
                'label' => 'LinkedIn',
                'value' => 'linkedin.com/in/nothingportfolio',
                'href' => 'https://linkedin.com/in/nothingportfolio',
            ],
            [
                'label' => 'GitHub',
                'value' => 'github.com/nothingportfolio',
                'href' => 'https://github.com/nothingportfolio',
            ],
        ],
    ],
];
