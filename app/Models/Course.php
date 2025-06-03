<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_category',
        'title',
        'description',
        'any_blocks',
        'image',
        'author',
        'student_count',
        'test',
        'answers',
        'appl',
        'access'
    ];
}
