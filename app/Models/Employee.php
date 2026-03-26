<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    // ✅ Mass assignment allowed fields
    protected $fillable = [
        'name',
        'email',
        'phone',
        'shift',
        'branch',
    ];
}