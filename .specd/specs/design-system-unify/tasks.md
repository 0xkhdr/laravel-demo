# Tasks — Design System Unification

## Task List

- [ ] T1: Complete CSS Design System File (R2, R3, R5, R6, R8, R9, R11, R12, R14)
- [ ] T2: Audit Current Blade Templates & Styling
- [ ] T3: Style Auth Pages (R1, R4, R10)
- [ ] T4: Style Profile Pages (R1, R4, R10)
- [ ] T5: Style Landing Page & Welcome Page (R1, R4, R5, R6)
- [ ] T6: Style Article Pages (R1, R4, R5)
- [ ] T7: Style Package Pages (R1, R4, R5)
- [ ] T8: Style Project Showcase Pages (R1, R4, R5)
- [ ] T9: Test & Fix Responsive Design (R7)
- [ ] T10: Implement & Test Dark Theme (R12)
- [ ] T11: Accessibility Testing & Fixes (R13)
- [ ] T12: Cross-Browser Testing & Fixes

---

## Wave 1: Foundation & Audit

### T1: Complete CSS Design System File
**Objective:** Create comprehensive `resources/css/design-system.css` with all Nothing.tech tokens and components.

**Verification Command:**
```bash
npm run lint:css
ls -lh resources/css/design-system.css
```

---

### T2: Audit Current Blade Templates & Styling
**Objective:** Document current state of all Blade templates, identify styling inconsistencies and gaps.

**Verification Command:**
```bash
# Manual audit report
```

---

## Wave 2: Core Pages

### T3: Style Auth Pages
**Objective:** Apply design system to login, register, reset-password, forgot-password, verify-email, change-password.

**Verification Command:**
```bash
# Manual browser test: visual inspection, responsive design, dark theme
```

### T4: Style Profile Pages
**Objective:** Apply design system to user profile pages (show, change-password).

**Verification Command:**
```bash
# Manual browser test
```

### T5: Style Landing Page & Welcome Page
**Objective:** Apply design system to landing and welcome pages.

**Verification Command:**
```bash
# Manual browser test
```

### T6: Style Article Pages
**Objective:** Apply design system to article listing and detail pages.

**Verification Command:**
```bash
# Manual browser test
```

---

## Wave 3: Content Pages

### T7: Style Package Pages
**Objective:** Apply design system to package directory and detail pages.

**Verification Command:**
```bash
# Manual browser test
```

### T8: Style Project Showcase Pages
**Objective:** Apply design system to project showcase and detail pages.

**Verification Command:**
```bash
# Manual browser test
```

---

## Wave 4: Polish & Testing

### T9: Test & Fix Responsive Design
**Objective:** Verify all pages render correctly on mobile, tablet, desktop breakpoints.

**Verification Command:**
```bash
# Chrome DevTools responsive design test
# No horizontal scrolling on any breakpoint
```

### T10: Implement & Test Dark Theme
**Objective:** Verify dark theme toggle works on all pages; ensure all colors adapt correctly.

**Verification Command:**
```bash
# Manual theme toggle test on all pages
```

### T11: Accessibility Testing & Fixes (WCAG AA)
**Objective:** Verify all pages meet WCAG AA baseline; fix accessibility issues.

**Verification Command:**
```bash
# Axe-core accessibility audit
npx @axe-core/cli <page-url>
# Manual keyboard navigation test
```

### T12: Cross-Browser Testing & Fixes
**Objective:** Verify all pages render correctly on Chrome, Firefox, Safari, Edge.

**Verification Command:**
```bash
# Manual cross-browser testing on desktop sizes (1024px, 1440px, 1920px)
```

---

## Task Dependencies (DAG)

```
T1 (CSS Design System)
├─ T2 (Audit, parallel)
└─ T3 (Auth Pages)
   ├─ T4 (Profile Pages)
   ├─ T5 (Landing Page)
   ├─ T6 (Article Pages)
   ├─ T7 (Package Pages)
   └─ T8 (Project Pages)
      ├─ T9 (Responsive Testing)
      ├─ T10 (Dark Theme)
      ├─ T11 (Accessibility)
      └─ T12 (Cross-Browser)
```

**Wave 1 (1–2 days):** T1, T2 (parallel)
**Wave 2 (3–5 days):** T3, T4, T5, T6 (parallel after T1)
**Wave 3 (2–3 days):** T7, T8 (parallel after T1)
**Wave 4 (2–3 days):** T9, T10, T11, T12 (parallel after T3–T8)

**Total estimate:** 8–13 days

