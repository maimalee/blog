<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $table = 'tags';
    protected $fillable =[
        'blog_owner',
        'blog_id',
        'tagged_friend',
    ];
    protected $primaryKey = 'tags_id';
}
