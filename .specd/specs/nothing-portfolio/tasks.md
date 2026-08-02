# Tasks — Nothing.tech Design System Portfolio

> Add only real work. The optional columns beyond the six required ones may be omitted.
> Production rows declare full trace, risk, routing, context, capability, evidence, and edge-check intent.

| id | role | files | depends-on | verify | acceptance | refs | kind | risk | complexity | capabilities | context |
|---|---|---|---|---|---|---|---|---|---|---|---|
| ✅ T1 | craftsman | tailwind.config.js,vite.config.js,resources/css/app.css,package.json,postcss.config.js | - | npm run build && test -f public/build/assets/app-*.css | R1.1,R1.2,R1.3,R1.4 | R1.1,R1.2,R1.3,R1.4 | setup | medium | standard | context,sandbox | Tailwind config with Nothing theme colors, fonts, spacing scale |
| ✅ T2 | craftsman | resources/css/app.css,resources/css/components/,resources/css/utilities/ | T1 | npm run build | R1.1,R1.2,R1.3,R1.4 | R1.1,R1.2,R1.3,R1.4 | component | high | standard | context | Global design system: colors, typography, spacing, layout foundations |
| ✅ T3 | craftsman | resources/views/components/nav.blade.php,resources/views/layouts/app.blade.php | T2 | npm run build | R2.1 | R2.1 | component | medium | standard | context | Navigation component with backdrop-filter blur, logo, links |
| ✅ T4 | craftsman | resources/views/components/hero.blade.php,resources/views/components/section-header.blade.php | T2 | npm run build | R3.1,R2.2 | R2.2,R3.1 | component | medium | standard | context | Hero section: fullscreen, massive display text, subtitle, CTA button |
| ✅ T5 | craftsman | resources/views/components/project-card.blade.php,resources/views/components/skill-tag.blade.php,resources/views/components/terminal-block.blade.php | T2 | npm run build | R2.3,R2.4,R2.5 | R2.3,R2.4,R2.5 | component | low | standard | context | Cards, buttons, tags, terminal blocks with proper borders and hover states |
| ✅ T6 | craftsman | resources/views/sections/about.blade.php | T3,T4 | npm run build | R3.2 | R3.2 | section | low | standard | context | About section: black background, white text, 2-3 paragraphs |
| ✅ T7 | craftsman | resources/views/sections/experience.blade.php | T3,T4 | npm run build | - | - | section | low | standard | context | Experience section: timeline layout, company roles, dates, bullets |
| ✅ T8 | craftsman | resources/views/sections/projects.blade.php | T3,T4,T5 | npm run build | R3.3 | R3.3 | section | medium | standard | context | Projects section: grid cards with tech tags, links, hover lift |
| ✅ T9 | craftsman | resources/views/sections/skills.blade.php | T3,T4,T5 | npm run build | R3.4 | R3.4 | section | low | standard | context | Skills section: categorized tags (Languages, Frameworks, DBs, DevOps, Tools) |
| ✅ T10 | craftsman | resources/views/sections/contact.blade.php,resources/views/components/footer.blade.php | T3,T4 | npm run build | R3.5 | R3.5 | section | low | standard | context | Contact section: email, social links, optional form |
| ✅ T11 | craftsman | resources/js/animations.js,resources/css/components/reveal.css | T2,T6,T7,T8,T9,T10 | npm run build | R4.1,R4.2,R4.3,R4.4 | R4.1,R4.2,R4.3,R4.4 | feature | low | standard | context | Scroll reveals, hover transitions, fade-in animations |
| ✅ T12 | craftsman | resources/js/app.js,resources/views/components/nav.blade.php | T3 | npm run build | - | - | feature | low | standard | context | Dark mode toggle: switches [data-theme], smooth transitions |
| ✅ T13 | craftsman | tailwind.config.js,resources/css/app.css | T1,T2,T3 | npm run build | R5.1,R5.5 | R5.1,R5.5 | feature | medium | standard | context | Responsive design: mobile-first, semantic HTML, proper breakpoints |
| ✅ T14 | craftsman | resources/css/app.css,app/Http/Controllers/PortfolioController.php | T2,T13 | npm run build | R6.1,R6.2,R6.3,R6.4 | R6.1,R6.2,R6.3,R6.4 | quality | high | standard | context,sandbox | Performance: Lighthouse 95+, FCP <1.5s, purged CSS, tree-shaken JS |
| ✅ T15 | craftsman | resources/views/ | T6,T7,T8,T9,T10 | npm run build | R5.2,R5.3,R5.4,R5.5 | R5.2,R5.3,R5.4,R5.5 | quality | high | standard | context | Accessibility: WCAG AA, focus states, semantic HTML, color contrast |
