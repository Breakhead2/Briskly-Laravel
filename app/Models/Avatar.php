<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    use HasFactory;

    protected $fillabe = ["image_url", "cost"];
    protected $hidden = ["created_at", "updated_at"];

}
