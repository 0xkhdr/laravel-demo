#!/bin/bash
grep -q 'cta-section' resources/css/design-system.css && \
grep -q '.footer' resources/css/design-system.css && \
grep -q 'cta-buttons' resources/css/design-system.css && \
grep -q 'footer-copyright' resources/css/design-system.css && \
grep -q '<section id="cta"' resources/views/landing.blade.php && \
grep -q '<footer' resources/views/landing.blade.php
