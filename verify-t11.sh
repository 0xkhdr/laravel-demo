#!/bin/bash
# T11: Check performance setup (no actual npm build required for verification)
grep -q 'aspect-ratio' resources/css/design-system.css && \
grep -q 'var(--' resources/css/design-system.css && \
grep -q 'object-fit' resources/css/design-system.css && \
grep -q '@media' resources/css/design-system.css && \
grep -q 'clamp(' resources/css/design-system.css
