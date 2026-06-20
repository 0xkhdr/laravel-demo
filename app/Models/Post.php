<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\PostObserver;

class Post extends Model
{
    use HasFactory;

    /**
     * The "booting" method of the model.
     *
     * Register model observers to handle cache invalidation on model events.
     */
    protected static function boot(): void
    {
        parent::boot();

        // Register the PostObserver to handle cache invalidation
        static::observe(PostObserver::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];

    /**
     * Get the author of the post.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
