<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['value', 'answers', 'correct_answer', 'test_id'];
    protected $hidden = ['test_id', 'created_at', 'updated_at'];
}
