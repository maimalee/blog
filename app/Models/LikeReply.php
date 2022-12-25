<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeReply extends Model
{
    use HasFactory;
    protected $fillable = [
        'reply_id',
        'blog_id',
        'user_id',
        'comment_id'
    ];
}
