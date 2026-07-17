<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_all_tasks(): void
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'description', 'status', 'created_at', 'updated_at']
                ]
            ])
            ->assertJsonCount(3, 'data');
    }

    public function test_create_task(): void
    {
        $response = $this->postJson('/api/tasks', [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => 'todo'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'title', 'description', 'status', 'created_at', 'updated_at'])
            ->assertJson([
                'title' => 'Test Task',
                'description' => 'Test Description',
                'status' => 'todo'
            ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task'
        ]);
    }

    public function test_create_task_without_title(): void
    {
        $response = $this->postJson('/api/tasks', [
            'description' => 'No Title'
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors' => ['title']]);
    }

    public function test_create_task_with_long_title(): void
    {
        $response = $this->postJson('/api/tasks', [
            'title' => str_repeat('a', 256),
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors' => ['title']]);
    }

    public function test_get_single_task(): void
    {
        $task = Task::factory()->create(['title' => 'Single Task']);

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $task->id,
                'title' => 'Single Task'
            ]);
    }

    public function test_get_nonexistent_task(): void
    {
        $response = $this->getJson('/api/tasks/99999');

        $response->assertStatus(404);
    }

    public function test_update_task(): void
    {
        $task = Task::factory()->create([
            'title' => 'Old Title',
            'status' => 'todo'
        ]);

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'New Title',
            'status' => 'done'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $task->id,
                'title' => 'New Title',
                'status' => 'done'
            ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'New Title',
            'status' => 'done'
        ]);
    }

    public function test_update_task_status(): void
    {
        $task = Task::factory()->create(['status' => 'todo']);

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'status' => 'in-progress'
        ]);

        $response->assertStatus(200)
            ->assertJson(['status' => 'in-progress']);
    }

    public function test_update_task_with_invalid_status(): void
    {
        $task = Task::factory()->create();

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'status' => 'invalid-status'
        ]);

        $response->assertStatus(422);
    }

    public function test_delete_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);

        $this->assertSoftDeleted('tasks', [
            'id' => $task->id
        ]);
    }

    public function test_delete_nonexistent_task(): void
    {
        $response = $this->deleteJson('/api/tasks/99999');

        $response->assertStatus(404);
    }

    public function test_list_tasks_by_status(): void
    {
        Task::factory()->create(['status' => 'todo']);
        Task::factory()->create(['status' => 'in-progress']);
        Task::factory()->create(['status' => 'done']);

        $response = $this->getJson('/api/tasks?status=todo');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJson([
                'data' => [
                    ['status' => 'todo']
                ]
            ]);
    }

    public function test_task_with_null_description(): void
    {
        $response = $this->postJson('/api/tasks', [
            'title' => 'Task without description'
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'title' => 'Task without description',
                'status' => 'todo'
            ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Task without description',
            'description' => null
        ]);
    }

    public function test_description_with_max_length(): void
    {
        $description = str_repeat('a', 5000);

        $response = $this->postJson('/api/tasks', [
            'title' => 'Test',
            'description' => $description
        ]);

        $response->assertStatus(201);
    }

    public function test_description_exceeds_max_length(): void
    {
        $description = str_repeat('a', 5001);

        $response = $this->postJson('/api/tasks', [
            'title' => 'Test',
            'description' => $description
        ]);

        $response->assertStatus(422);
    }
}
