<!-- specd:managed:steering/product.md:v2 begin -->
# Steering: Product

> Fill this in for your project. The harness reads it to keep work aligned with
> intent. Replace the prompts below.

## Thesis
- **What this product is:** Minimal production-ready Laravel 13 REST API demonstrating public data endpoints, queue management, and containerized deployment
- **Who it is for:** Developers learning Laravel patterns at scale; teams benchmarking REST API structure and Docker multi-service setup

## Principles
- **Public read-only API only** — no authentication, no mutations. Scope is deliberate: teach, not a full-featured service
- **Models own logic** — controllers are thin routers. All business rules live in Eloquent models
- **Pest over PHPUnit** — expressive, concise test syntax. Mandatory for all tests
- **SQLite in-memory for tests** — no container startup overhead during development/CI
- **Migrations are immutable** — never edit existing migrations; create new ones for changes
- **Config drives behavior** — no hardcoded values; all env-sensitive logic uses config/
- **Docker is mandatory** — production, staging, and dev all run containerized; single-image multi-service stack
- **Horizon watches one queue** — async jobs dispatch to `default` queue only; Horizon picks them up automatically

specd's own thesis, for reference: **Agent = Model + Harness.** The harness makes the
plan safely delegable; every harness decision is deterministic and evidence-backed.
<!-- specd:managed:steering/product.md:v2 end -->
