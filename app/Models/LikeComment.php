<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeComment extends Model
{
    use HasFactory;
    protected $table = 'like_comments';
    protected $fillable = [
        'comment_id',
        'user_id',
        'blog_id',
    ];
}
