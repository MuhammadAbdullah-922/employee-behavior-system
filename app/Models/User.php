<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * Hidden fields for security
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relationship: User belongs to Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * ================= ROLE HELPERS =================
     */

    // ADMIN CHECK
    public function isAdmin()
    {
        return $this->role && $this->role->name === 'Admin';
    }

    // EMPLOYEE CHECK
    public function isEmployee()
    {
        return $this->role && $this->role->name === 'Employee';
    }

    // SUPERVISOR CHECK
    // public function isSupervisor()
    // {
    //     return $this->role && $this->role->name === 'Supervisor';
    // }

    // // BRANCH MANAGER CHECK
    // public function isManager()
    // {
    //     return $this->role && $this->role->name === 'Branch Manager';
    // }
}