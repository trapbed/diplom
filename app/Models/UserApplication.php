<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserApplication extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'status_user',
        'date',
        'status_appl'
    ];
}
