#!/bin/bash
# T10: Check accessibility basics
grep -q '<header' resources/views/landing.blade.php && \
grep -q '<nav' resources/views/landing.blade.php && \
grep -q '<main' resources/views/landing.blade.php && \
grep -q '<footer' resources/views/landing.blade.php && \
grep -q 'alt=' resources/views/landing.blade.php && \
grep -q 'aria-label' resources/views/landing.blade.php && \
grep -q ':focus' resources/css/design-system.css
