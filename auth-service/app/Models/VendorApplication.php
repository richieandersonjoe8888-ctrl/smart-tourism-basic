<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorApplication extends Model
{
    protected $fillable = [
        'user_id',
        'shop_name',
        'physical_address',
        'business_license_number',
        'status',
        'admin_notes'
    ];

    /**
     * Relationship: An application belongs to a specific user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}