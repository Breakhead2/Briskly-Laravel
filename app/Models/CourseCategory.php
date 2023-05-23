<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    use HasFactory;

    public $table = "courses_categories";
    protected $fillable = ['name', 'complexity_id'];
    protected $hidden = ['complexity_id'];
}
