# Mohamed Khedr — Career Knowledge Base

> Evidence-based career and engineering record  
> Consolidated: October 2026

## 1. Purpose and evidence model

This document is a factual knowledge base about Mohamed Khedr's professional history, engineering domains, technical capabilities, ownership, and selected GitHub repositories. It is designed to support many downstream uses, including portfolios, biographies, interview preparation, project pages, professional profiles, and CVs. It contains no instructions for producing any of those outputs.

Evidence labels used in this document:

- **User-validated:** explicitly confirmed by Mohamed.
- **Repository-verified:** supported by the current repository documentation, manifests, or code structure.
- **Supported inference:** a narrow interpretation derived from validated facts; it is not treated as a measured fact.
- **Unverified:** information that needs additional evidence before it becomes canonical.

Where repository code was substantially produced with AI assistance, the repository's stack and architecture describe the artifact. They do not, by themselves, establish Mohamed's direct implementation proficiency in that language.

**Public-disclosure policy (user-validated, September 2026):** describe employer and project evidence using confidentiality-safe system aliases, approximate ranges, and outcomes; do not require confidential names or exact figures.

## 1.1 Career knowledge representation

Use this document as the canonical fact layer. Portfolio pages, case studies, CV bullets, biographies, and interview notes should be derived from it rather than maintained as competing biographies.

Each substantial experience or project should be represented with these fields, using `none` when a field is not known:

| Field | Meaning |
|---|---|
| Context / problem | The business or engineering situation being addressed |
| Role / ownership | What Mohamed personally owned, contributed to, or directed |
| Collaboration boundary | What was team-owned, infrastructure-owned, or externally provided |
| Architecture / workflow | Systems, boundaries, data flow, and important design choices |
| Stack | Technologies evidenced for this specific work |
| Reliability / quality | Validation, retries, idempotency, observability, testing, or recovery practices |
| Outcome | Verified result, delivery status, or operational effect |
| Scale evidence | Measured figures only; otherwise state that scale is not verified |
| Evidence / confidence | User-validated, repository-verified, supported inference, or unverified |
| Disclosure boundary | Confidentiality-safe wording and any AI-assistance limitation |

Use four complementary views of the same record:

- **Chronology:** when and where the work happened.
- **Capability:** the engineering problem and reusable skill demonstrated.
- **Case study:** problem, decisions, ownership, implementation, and outcome.
- **Evidence ledger:** confidence, source, unknowns, and disclosure constraints.

Portfolio extraction should select the smallest view that answers the purpose: chronology for a CV, capability for a skills page, case study for a project page, and evidence ledger for review or interview preparation. Do not upgrade a repository's technology or architecture into direct professional proficiency without matching ownership evidence.

## 2. Identity

- **Professional name:** Mohamed Khedr
- **Location:** Cairo, Egypt
- **Email:** [0xkhdr@gmail.com](mailto:0xkhdr@gmail.com)
- **Phone:** 01012781205
- **GitHub:** <https://github.com/0xkhdr>
- **Professional experience start:** February 2021
- **Current employer:** Afaqy
- **Current official title:** Mid-Level Backend Engineer

## 2.1 Education

- **Bachelor of Commerce**, Higher Institute of Engineering and Technology in Tanta, 2019.

## 3. Career chronology

| Period | Organization | Official title | Career scope |
|---|---|---|---|
| Feb 2021 – Jul 2021 | Giraffe Code | Fresh Backend Developer | Laravel feature implementation in an established e-commerce architecture |
| Jul 2021 – Jan 2022 | Sectors | Junior Backend Developer | Complete backend and architecture ownership for an online-learning platform |
| Feb 2022 – Apr 2024 | Rowaad | Junior Backend Developer | Independent ownership of multiple production products within a small backend team |
| May 2024 – Present | Afaqy | Mid-Level Backend Engineer | Complex backend architecture, integration, synchronization, and production ownership |
| Dec 2025 – Feb 2026 | Freelance, alongside Afaqy | Backend Engineer | End-to-end backend delivery for a digital-card platform |

## 4. Professional experience

### 4.1 Afaqy

**Context.** Mohamed joined Afaqy in May 2024 as a Mid-Level Backend Engineer. He works within a backend team of more than 15 engineers. Architecture for platform-wide concerns is collaborative; for assigned features and projects, Mohamed often owns the backend solution from business understanding through production support.

**End-to-end ownership.** His responsibility can include understanding the business need, backend design, API and schema design, implementation, integration coordination, testing, rollout, monitoring, debugging, and production support. He collaborates with backend colleagues on architecture understanding and complex issue investigation; this is peer technical support, not formal mentoring or people management.

#### Kafka and Debezium CDC synchronization

- **Domain:** fleet and operational-data synchronization between systems.
- **System boundary:** one operational system acts as the resource holder and system of record. Debezium publishes database changes to Kafka, while independent consumers store the data required by their own business workflows and continue processing independently. User-validated September 2026.
- **Problem:** webhook-based synchronization created stale downstream data and placed request pressure on the system of record. It also led to missed or delayed updates, duplicate processing, manual recovery work, and difficult debugging.
- **Ownership:** the architectural direction was a team decision. Mohamed helped design the architecture and configured Debezium, Kafka Connect, Kafka topics, and independent consumers. User-validated September 2026.
- **Data scope:** operational/master data and relationships required by downstream business workflows.
- **Stack:** Apache Kafka, Debezium, Kafka Connect, PHP, Laravel, MySQL.
- **Architecture:** Debezium captures database changes and publishes them through Kafka. Independent consumers persist the resources needed for their respective business workflows. The wider pipeline uses topics, partitions, consumer groups, event serialization, and transformation.
- **Reliability practices:** lag monitoring and debugging, retries, failed-event handling, schema/payload handling, and near-real-time propagation.
- **Status:** active in production. Built during Mohamed's Afaqy role; exact project dates are intentionally not recorded.
- **Scale evidence:** no verified numeric production-scale metric is currently recorded. Do not publish event-volume, record-count, or customer-count claims until measured.
- **Kafka operations access:** Mohamed primarily accesses the Kafka cluster through Conduktor and Kafka UI. User-validated September 2026.
- **Observed result:** independent consumers now process database-change events without webhook polling or request pressure on the source system. The migration addressed stale data, missed or delayed updates, duplicate processing, manual recovery work, and API pressure; changes generally propagate within seconds.

#### Offline-resilient trip synchronization

- **Domain:** mobile-to-backend synchronization for fleet trips.
- **Problem:** drivers must create trip data while devices are offline and synchronize it after connectivity returns.
- **Ownership:** Mohamed owned the API contract, schema changes, validation architecture, partial-success processing, duplicate prevention, error representation, mobile coordination, testing, rollout, and production support.
- **Stack:** PHP, Laravel, MySQL, mobile local storage, Laravel testing tools.
- **Architecture:** Repository pattern and Service layer; bulk synchronization endpoint; partial-success processing.
- **Patterns and practices:** thin controllers, focused service methods, per-record validation, partial success, duplicate prevention through update-or-create behavior keyed by trip number, failure isolation, and transaction-boundary design.
- **Behavior:** each submitted trip is processed independently. Valid trips are stored; invalid trips, most commonly those with malformed GPS or trip data, are returned by index so the mobile app can remove successfully synchronized records from local storage and retain failed ones. No maximum batch size is claimed because it was not tested.

#### Client onboarding and synchronization

- **Domain:** propagation of client/account data and required operational resources between legacy and operational systems.
- **Ownership:** collaborative design; Mohamed implemented a major part of the flow.
- **Stack:** PHP, Laravel, Kafka, MySQL.
- **Architecture:** event-driven synchronization with some remaining direct dependencies between systems.

#### WASL integration

- **Domain:** transportation-platform integration for Saudi operations.
- **Ownership:** requirements analysis, API/integration design, validation, internal-to-WASL mapping, authentication and security setup, retries, error handling, testing, production rollout, and troubleshooting.
- **Stack:** PHP, Laravel, HTTP APIs, MySQL, application logging.
- **Status:** successfully reached production.

#### Production environment

- **Data and asynchronous work:** MySQL; Redis for caching and queues; Laravel queues and Horizon.
- **Observability:** application and Laravel logs, Sentry, Horizon dashboard.
- **Runtime environment:** Kubernetes. Mohamed inspects pods, logs, deployments, services, and config maps to troubleshoot application behavior; DevOps owns cluster administration and deployment.

### 4.2 Rowaad

**Context.** Mohamed worked at Rowaad from February 2022 through April 2024 as a Junior Backend Developer. The backend team contained four engineers and had no team lead. Engineers carried full responsibility for assigned products.

**Product ownership.** Mohamed was the primary backend owner for six products that reached production: one freelancing marketplace, one digital-card provisioning platform, one services application, and three e-commerce products. He also worked on projects that remained in development and on product variants.

**Responsibility.** For assigned products he handled requirements understanding, backend architecture, MongoDB data modeling, REST API design, implementation, third-party integrations, testing, coordination with frontend and mobile developers, release participation, production debugging, maintenance, and application-level release decisions.

#### Shared Laravel core

- **Domain:** reusable multi-product backend foundation.
- **Starting point:** a shared company Laravel core already existed.
- **Contribution:** Mohamed built products on it and substantially extended its controllers, services, repositories, models, events, authentication, integration abstractions, queries, and scaffolding capabilities.
- **Architecture:** API/controller to service/business behavior to repository to model/data layer, with repository and event behavior where appropriate.
- **Primary outcome:** faster product delivery, with greater consistency and less repeated setup.

#### Wallet, payment, and digital-card workflows

- **Domains:** payments, stored-value wallet, external digital-card fulfillment, order delivery, and compensation.
- **Stack:** PHP, Laravel, MongoDB, Redis, NoonPayments, STC, email, SMS.
- **Payment behavior:** initiation and processing were primarily synchronous; gateway webhooks updated payment status. Provider-issued tokens could be retained for later payments.
- **Digital-card flow:** external inventory check, purchase and fulfillment, order availability, email delivery, and SMS delivery.
- **Compensation:** if fulfillment failed after wallet deduction, the deducted amount could be refunded automatically.
- **Patterns and practices:** service and repository boundaries, transactional decision-making, provider adapters/integration services, webhook processing, and compensating action.

#### Other integrations and production support

- **Integrations:** NoonPayments, STC, Aramex shipment creation and rates, Google Maps, Firebase Cloud Messaging.
- **Production work:** incident debugging, integration failures, data correction, rollback/fix participation, performance investigation, log analysis, and support escalations.
- **Infrastructure boundary:** DevOps owned production infrastructure. Mohamed had production access, handled application and data problems, and directed DevOps toward infrastructure-specific causes when needed.

### 4.3 Sectors

- **Period and title:** July 2021 – January 2022; Junior Backend Developer.
- **Product:** 3almny, an online-learning platform connecting teachers, students, and parents.
- **Ownership:** Mohamed built the complete backend and its architecture from scratch.
- **Stack:** PHP, Laravel, MySQL.
- **Architecture and practices:** REST APIs, relational schema design, Laravel application architecture, service and data-access separation where applicable.
- **Outcome:** the product was still in development when Mohamed left the company; subsequent launch status is unknown.

### 4.4 Giraffe Code

- **Period and title:** February 2021 – July 2021; Fresh Backend Developer.
- **Domain:** e-commerce backend development.
- **Stack:** PHP, Laravel, MySQL, queues, external APIs.
- **Work:** under senior-engineer direction, Mohamed contributed authentication, catalog, cart and order, checkout, payment, notification, external-integration, database, and queued-processing features within an established architecture.

### 4.5 Freelance digital-card platform

- **Period:** December 2025 – February 2026, alongside the Afaqy role.
- **Disclosure boundary:** project name is not recorded; use the confidentiality-safe alias "freelance digital-card platform."
- **Context:** a client required a digital-card platform that could reach production quickly.
- **Ownership:** Mohamed translated the client requirements into backend design, planned the product modules and business workflows, and implemented the backend end to end.
- **Stack and integrations:** PHP, Laravel, PostgreSQL, Redis, queues, Docker, testing, an internal wallet ledger, and El Joker Codes third-party card-provider integration.
- **Reliability practices:** wallet balance updates use database transactions and locking for consistency.
- **Outcome:** reached production within the three-month engagement.

## 5. Engineering domain map

### Backend application architecture

Mohamed's strongest professional foundation is PHP and Laravel backend engineering. His recurring architecture work includes modular backend and modular-monolith concepts, REST APIs, thin controllers, Service layers, Repository abstractions, Action classes, interface-driven integrations, dependency injection, reusable foundations, and transactional workflows.

### Messaging and data synchronization

Professional experience includes Kafka producers and consumers, topics, partitioning, consumer groups, serialization and payload transformation, lag investigation, Debezium connectors, Kafka Connect, change data capture, event-driven synchronization, retries, duplicate/unique work behavior, safe replay, and idempotent synchronization.

### Transactional and reliability design

Mohamed regularly reasons about transaction boundaries, rollback behavior, partial success, retries, backoff, timeouts, failed jobs, rate limiting, job chains and batches, dead-letter/failure handling, duplicate protection, and compensating actions.

### Data engineering within applications

- **MySQL:** professional use at Giraffe Code, Sectors, and Afaqy; schema design, relationships, migrations, ORM queries, raw SQL, and production schema changes.
- **MongoDB:** substantial professional use across Rowaad products; document modeling and application data access.
- **Redis:** production caching and queue workloads at Rowaad and Afaqy.
- **SQLite and PostgreSQL:** present in side-project and AI-assisted tooling contexts; not established as primary professional database expertise.

### Third-party and regulated integrations

Professional work includes payments, digital-card providers, shipping, mapping, push notifications, and WASL. Recurring responsibilities include requirement interpretation, authentication, request/response mapping, provider isolation, webhooks, error handling, retries, testing with mocks/fakes, rollout, and production diagnosis.

### Testing and code quality

- **Primary professional testing:** PHPUnit.
- **Additional direct use:** Pest in open-source and freelance contexts; Mockery when appropriate.
- **Test coverage areas:** unit, feature/API, integration, database, queue/job, event/listener, external API with fakes/mocks, and end-to-end tests.
- **Static quality:** PHPStan, strict PHP typing, PSR-oriented practices, and Laravel Pint mainly in open-source projects.
- **Design principles:** SOLID, separation of concerns, dependency inversion, single responsibility, composition over inheritance, explicit contracts, and YAGNI.

### Development and operations

Mohamed has strong daily Linux and Git capability. Docker and Docker Compose are used mainly for local development and personal/open-source work. He can diagnose Nginx behavior and application problems in Kubernetes environments while respecting the infrastructure ownership boundary. Production observability experience includes logs, Sentry, and Horizon.

### Developer-workflow product direction

Pathframe and Revive show Mohamed's product and architecture direction for local developer workflows: deterministic, recoverable software-change coordination and reproducible development environments. Their implementation is substantially AI-assisted, so this evidence supports product definition, systems thinking, constraints, validation, and release direction; it does not establish direct Go implementation depth equivalent to his PHP/Laravel work.

## 6. GitHub repository knowledge

Repository URL base: <https://github.com/0xkhdr>

### 6.1 Pathframe

- **Repository:** [`0xkhdr/pathframe`](https://github.com/0xkhdr/pathframe)
- **Evidence:** user-validated and repository-verified.
- **Ownership:** product problem, requirements, lifecycle, constraints, technology choice, and validation by Mohamed; implementation largely AI-assisted.
- **Domain:** local, deterministic development-path coordination for humans and coding agents.
- **Purpose:** multi-step coding-agent work can lose its approved plan, scope, current status, and verification evidence as context changes or work is interrupted. Pathframe makes each change visible, constrains execution to approved tasks, records verification separately from completion, and provides a recovery path without relying on a hosted agent platform.
- **Stack:** Go 1.26; standard library only; Markdown and Git as visible sources of truth; static cross-platform binary.
- **Architecture:** layered CLI (`cmd/pathframe`, CLI parsing, command dispatch, decision-owning core, persistence/Git/filesystem); local process with no daemon, model call, network call, or telemetry in the deterministic pipeline.
- **Patterns and principles:** state machine, dependency DAG, command dispatch, one-owner rule for contracts and output, fail-closed validation, append-and-replay ledgers, optimistic revision checks, compare-and-swap behavior, file locks, atomic replacement, transaction record and deterministic recovery, evidence binding, human/agent trust boundary.
- **Quality practices:** journey tests, release gates, generated operation reference, documentation parity checks, scope and concurrency tests, explicit maturity and limitation registry.
- **Status:** current stable product stages are implemented and approved. Production support is Linux AMD64; broader platforms remain documented portability targets with cross-build evidence only.

### 6.2 Revive

- **Repository:** [`0xkhdr/revive`](https://github.com/0xkhdr/revive)
- **Evidence:** user-validated and repository-verified.
- **Ownership:** product concept, requirements, workflows, and architecture direction by Mohamed; implementation largely AI-assisted.
- **Domain:** reproducible developer-environment backup and restoration.
- **Purpose:** make a developer machine reproducible from a version-controlled definition, reducing the time and uncertainty of setup or recovery without a hosted service. It plans changes before applying them, backs up managed files, restores files, templates, packages, and encrypted secrets, verifies the result, and rolls back managed changes on failure.
- **Stack:** current implementation in Go 1.26; Cobra CLI; YAML; age-based encryption dependencies; filesystem and Git integration. The project was originally implemented in Python.
- **Architecture:** manifest-driven CLI; plan, snapshot, apply, verify, and rollback workflow; local state and journal/lock concepts.
- **Patterns and principles:** Command pattern, declarative configuration, transactional restore, rollback/compensation, hooks, adapter-like package installers, verification after mutation, idempotent/repeatable environment convergence.
- **Usage and support boundary:** Mohamed uses Revive regularly for his own development environment. Linux is the tested and supported platform; do not claim support for other platforms without direct validation.

## 7. Ownership and implementation boundaries

### Direct implementation evidence

Mohamed can directly defend the design and low-level implementation of his professional PHP/Laravel work.

### AI-assisted artifact evidence

For Pathframe and Revive, Mohamed's canonical contribution is product and system thinking: problem selection, requirements, workflow, architecture direction, technology choice, validation, and release direction. They are not treated as proof of equivalent low-level Go fluency.

### Adoption and scale

No reliable community-adoption, external-user, download, contributor, or production-adoption metrics are canonical. Repository claims, badges, or package metadata are recorded only when independently verified and should remain separate from personal-impact claims.

## 8. Career knowledge summary

Mohamed Khedr is a Backend Engineer specializing in reliable integrations, data synchronization, and transactional workflows using PHP and Laravel. His career progressed from broad feature implementation, to building a complete backend from scratch, to owning six production products, and then to complex synchronization, integration, offline resilience, and production workflows. His strongest recurring domains are backend architecture, data synchronization, transactional reliability, third-party integration, MongoDB/MySQL application design, queues, and reusable Laravel abstractions.

His selected public engineering work complements this professional record. Pathframe and Revive demonstrate product definition, system architecture, AI-assisted engineering direction, and local developer-workflow problem solving. They do not claim equivalent low-level Go fluency.

## 9. Open factual gaps

The following information remains incomplete and should be added only after validation:

- Measured before/after synchronization metrics permitted for public use.
- Measured impact for WASL and client onboarding.
- Independently verified open-source adoption.
- Technical stack and delivery details permitted for public disclosure for the freelance digital-card platform.
