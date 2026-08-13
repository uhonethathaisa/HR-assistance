<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    protected $fillable = [
        'title',
        'company_name',
        'location',
        'description',
        'apply_url',
        'source',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active job postings.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
