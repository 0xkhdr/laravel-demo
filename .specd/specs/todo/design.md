# Design — todo

**Thesis**: Minimal Laravel-based todo app that demonstrates full-stack web development with clean separation of concerns: REST API backend, responsive frontend, persistent storage, and intuitive UX.

**Tech Stack**:
- Backend: Laravel 11+ (PHP framework)
- Frontend: HTML5 + CSS3 + Vanilla JavaScript (no SPA framework)
- Database: MySQL/SQLite (configured per environment)
- Web Server: Laravel built-in dev server or production deployment (Nginx/Apache)

---

## Architecture

```
todo-app/
├── app/
│   ├── Models/          # Eloquent Task model
│   ├── Controllers/     # API routes & request handling
│   └── Requests/        # Form request validation
├── database/
│   ├── migrations/      # Schema: tasks table
│   └── factories/       # Test data generation
├── routes/
│   └── api.php          # RESTful endpoints
├── resources/
│   ├── views/           # Blade templates (minimal)
│   └── css/             # Tailwind CSS or custom styles
├── public/
│   └── js/              # Frontend interactivity
└── tests/               # Feature & unit tests
```

---

## API Design

RESTful JSON API with 5 core endpoints for task CRUD operations. Consistent response format with proper HTTP status codes and error handling. All endpoints require Content-Type: application/json for requests and return application/json responses.

### Endpoints

| Method | Path | Purpose |
|--------|------|---------|
| GET | /api/tasks | List all tasks (optionally filter by status) |
| POST | /api/tasks | Create new task |
| GET | /api/tasks/{id} | Fetch single task |
| PUT | /api/tasks/{id} | Update task (title, description, status) |
| DELETE | /api/tasks/{id} | Delete task |

### Request/Response Format

**POST /api/tasks** (Create)
```json
Request:
{
  "title": "Buy groceries",
  "description": "Milk, eggs, bread",
  "status": "todo"
}

Response (201):
{
  "id": 1,
  "title": "Buy groceries",
  "description": "Milk, eggs, bread",
  "status": "todo",
  "created_at": "2026-07-17T10:30:00Z",
  "updated_at": "2026-07-17T10:30:00Z"
}
```

**GET /api/tasks?status=todo** (List with filter)
```json
Response (200):
{
  "data": [
    { "id": 1, "title": "Buy groceries", "description": "...", "status": "todo", "created_at": "...", "updated_at": "..." },
    { "id": 2, "title": "Call dentist", "description": "", "status": "todo", "created_at": "...", "updated_at": "..." }
  ]
}
```

**PUT /api/tasks/{id}** (Update)
```json
Request:
{
  "status": "done"
}

Response (200):
{
  "id": 1,
  "title": "Buy groceries",
  "description": "...",
  "status": "done",
  "created_at": "...",
  "updated_at": "2026-07-17T11:15:00Z"
}
```

**DELETE /api/tasks/{id}** (Delete)
```json
Response (204): No content
```

---

## Database Schema

**tasks** table:
- `id` (bigint, PK, auto-increment)
- `title` (string, 255, NOT NULL)
- `description` (text, nullable)
- `status` (enum: 'todo', 'in-progress', 'done', default 'todo')
- `created_at` (timestamp)
- `updated_at` (timestamp)
- `deleted_at` (timestamp, nullable, soft deletes support)

---

## Frontend Design

**Single-page app** (no page reloads):
- Task list view with inline edit/delete actions
- Create task form (collapsible or always visible)
- Filter tabs (All / Todo / In Progress / Done)
- Real-time UI updates via fetch API
- Loading indicators and error messages
- Responsive grid: 1 col (mobile), 2 col (tablet), 1 wide col (desktop)

**Accessibility**:
- Semantic HTML
- ARIA labels on interactive elements
- Keyboard navigation (Tab, Enter, Escape)
- Color contrast WCAG AA

---

## Error Handling

| Status | Scenario | Response |
|--------|----------|----------|
| 400 | Missing required field (title) | `{"error": "Title is required"}` |
| 404 | Task not found | `{"error": "Task not found"}` |
| 422 | Validation failed | `{"errors": {"title": ["Max 255 characters"]}}` |
| 500 | Server error | `{"error": "Internal server error"}` |
| 503 | DB unavailable | `{"error": "Service temporarily unavailable"}` |

---

## Data Validation

- **Title**: 1–255 characters, required, trim whitespace
- **Description**: 0–5000 characters, optional
- **Status**: One of ["todo", "in-progress", "done"], case-insensitive on input
- **ID**: Positive integer, must exist in DB for update/delete

---

## Testing Strategy

- **Unit**: Model methods, validation rules
- **Feature**: API endpoints (create/read/update/delete)
- **Browser**: Manual UI testing (or Dusk for automation)
- **Load**: Concurrent task creation (basic smoke test)

> Replace prompts. Trace every decision to approved requirement IDs.

references: <R1, R1.1>
disposition: <accepted|deferred|rejected>
owner: <human decision owner>

## Boundaries

- <owned modules and excluded responsibilities>

## Interfaces

- <API, file, or protocol contracts>

## Invariants

- <property preserved across success and failure>

## Failure

- <failure mode, containment, recovery>

## Integration

- <dependency and compatibility behavior>

## Alternatives

- <option and reason accepted/rejected/deferred>

## Verification

- <proof for each invariant and interface>

## Deployment

- <rollout, observation, ownership>

## Rollback

- <trigger and safe restoration path>
