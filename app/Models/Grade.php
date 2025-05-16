<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    public $fillable = [
        'id_lesson', 'id_user','answers','score','coef','grade', 'timer'
    ];
}