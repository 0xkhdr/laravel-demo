<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Todo App</h1>
        </header>

        <main>
            <section class="filters">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="todo">Todo</button>
                <button class="filter-btn" data-filter="in-progress">In Progress</button>
                <button class="filter-btn" data-filter="done">Done</button>
            </section>

            <section class="task-form">
                <h2>Create Task</h2>
                <form id="taskForm">
                    <div class="form-group">
                        <label for="title">Title *</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn-primary">Add Task</button>
                </form>
            </section>

            <section class="task-list">
                <h2>Tasks</h2>
                <div id="tasks" class="tasks-container">
                    <!-- Tasks populated by JS -->
                </div>
            </section>

            <div id="message" class="message"></div>
        </main>
    </div>

    <script src="/js/app.js"></script>
</body>
</html>
