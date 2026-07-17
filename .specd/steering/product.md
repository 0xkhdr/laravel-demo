<!-- specd:managed:steering/product.md:v3 begin -->
# Steering: Product

> Fill this in for your project. The harness reads it to keep work aligned with
> intent. Replace the prompts below.

## Thesis
- **What this product is:** A minimal, clean Laravel 13 REST API reference implementation demonstrating best practices for architecture, testing, and deployment.
- **Who it is for:** Developers learning REST API patterns, educators teaching Laravel/architectural cleanness, projects needing a proven demo baseline.

## Principles
- API must serve as documentation: EARS-traced requirements, clear HTTP contracts, JSON-first responses
- Code cleanliness over feature breadth: no unused routes, controllers, or definitions; every line has a reason
- No production-scale optimizations: demo-level performance acceptable; focus is teachability and maintainability
- Testing is non-negotiable: Pest framework, isolated DB, high coverage; failing tests block merge
- Do NOT implement: advanced authorization, complex business logic, frontend code, production scaling

specd's own thesis, for reference: **Agent = Model + Harness.** The harness makes the
plan safely delegable; every harness decision is deterministic and evidence-backed.
<!-- specd:managed:steering/product.md:v3 end -->
