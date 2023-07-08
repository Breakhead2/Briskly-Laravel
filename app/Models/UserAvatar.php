<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAvatar extends Model
{
    use HasFactory;

    protected $table = "users_avatars";
    protected $fillable = ["avatar_id", "user_id"];
    protected $hidden = ["created_at", "updated_at", "id"];
}
