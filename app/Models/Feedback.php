<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Interaction;
use App\Models\Employee;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'interaction_id',
        'employee_id',
        'customer_rating',
        'comments',
    ];

    // Relation to Interaction
    public function interaction()
    {
        return $this->belongsTo(Interaction::class);
    }

    // Relation to Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}