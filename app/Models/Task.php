<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function scopeWhereStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeByStatus($query, $status)
    {
        return $this->scopeWhereStatus($query, $status);
    }

    public function scopeTodo($query)
    {
        return $query->where('status', 'todo');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in-progress');
    }

    public function scopeDone($query)
    {
        return $query->where('status', 'done');
    }
}
