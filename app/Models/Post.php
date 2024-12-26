<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'photo',
        'description',
    ];

    protected $table = 'posts';

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'post_id', 'id');
    }

    public function totalLikes(): int
    {
        return $this->likes()->count();
    }

    public function isLiked(): bool
    {
        return Like::query()->where('user_id', auth()->id())->exists();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function totalComments(): int
    {
        return $this->comments()->count();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
