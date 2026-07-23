<?php
// app/Services/CVOptimizationService.php

namespace App\Services;

use App\Services\DeepSeekService;
use Illuminate\Support\Facades\Log;

class CVOptimizationService
{
    protected $deepSeek;

    public function __construct()
    {
        $this->deepSeek = new DeepSeekService();
    }

    public function optimizeCV($experiences, $educations, $skills, $qualifications, $jobDescription)
    {
        // Build CV summary
        $cvSummary = $this->buildCVSummary($experiences, $educations, $skills, $qualifications);

        // Calculate ATS score
        $atsScore = $this->calculateATSScore($cvSummary, $jobDescription);

        // Generate optimized content
        $optimizedContent = $this->generateOptimizedContent($cvSummary, $jobDescription);

        return [
            'ats_score' => $atsScore['overall'] ?? 0,
            'ats_breakdown' => $atsScore['breakdown'] ?? [],
            'optimized_experiences' => $optimizedContent['experiences'] ?? [],
            'optimized_skills' => $optimizedContent['skills'] ?? [],
            'suggestions' => $optimizedContent['suggestions'] ?? [],
            'missing_keywords' => $atsScore['missing_keywords'] ?? [],
            'matched_keywords' => $atsScore['matched_keywords'] ?? [],
            'optimized_summary' => $optimizedContent['summary'] ?? $this->generateSummary($cvSummary),
        ];
    }

    protected function buildCVSummary($experiences, $educations, $skills, $qualifications)
    {
        return [
            'experiences' => $experiences ?? [],
            'educations' => $educations ?? [],
            'skills' => $skills ?? [],
            'qualifications' => $qualifications ?? [],
        ];
    }

    protected function calculateATSScore($cvSummary, $jobDescription)
    {
        // Extract keywords
        $jobKeywords = $this->extractKeywords($jobDescription);
        $cvKeywords = $this->extractKeywordsFromCV($cvSummary);

        // Calculate matches
        $matched = array_intersect($jobKeywords, $cvKeywords);
        $missing = array_diff($jobKeywords, $cvKeywords);

        $keywordMatchScore = count($matched) / max(count($jobKeywords), 1) * 100;

        // Calculate individual scores
        $scores = [
            'keywords' => min($keywordMatchScore, 100),
            'skills' => $this->calculateSkillsScore($cvSummary['skills'] ?? [], $jobDescription),
            'experience' => $this->calculateExperienceScore($cvSummary['experiences'] ?? [], $jobDescription),
            'education' => $this->calculateEducationScore($cvSummary['educations'] ?? [], $jobDescription),
            'format' => $this->calculateFormatScore(),
        ];

        $overall = array_sum($scores) / count($scores);

        return [
            'overall' => round($overall, 0),
            'breakdown' => $scores,
            'matched_keywords' => array_slice($matched, 0, 10),
            'missing_keywords' => array_slice($missing, 0, 10),
        ];
    }

    protected function extractKeywords($text)
    {
        if (empty($text)) return [];

        // Clean and extract keywords
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);
        $words = array_filter(explode(' ', $text), function($word) {
            return strlen($word) > 2;
        });

        // Remove common stop words
        $stopWords = ['the', 'and', 'for', 'are', 'but', 'not', 'you', 'all', 'can', 'had', 'her', 'was', 'one', 'our', 'out', 'who', 'get', 'has', 'him', 'his', 'how', 'its', 'may', 'see', 'she', 'two', 'way', 'will', 'with', 'without', 'about', 'after', 'also', 'any', 'because', 'been', 'between', 'both', 'even', 'every', 'from', 'have', 'into', 'more', 'only', 'other', 'some', 'than', 'that', 'their', 'them', 'then', 'there', 'these', 'they', 'this', 'through', 'under', 'very'];
        $keywords = array_diff($words, $stopWords);

        return array_values(array_unique($keywords));
    }

    protected function extractKeywordsFromCV($cvSummary)
    {
        $text = '';

        // Extract from experiences
        if (!empty($cvSummary['experiences'])) {
            foreach ($cvSummary['experiences'] as $exp) {
                $text .= ($exp['job_title'] ?? '') . ' ';
                $text .= ($exp['company_name'] ?? '') . ' ';
                $text .= ($exp['description'] ?? '') . ' ';
            }
        }

        // Extract from skills
        if (!empty($cvSummary['skills'])) {
            foreach ($cvSummary['skills'] as $skill) {
                $text .= ($skill['name'] ?? '') . ' ';
            }
        }

        // Extract from qualifications
        if (!empty($cvSummary['qualifications'])) {
            foreach ($cvSummary['qualifications'] as $qual) {
                $text .= ($qual['name'] ?? '') . ' ';
            }
        }

        return $this->extractKeywords($text);
    }

    protected function calculateSkillsScore($skills, $jobDescription)
    {
        if (empty($skills)) return 0;

        $jobKeywords = $this->extractKeywords($jobDescription);
        $skillNames = array_column($skills, 'name');
        $skillNames = array_map('strtolower', $skillNames);

        $matched = 0;
        foreach ($jobKeywords as $keyword) {
            foreach ($skillNames as $skill) {
                if (strpos($skill, $keyword) !== false || strpos($keyword, $skill) !== false) {
                    $matched++;
                    break;
                }
            }
        }

        return count($jobKeywords) > 0 ? min(($matched / count($jobKeywords)) * 100, 100) : 0;
    }

    protected function calculateExperienceScore($experiences, $jobDescription)
    {
        if (empty($experiences)) return 0;

        // Calculate years of experience
        $totalYears = 0;
        foreach ($experiences as $exp) {
            $start = isset($exp['start_date']) ? strtotime($exp['start_date']) : time();
            $end = isset($exp['end_date']) ? strtotime($exp['end_date']) : time();
            $totalYears += max(0, ($end - $start) / (365 * 24 * 60 * 60));
        }

        // Score based on experience (max 100)
        return min($totalYears / 10 * 100, 100);
    }

    protected function calculateEducationScore($educations, $jobDescription)
    {
        if (empty($educations)) return 0;

        // Check highest degree
        $score = 0;
        foreach ($educations as $edu) {
            $degree = strtolower($edu['degree'] ?? '');
            if (strpos($degree, 'phd') !== false || strpos($degree, 'doctorate') !== false) {
                $score = max($score, 100);
            } elseif (strpos($degree, 'master') !== false || strpos($degree, 'mba') !== false) {
                $score = max($score, 90);
            } elseif (strpos($degree, 'bachelor') !== false || strpos($degree, 'bs') !== false || strpos($degree, 'ba') !== false) {
                $score = max($score, 80);
            } elseif (strpos($degree, 'associate') !== false) {
                $score = max($score, 60);
            } else {
                $score = max($score, 40);
            }
        }

        return $score;
    }

    protected function calculateFormatScore()
    {
        return 85; // Default good score
    }

    protected function generateOptimizedContent($cvSummary, $jobDescription)
    {
        try {
            // Try to use AI for optimization
            $prompt = $this->buildOptimizationPrompt($cvSummary, $jobDescription);
            $result = $this->deepSeek->callAPI($prompt);

            if ($result && isset($result['choices'][0]['message']['content'])) {
                $content = $result['choices'][0]['message']['content'];
                preg_match('/\{[\s\S]*\}/', $content, $jsonMatch);
                $json = $jsonMatch[0] ?? '{}';
                $parsed = json_decode($json, true);

                if (json_last_error() === JSON_ERROR_NONE && !empty($parsed)) {
                    return [
                        'experiences' => $parsed['experiences'] ?? $this->optimizeExperiences($cvSummary['experiences'] ?? [], $jobDescription),
                        'skills' => $parsed['skills'] ?? ($cvSummary['skills'] ?? []),
                        'suggestions' => $parsed['suggestions'] ?? $this->getDefaultSuggestions(),
                        'summary' => $parsed['summary'] ?? $this->generateSummary($cvSummary),
                    ];
                }
            }

            // Fallback if AI fails
            return $this->getFallbackOptimization($cvSummary, $jobDescription);

        } catch (\Exception $e) {
            Log::error('CV Optimization AI error: ' . $e->getMessage());
            return $this->getFallbackOptimization($cvSummary, $jobDescription);
        }
    }

    protected function getFallbackOptimization($cvSummary, $jobDescription)
    {
        return [
            'experiences' => $this->optimizeExperiences($cvSummary['experiences'] ?? [], $jobDescription),
            'skills' => $cvSummary['skills'] ?? [],
            'suggestions' => $this->getDefaultSuggestions(),
            'summary' => $this->generateSummary($cvSummary),
        ];
    }

    protected function getDefaultSuggestions()
    {
        return [
            'Add more keywords from the job description to improve ATS score.',
            'Quantify your achievements with metrics (e.g., "Increased sales by 20%").',
            'Ensure your skills section matches the job requirements.',
            'Use action verbs to start each bullet point.',
            'Keep bullet points concise and impactful (1-2 lines).'
        ];
    }

    protected function generateSummary($cvSummary)
    {
        $skills = array_column($cvSummary['skills'] ?? [], 'name');
        $skillString = implode(', ', array_slice($skills, 0, 5));
        $jobTitles = array_column($cvSummary['experiences'] ?? [], 'job_title');
        $titleString = implode(' → ', array_slice($jobTitles, 0, 3));

        if (empty($skillString) && empty($titleString)) {
            return 'Professional with diverse experience and skills.';
        }

        if (empty($skillString)) {
            return "Professional with experience as {$titleString}.";
        }

        if (empty($titleString)) {
            return "Professional skilled in {$skillString}.";
        }

        return "Professional with experience as {$titleString}, skilled in {$skillString}.";
    }

    protected function optimizeExperiences($experiences, $jobDescription)
    {
        if (empty($experiences)) return [];

        $optimized = [];
        foreach ($experiences as $exp) {
            $optimized[] = [
                'job_title' => $exp['job_title'] ?? '',
                'company_name' => $exp['company_name'] ?? '',
                'start_date' => $exp['start_date'] ?? '',
                'end_date' => $exp['end_date'] ?? '',
                'optimized_bullets' => $this->generateBulletPoints($exp, $jobDescription),
            ];
        }
        return $optimized;
    }

    protected function generateBulletPoints($experience, $jobDescription)
    {
        $bullets = [];
        $keywords = $this->extractKeywords($jobDescription);
        $keywords = array_slice($keywords, 0, 5);

        $description = $experience['description'] ?? '';
        if ($description) {
            $sentences = explode('.', $description);
            foreach ($sentences as $sentence) {
                $sentence = trim($sentence);
                if (strlen($sentence) > 20) {
                    $hasKeyword = false;
                    foreach ($keywords as $keyword) {
                        if (stripos($sentence, $keyword) !== false) {
                            $hasKeyword = true;
                            break;
                        }
                    }
                    $bullet = ucfirst($sentence) . '.';
                    if ($hasKeyword) {
                        $bullet = '⭐ ' . $bullet;
                    }
                    $bullets[] = $bullet;
                }
            }
        }

        if (empty($bullets)) {
            $bullets = [
                'Led key projects and initiatives.',
                'Collaborated with cross-functional teams.',
                'Delivered results within deadlines.',
            ];
        }

        return array_slice($bullets, 0, 5);
    }

    protected function buildOptimizationPrompt($cvSummary, $jobDescription)
    {
        $data = [
            'cv_summary' => [
                'experiences' => array_map(function($exp) {
                    return [
                        'job_title' => $exp['job_title'] ?? '',
                        'company_name' => $exp['company_name'] ?? '',
                        'description' => $exp['description'] ?? '',
                    ];
                }, $cvSummary['experiences'] ?? []),
                'skills' => array_column($cvSummary['skills'] ?? [], 'name'),
                'educations' => array_map(function($edu) {
                    return [
                        'degree' => $edu['degree'] ?? '',
                        'institution' => $edu['institution'] ?? '',
                    ];
                }, $cvSummary['educations'] ?? []),
            ],
            'job_description' => $jobDescription,
        ];

        $prompt = "You are an expert CV optimizer. Optimize the following CV against the job description.\n\n";
        $prompt .= "CV Summary:\n" . json_encode($data['cv_summary'], JSON_PRETTY_PRINT) . "\n\n";
        $prompt .= "Job Description:\n" . $data['job_description'] . "\n\n";
        $prompt .= "Return a JSON object with:\n";
        $prompt .= "1. 'experiences': array of optimized experiences with 'optimized_bullets'\n";
        $prompt .= "2. 'skills': array of relevant skills\n";
        $prompt .= "3. 'suggestions': array of improvement suggestions\n";
        $prompt .= "4. 'summary': a brief professional summary (1-2 sentences)\n\n";
        $prompt .= "Return ONLY valid JSON.";

        return $prompt;
    }
}
