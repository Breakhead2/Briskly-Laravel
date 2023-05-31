<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['heading', 'text', 'tags', 'course_id', 'exercise_id'];
    protected $hidden = ['course_id', 'exercise_id'];
}
