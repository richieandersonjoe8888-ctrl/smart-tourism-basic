<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'age',
        'gender',
        'country_of_origin',
        'city_of_origin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relationship: A user can belong to multiple roles.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Helper: Check if the user has a specific role.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->roles->contains('name', $roleName);
    }

    /**
     * Helper: Assign a role to a user.
     */
    public function assignRole(string $roleName): void
    {
        $role = Role::where('name', $roleName)->first();
        if ($role) {
            $this->roles()->syncWithoutDetaching([$role->id]);
        }
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function vendorApplication()
    {
        return $this->hasOne(VendorApplication::class);
    }
}
