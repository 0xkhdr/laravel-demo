#!/bin/bash
# Verify T4: Navigation bar
grep -q 'position: fixed' resources/css/design-system.css && \
grep -q 'z-index:' resources/css/design-system.css && \
grep -q '.navbar' resources/css/design-system.css && \
grep -q 'backdrop-filter' resources/css/design-system.css && \
grep -q 'scroll.*addEventListener\|addEventListener.*scroll' resources/js/nav.js && \
grep -q '<nav' resources/views/landing.blade.php
