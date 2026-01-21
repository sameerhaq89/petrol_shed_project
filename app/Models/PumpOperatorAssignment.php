<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PumpOperatorAssignment extends Model
{
    protected $guarded = [];

    public function pumper() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pump() {
        return $this->belongsTo(Pump::class);
    }
    
    public function shift() {
        return $this->belongsTo(Shift::class);
    }
}