<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'type',
        'title',
        'content',
        'comments',
        'timer',
        'posititon'
    ];
}
