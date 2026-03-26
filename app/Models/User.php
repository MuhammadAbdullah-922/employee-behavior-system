<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role; // add this

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // add role_id here
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relationship: A user belongs to a role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Helper methods to check role quickly
     */
    public function isAdmin()
    {
        return $this->role && $this->role->name === 'Admin';
    }

    public function isManager()
    {
        return $this->role && $this->role->name === 'Branch Manager';
    }

    public function isSupervisor()
    {
        return $this->role && $this->role->name === 'Supervisor';
    }
}