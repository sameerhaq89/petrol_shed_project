<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'tank_id',
        'type',
        'quantity',
        'balance_after',
        'reference_type',
        'reference_id',
        'reference_number',
        'recorded_at',
    ];
}
