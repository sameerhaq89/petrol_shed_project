<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN = 1;
    const ROLE_MANAGER = 2;
    const ROLE_CASHIER = 3;
    const ROLE_PUMPER = 4;
    const IS_ACTIVE = 1;
    const IS_INACTIVE = 0;
    const IS_SUSPENDED = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // ADD THESE LINES:
        'role_id',
        'station_id',
        'phone',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean', // Good practice to cast this
    ];

    // ... your existing relationships (role, station) ...
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function hasPermission($permissionSlug)
    {
        if ($this->role_id === 1)
            return true;
        if (!$this->role)
            return false;
        return $this->role->permissions->contains('slug', $permissionSlug);
    }

    public function hasRole($roleSlug)
    {
        return $this->role && $this->role->slug === $roleSlug;
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }
}