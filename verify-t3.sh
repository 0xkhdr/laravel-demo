#!/bin/bash
# Verify T3: Hero section implementation (file-based checks)
grep -q 'class="hero"' resources/views/landing.blade.php && \
grep -q 'text-hero' resources/views/landing.blade.php && \
grep -q 'height: 100vh' resources/css/design-system.css && \
grep -q 'clamp(48px' resources/css/design-system.css && \
grep -q 'font-family: var(--font-display)' resources/css/design-system.css && \
grep -q 'color: var(--color-white)' resources/css/design-system.css
