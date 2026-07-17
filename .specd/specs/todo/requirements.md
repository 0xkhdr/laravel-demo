# Requirements — todo

> Minimal yet complete todo web application with full CRUD, filtering, persistence, and intuitive UI.

## Requirement R1 — Task Lifecycle Management

owner: product
priority: must
risk: medium

- **R1.1** When user creates a task with title and optional description, the system shall persist task with status "todo" and return unique identifier.
- **R1.2** When user requests all tasks, the system shall return list of tasks with all attributes (id, title, description, status, created_at, updated_at).
- **R1.3** When user updates task title, description, or status, the system shall persist changes and return updated task.
- **R1.4** When user deletes task, the system shall remove it permanently and confirm deletion.

### Failure & Edge Cases
Empty or null title rejected; return 400 error. Non-existent task ID returns 404. Concurrent updates use last-write-wins with timestamp comparison. Description field optional; defaults to empty string.

### Out of Scope
Task priority levels, due dates, multi-user collaboration, task history, recurring tasks, subtasks.

---

## Requirement R2 — Task State Management

owner: product
priority: must
risk: low

- **R2.1** When user views tasks, the system shall support filtering by status: "todo", "in-progress", "done".
- **R2.2** When system displays all tasks, it shall show tasks grouped by current status or sortable by status.
- **R2.3** When user marks task "done", the system shall persist status change and reflect immediately in UI.

### Failure & Edge Cases
Invalid status values rejected with 400 error. Default view shows all tasks. State transitions allowed from any state to any state (no restrictions).

### Out of Scope
Workflow states, status validation rules, automatic state transitions.

---

## Requirement R3 — Data Persistence

owner: backend
priority: must
risk: medium

- **R3.1** When system starts, the system shall load all tasks from persistent storage without data loss.
- **R3.2** When task is created/updated/deleted, the system shall persist change to database within 1 second.
- **R3.3** When database query fails, the system shall return meaningful error response and not corrupt stored data.

### Failure & Edge Cases
Database connection loss returns 503 error. Transaction rollback on write failure. No partial writes.

### Out of Scope
Caching layer, read replicas, backup/restore automation.

---

## Requirement R4 — Web User Interface

owner: frontend
priority: must
risk: low

- **R4.1** When user loads application, the system shall display responsive web interface showing current task list.
- **R4.2** When user interacts with task (create/update/delete/status-change), the system shall provide visual feedback (success/error message) and update display without page reload.
- **R4.3** When screen size changes, the system shall adapt layout for mobile (320px+), tablet (768px+), and desktop (1024px+).

### Failure & Edge Cases
Network error shows user-friendly message. Degraded mode: form still functional without JavaScript (optional).

### Out of Scope
Dark mode, theme switching, keyboard shortcuts, drag-and-drop reordering.

---

## Requirement R5 — API Contracts

owner: backend
priority: must
risk: low

- **R5.1** When client makes REST request to /api/tasks, the system shall respond with JSON schema consistent across all endpoints.
- **R5.2** When request succeeds, response includes HTTP 2xx status and task data.
- **R5.3** When request fails, response includes HTTP 4xx/5xx status and error message.

### Failure & Edge Cases
Malformed JSON request returns 400. Missing required fields returns 400. Unknown endpoints return 404.

### Out of Scope
GraphQL support, webhook notifications, API rate limiting (v1).
