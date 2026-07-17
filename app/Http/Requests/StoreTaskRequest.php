<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'status' => 'sometimes|in:todo,in-progress,done',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.max' => 'Title must not exceed 255 characters',
            'description.max' => 'Description must not exceed 5000 characters',
            'status.in' => 'Status must be one of: todo, in-progress, done',
        ];
    }
}
