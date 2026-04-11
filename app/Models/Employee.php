<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Employee extends Model
{
    use HasFactory;

    // ✅ Mass assignment allowed fields
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role_id',
    ];

    // ✅ Relationship FIX
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}