<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Feedback;
use App\Models\Employee;

class Interaction extends Model
{
    use HasFactory;

    // Fillable columns for mass assignment
    protected $fillable = [
        'employee_id',
        'customer_name',
        'interaction_type',
        'facial_emotions',
        'voice_emotions',
        'response_time',
        'interaction_duration',
        'presence_score',
        'emotion_score',
        'voice_score',       // make sure this column exists in DB
        'feedback_score',
        'unified_score',     // make sure this column exists in DB
    ];

    /**
     * Relation: Interaction belongs to an Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Relation: Interaction has many Feedbacks
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * Calculate unified score for the interaction
     */
    public function calculateUnifiedScore()
    {
        $this->unified_score =
            ($this->presence_score ?? 0) * 0.25 +
            ($this->emotion_score ?? 0) * 0.25 +
            (is_numeric($this->response_time) ? (100 - $this->response_time) * 0.20 : 0) +
            ($this->feedback_score ?? 0) * 0.20 +
            ($this->voice_score ?? 0) * 0.10;

        $this->save();
    }
}