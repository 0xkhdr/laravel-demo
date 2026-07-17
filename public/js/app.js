const API_BASE = '/api/tasks';
let currentFilter = 'all';

document.addEventListener('DOMContentLoaded', () => {
    loadTasks();
    setupEventListeners();
});

function setupEventListeners() {
    document.getElementById('taskForm').addEventListener('submit', handleCreateTask);

    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', handleFilterChange);
    });
}

function handleFilterChange(e) {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    e.target.classList.add('active');
    currentFilter = e.target.dataset.filter;
    loadTasks();
}

async function loadTasks() {
    try {
        const url = currentFilter === 'all' ? API_BASE : `${API_BASE}?status=${currentFilter}`;
        const response = await fetch(url);

        if (!response.ok) throw new Error('Failed to load tasks');

        const data = await response.json();
        const tasks = data.data || [];
        renderTasks(tasks);
    } catch (error) {
        showMessage('Error loading tasks: ' + error.message, 'error');
    }
}

function renderTasks(tasks) {
    const container = document.getElementById('tasks');

    if (tasks.length === 0) {
        container.innerHTML = '<p class="empty-state">No tasks found</p>';
        return;
    }

    container.innerHTML = tasks.map(task => `
        <div class="task-item" data-id="${task.id}">
            <div class="task-content">
                <h3>${escapeHtml(task.title)}</h3>
                ${task.description ? `<p>${escapeHtml(task.description)}</p>` : ''}
                <span class="status-badge status-${task.status}">${task.status}</span>
            </div>
            <div class="task-actions">
                <select class="status-select" data-id="${task.id}" onchange="handleStatusChange(this)">
                    <option value="todo" ${task.status === 'todo' ? 'selected' : ''}>Todo</option>
                    <option value="in-progress" ${task.status === 'in-progress' ? 'selected' : ''}>In Progress</option>
                    <option value="done" ${task.status === 'done' ? 'selected' : ''}>Done</option>
                </select>
                <button class="btn-edit" onclick="handleEditTask(${task.id})">Edit</button>
                <button class="btn-delete" onclick="handleDeleteTask(${task.id})">Delete</button>
            </div>
        </div>
    `).join('');
}

async function handleCreateTask(e) {
    e.preventDefault();

    const title = document.getElementById('title').value.trim();
    const description = document.getElementById('description').value.trim();

    if (!title) {
        showMessage('Title is required', 'error');
        return;
    }

    try {
        const response = await fetch(API_BASE, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                title,
                description: description || null,
                status: 'todo'
            })
        });

        if (!response.ok) {
            const error = await response.json();
            throw new Error(error.error || 'Failed to create task');
        }

        document.getElementById('taskForm').reset();
        showMessage('Task created successfully', 'success');
        loadTasks();
    } catch (error) {
        showMessage('Error: ' + error.message, 'error');
    }
}

async function handleStatusChange(select) {
    const taskId = select.dataset.id;
    const newStatus = select.value;

    try {
        const response = await fetch(`${API_BASE}/${taskId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ status: newStatus })
        });

        if (!response.ok) throw new Error('Failed to update status');

        showMessage('Task updated', 'success');
        loadTasks();
    } catch (error) {
        showMessage('Error: ' + error.message, 'error');
        loadTasks();
    }
}

async function handleEditTask(taskId) {
    const newTitle = prompt('Edit task title:');
    if (newTitle === null) return;

    if (!newTitle.trim()) {
        showMessage('Title cannot be empty', 'error');
        return;
    }

    try {
        const response = await fetch(`${API_BASE}/${taskId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ title: newTitle })
        });

        if (!response.ok) throw new Error('Failed to update task');

        showMessage('Task updated', 'success');
        loadTasks();
    } catch (error) {
        showMessage('Error: ' + error.message, 'error');
    }
}

async function handleDeleteTask(taskId) {
    if (!confirm('Are you sure you want to delete this task?')) return;

    try {
        const response = await fetch(`${API_BASE}/${taskId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            }
        });

        if (!response.ok) throw new Error('Failed to delete task');

        showMessage('Task deleted', 'success');
        loadTasks();
    } catch (error) {
        showMessage('Error: ' + error.message, 'error');
    }
}

function showMessage(text, type) {
    const messageEl = document.getElementById('message');
    messageEl.textContent = text;
    messageEl.className = `message message-${type}`;
    setTimeout(() => {
        messageEl.textContent = '';
        messageEl.className = 'message';
    }, 4000);
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
