#!/bin/bash
grep -q 'packages-section' resources/css/design-system.css && \
grep -q 'packages-grid' resources/css/design-system.css && \
grep -q 'package-icon' resources/css/design-system.css && \
grep -q '@forelse($featuredPackages' resources/views/landing.blade.php && \
grep -q 'Explore All Packages' resources/views/landing.blade.php
