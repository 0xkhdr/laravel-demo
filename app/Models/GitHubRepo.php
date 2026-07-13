<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GitHubRepo extends Model
{
    protected $table = 'github_repos';

    protected $fillable = ['name', 'description', 'url', 'stars', 'forks', 'language', 'updated_at'];

    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];
}
