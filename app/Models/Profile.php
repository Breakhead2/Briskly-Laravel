<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'surname', 'image_url', 'about_me', 'city', 'date_of_birthday', 'course_id'];
    protected $hidden = ['created_at', 'updated_at'];

}
