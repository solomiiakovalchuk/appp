<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['parent_id', 'user_id', 'post_id', 'comment', 'is_active'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}

