<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $table = 'likes';
    protected $fillable =[
        'blog_id',
        'user_id',
    ];

    protected $primaryKey = 'likes_id';
}
