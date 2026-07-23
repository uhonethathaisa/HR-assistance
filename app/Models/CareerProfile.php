<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'target_job_title',
        'industry',
        'years_of_experience',
        'tech_stack',
        'resume_path',
    ];

    protected function casts(): array
    {
        return [
            'tech_stack' => 'array',
            'years_of_experience' => 'integer',
        ];
    }

    /**
     * Get the user that owns the career profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
