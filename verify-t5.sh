#!/bin/bash
# Verify T5: Featured projects grid
grep -q 'projects-grid' resources/css/design-system.css && \
grep -q 'repeat(auto-fit' resources/css/design-system.css && \
grep -q 'aspect-ratio: 4/3' resources/css/design-system.css && \
grep -q 'scale(1.02)' resources/css/design-system.css && \
grep -q '@forelse($featuredProjects' resources/views/landing.blade.php && \
grep -q 'project-card' resources/views/landing.blade.php
