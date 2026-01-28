<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    /**
     * Relationship: A station can have multiple users (owners/admins).
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
