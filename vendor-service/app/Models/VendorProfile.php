<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VendorProfile extends Model
{
    // Allow mass assignment for your dashboard form fields
    protected $fillable = [
        'user_id', 
        'picture', 
        'description', 
        'opening_time', 
        'closing_time'
    ];

    /**
     * Relationship: A profile belongs to a unique system User account.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: A vendor profile can select multiple business category tags.
     */
    public function tags(): BelongsToMany
    {
        // Explicitly defining the pivot table name used in your shared database
        return $this->belongsToMany(Tag::class, 'tag_vendor_profile');
    }
}