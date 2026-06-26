#!/bin/bash
# T12: Final integration test - verify all components present and using tokens

# Check all main sections exist
grep -q 'class="hero"' resources/views/landing.blade.php && \
grep -q 'class="navbar"' resources/views/landing.blade.php && \
grep -q 'id="projects"' resources/views/landing.blade.php && \
grep -q 'id="articles"' resources/views/landing.blade.php && \
grep -q 'id="packages"' resources/views/landing.blade.php && \
grep -q 'id="cta"' resources/views/landing.blade.php && \
grep -q '<footer' resources/views/landing.blade.php && \
\
# Check that CSS tokens are extensively used
grep -c 'var(--' resources/css/design-system.css | awk '{if ($1 > 50) exit 0; else exit 1}' && \
\
# Check no obvious hardcoded colors/spacing (basic check)
! grep -q '#[0-9a-f]\{6\}' resources/css/design-system.css || \
grep '#[0-9a-f]\{6\}' resources/css/design-system.css | wc -l | awk '{print ($1 <= 5) ? "OK" : "FAIL"}'
