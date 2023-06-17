<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLesson extends Model
{
    use HasFactory;

    public $table = "users_lessons";
    protected $fillable = ['user_id', 'lesson_id'];
}
