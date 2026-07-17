<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;
use Exception;
use Log;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        $query = Task::query();

        if (request()->has('status')) {
            $query->where('status', request('status'));
        }

        $tasks = $query->get()->map->toArray();
        return response()->json(['data' => $tasks]);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {
            $task = Task::create($request->validated());
            $task->refresh();
            return response()->json($task->toArray(), 201);
        } catch (QueryException $e) {
            Log::error('Task creation database error', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Service temporarily unavailable'], 503);
        } catch (Exception $e) {
            Log::error('Task creation error', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function show(Task $task): JsonResponse
    {
        return response()->json($task->toArray());
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        try {
            $task->update($request->validated());
            return response()->json($task->toArray());
        } catch (QueryException $e) {
            Log::error('Task update database error', ['error' => $e->getMessage(), 'task_id' => $task->id]);
            return response()->json(['error' => 'Service temporarily unavailable'], 503);
        } catch (Exception $e) {
            Log::error('Task update error', ['error' => $e->getMessage(), 'task_id' => $task->id]);
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function destroy(Task $task): JsonResponse
    {
        try {
            $task->delete();
            return response()->json(null, 204);
        } catch (QueryException $e) {
            Log::error('Task delete database error', ['error' => $e->getMessage(), 'task_id' => $task->id]);
            return response()->json(['error' => 'Service temporarily unavailable'], 503);
        } catch (Exception $e) {
            Log::error('Task delete error', ['error' => $e->getMessage(), 'task_id' => $task->id]);
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
