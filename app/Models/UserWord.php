<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWord extends Model
{
    use HasFactory;

    protected $table = "users_words";
    protected $fillable = ['user_id', 'word_id'];
    protected $hidden = ['created_at', 'updated_at'];
}
