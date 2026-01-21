<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashDrop extends Model
{
    use HasFactory;

    protected $fillable = ['shift_id', 'user_id', 'amount', 'notes', 'dropped_at', 'status', 'received_by'];

    // Define relationships
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}