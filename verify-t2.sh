#!/bin/bash
# Verify T2: semantic HTML and CSS tokens
grep -c '<section\|<article' resources/views/landing.blade.php | grep -q '[1-6]' && \
grep -c 'var(--' resources/css/design-system.css | awk '{print ($1 > 50) ? "OK" : "FAIL"}' | grep -q OK
