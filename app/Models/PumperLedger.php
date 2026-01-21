<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PumperLedger extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'assignment_id',
        'type', // 'shortage' or 'payment'
        'amount',
        'running_balance',
        'remarks',
    ];

    /**
     * Relationship to the Pumper (User)
     */
    public function pumper()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship to the specific Assignment
     */
    public function assignment()
    {
        return $this->belongsTo(PumpOperatorAssignment::class, 'assignment_id');
    }
}
