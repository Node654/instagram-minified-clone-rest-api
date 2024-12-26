<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\SubscribedState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

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

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_verified' => 'boolean',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function subscribers(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Subscriber::class, 'user_id', 'id', 'id', 'subscriber_id');
    }

    public function postsCount(): int
    {
        return $this->posts()->count();
    }

    public function subscribersCount(): int
    {
        return $this->subscribers()->count();
    }

    public function isSubscribedCurrentUser(): bool
    {
        return Subscriber::query()->where('user_id', $this->id)->where('subscriber_id', auth()->id())->exists();
    }

    public function isSubscribed(): bool
    {
        return Subscriber::query()->where('user_id', $this->id)->where('subscriber_id', $this->laravel_through_key)->exists();
    }

    public function subscribe(): string
    {
        $subscribe = Subscriber::query()->where([
            'user_id' => $this->id,
            'subscriber_id' => auth()->id(),
        ])->first();

        if (is_null($subscribe)) {
            Subscriber::query()->create([
                'user_id' => $this->id,
                'subscriber_id' => auth()->id(),
            ]);

            return SubscribedState::Subscribed->value;
        }

        $subscribe->delete();

        return SubscribedState::Unsubscribed->value;
    }
}
