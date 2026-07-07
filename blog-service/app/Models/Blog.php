<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    // Ensure 'image' is present to save your local file names
    protected $fillable = ['user_id', 'title', 'content', 'image', 'status'];

    /**
     * Relationship: A blog post belongs to an authoring user account.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}