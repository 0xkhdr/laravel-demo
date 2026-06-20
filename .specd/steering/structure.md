# Structure — Repo layout & module boundaries

> TODO: Fill this in. Always-loaded steering.

## Layout

- `app/` — Core app logic
  - `Actions/` — Business logic classes (one action per class)
  - `Http/Controllers/` — Thin controllers (routing, validation, response)
  - `Http/Requests/` — Form/API request validation rules
  - `Models/` — Eloquent models (Post, User, Comment, Tag)
  - `Events/` — Events triggered by models/actions
  - `Listeners/` — Event handlers
  - `Jobs/` — Queued jobs
  - `Exceptions/` — Custom exception classes
  - `Observers/` — Model lifecycle hooks
- `database/migrations/` — Schema migrations
- `database/seeders/` — Seed data (test fixtures, demo data)
- `routes/` — API routes only (`api.php`)
- `tests/` — Pest tests
  - `Feature/` — HTTP endpoint tests
  - `Unit/` — Business logic tests
- `storage/` — Runtime data (logs, cache if file-based)
- `.specd/` — Spec files and steering (this coordination system)

## Module boundaries

- Controllers call Actions, Actions call Models
- Models use Observers for side effects (not direct queries)
- Events decouple Models from Listeners (e.g., PostCreated → notify subscribers)
- Jobs handle async work (email, heavy compute)
- No "Utils" or "Helpers" — logic lives in Actions or Concerns (traits)
- Tests mock/fake external concerns (mail, storage), test HTTP layer via Controllers

## Naming

- Controllers: `{Model}Controller` (PostController, CommentController)
- Actions: `{Verb}{Model}` (CreatePost, UpdatePost, PublishPost)
- Requests: `{Verb}{Model}Request` (CreatePostRequest, UpdateCommentRequest)
- Events: `{Model}{Verb}` (PostCreated, CommentDeleted)
- Jobs: `{Verb}{Model}` (SendNotification, SyncCache)
- Models: singular, no prefix (Post, User, Comment)
- Tests: match source (app/Actions/CreatePost → tests/Unit/Actions/CreatePostTest)
