<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
    protected $table = 'likes';

    protected $fillable = [
        'post_id',
        'user_id'
    ];
}
