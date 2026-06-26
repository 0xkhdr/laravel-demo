#!/bin/bash
grep -q '@media (max-width' resources/css/design-system.css && \
grep -q '.hamburger' resources/css/design-system.css && \
grep -q '.mobile-menu' resources/css/design-system.css && \
grep -q 'clamp(' resources/css/design-system.css && \
grep -q 'hamburger' resources/views/landing.blade.php && \
grep -q 'addEventListener.*toggle' resources/js/menu.js
