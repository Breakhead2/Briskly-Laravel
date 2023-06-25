<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    protected $fillable = ['value', 'translate', 'transcription', 'image', 'article_id'];
    protected $hidden = ['created_at', 'updated_at', 'article_id'];
}
