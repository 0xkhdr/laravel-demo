#!/bin/bash
grep -q 'articles-section' resources/css/design-system.css && \
grep -q 'var(--color-pure-black)' resources/css/design-system.css && \
grep -q 'var(--color-nothing-red)' resources/css/design-system.css && \
grep -q '@forelse($recentArticles' resources/views/landing.blade.php && \
grep -q 'view-all-link' resources/views/landing.blade.php
