<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CVOptimization extends Model
{
    protected $table = 'cv_optimizations';

    protected $fillable = [
        'user_id',
        'original_filename',
        'original_path',
        'job_description',
        'optimized_path',
        'optimized_content',
        'ats_score',
        'ats_breakdown',
        'keyword_density',
        'matched_keywords',
        'missing_keywords',
        'suggestions',
        'optimized_experiences',
        'optimized_skills',
        'professional_summary',
        'target_job_title',
        'target_company',
        'status',
    ];

    protected $casts = [
        'keyword_density' => 'array',
        'suggestions' => 'array',
        'ats_breakdown' => 'array',
        'matched_keywords' => 'array',
        'missing_keywords' => 'array',
        'optimized_experiences' => 'array',
        'optimized_skills' => 'array',
        'ats_score' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
