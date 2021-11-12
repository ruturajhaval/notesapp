<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotesTags extends Model
{
    use HasFactory;
    protected $fillable = ['notes_id', 'tags_id'];
}
