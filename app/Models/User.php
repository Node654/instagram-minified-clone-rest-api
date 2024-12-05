<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'login',
        'avatar',
        'is_verified',
        'about',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean'
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function subscribers(): HasMany
    {
        return $this->hasMany(Subscriber::class, 'user_id', 'id');
    }

    public function postsCount(): int
    {
        return $this->posts()->count();
    }

    public function subscribersCount(): int
    {
        return $this->subscribers()->count();
    }
}
