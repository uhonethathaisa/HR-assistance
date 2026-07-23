<?php

namespace App\Traits;

use App\Models\WorkHistory;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Qualification;

trait HasCareerHistory
{
    /**
     * The four career history categories.
     */
    protected array $careerCategories = ['experiences', 'educations', 'skills', 'qualifications'];

    /**
     * Check if user has sufficient career history to access CV Optimizer.
     * Requires at least 2 of 4 categories to be filled.
     */
    public function hasCareerHistory(): bool
    {
        $filledCategories = $this->getFilledCareerCategories();
        return count($filledCategories) >= 2;
    }

    /**
     * Get the percentage of career history completion (0-100).
     */
    public function getCareerHistoryCompletion(): int
    {
        $filledCategories = $this->getFilledCareerCategories();
        return (int) round((count($filledCategories) / 4) * 100);
    }

    /**
     * Get list of missing career fields (categories with no data).
     */
    public function getMissingCareerFields(): array
    {
        $filled = $this->getFilledCareerCategories();
        $all = $this->careerCategories;

        $missing = array_diff($all, $filled);

        $labels = [
            'experiences' => 'Work Experience',
            'educations' => 'Education',
            'skills' => 'Skills',
            'qualifications' => 'Certifications & Qualifications',
        ];

        $result = [];
        foreach ($missing as $key) {
            $result[$key] = $labels[$key] ?? $key;
        }

        return $result;
    }

    /**
     * Get filled career categories.
     */
    public function getFilledCareerCategories(): array
    {
        $filled = [];

        if (WorkHistory::where('user_id', $this->id)->count() > 0) {
            $filled[] = 'experiences';
        }

        if (Education::where('user_id', $this->id)->count() > 0) {
            $filled[] = 'educations';
        }

        if (Skill::where('user_id', $this->id)->count() > 0) {
            $filled[] = 'skills';
        }

        if (Qualification::where('user_id', $this->id)->count() > 0) {
            $filled[] = 'qualifications';
        }

        return $filled;
    }

    /**
     * Get counts for each career category.
     */
    public function getCareerCategoryCounts(): array
    {
        return [
            'experiences' => WorkHistory::where('user_id', $this->id)->count(),
            'educations' => Education::where('user_id', $this->id)->count(),
            'skills' => Skill::where('user_id', $this->id)->count(),
            'qualifications' => Qualification::where('user_id', $this->id)->count(),
        ];
    }
}
