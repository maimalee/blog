<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $primaryKey = 'friend_id';

    protected $fillable = [
        'user_id',
        'friend_id',
        'status',
    ];
}
