<?php
// app/Http/Livewire/CVOptimizer.php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\WorkHistory;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Qualification;
use App\Services\CVOptimizationService;
use Illuminate\Support\Facades\Log;

class CVOptimizer extends Component
{
    use WithFileUploads;

    // Form properties
    public $jobTitle = '';
    public $companyName = '';
    public $jobDescription = '';
    public $jobDescriptionFile = null;

    // State properties
    public $isAnalyzing = false;
    public $showResults = false;
    public $selectedTemplate = 'professional';

    // User data
    public $experiences = [];
    public $educations = [];
    public $skills = [];
    public $qualifications = [];

    // Results
    public $atsScore = null;
    public $atsBreakdown = [];
    public $optimizedExperiences = [];
    public $optimizedSkills = [];
    public $suggestions = [];
    public $missingKeywords = [];
    public $matchedKeywords = [];
    public $optimizedSummary = '';

    protected $rules = [
        'jobTitle' => 'required|string|max:255',
        'companyName' => 'required|string|max:255',
        'jobDescription' => 'required|string|min:10',
        'jobDescriptionFile' => 'nullable|file|mimes:pdf,txt|max:5120',
    ];

    protected $messages = [
        'jobTitle.required' => 'Please enter the job title.',
        'companyName.required' => 'Please enter the company name.',
        'jobDescription.required' => 'Please enter the job description.',
        'jobDescription.min' => 'Job description must be at least 10 characters.',
    ];

    public function mount()
    {
        $this->loadUserData();
    }

    public function loadUserData()
    {
        $user = auth()->user();
        $this->experiences = WorkHistory::where('user_id', $user->id)
            ->orderBy('start_date', 'desc')
            ->get()
            ->toArray();
        $this->educations = Education::where('user_id', $user->id)
            ->orderBy('start_date', 'desc')
            ->get()
            ->toArray();
        $this->skills = Skill::where('user_id', $user->id)
            ->orderBy('name')
            ->get()
            ->toArray();
        $this->qualifications = Qualification::where('user_id', $user->id)
            ->orderBy('issue_date', 'desc')
            ->get()
            ->toArray();
    }

    public function updatedJobDescriptionFile()
    {
        $this->validate([
            'jobDescriptionFile' => 'file|mimes:pdf,txt|max:5120',
        ]);

        try {
            $file = $this->jobDescriptionFile;
            $extension = $file->getClientOriginalExtension();

            if ($extension === 'txt') {
                $content = file_get_contents($file->getRealPath());
                $this->jobDescription = $content;
            } elseif ($extension === 'pdf') {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($file->getRealPath());
                $this->jobDescription = $pdf->getText();
            }

            session()->flash('message', 'File uploaded and content extracted successfully!');

        } catch (\Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            session()->flash('error', 'Failed to read file: ' . $e->getMessage());
        }
    }

    public function analyzeAndOptimize()
    {
        $this->validate();

        if (empty($this->experiences)) {
            session()->flash('error', 'Please add your work history first before optimizing.');
            return;
        }

        $this->isAnalyzing = true;

        try {
            $service = new CVOptimizationService();

            $result = $service->optimizeCV(
                $this->experiences,
                $this->educations,
                $this->skills,
                $this->qualifications,
                $this->jobDescription
            );

            $this->atsScore = $result['ats_score'] ?? 0;
            $this->atsBreakdown = $result['ats_breakdown'] ?? [];
            $this->optimizedExperiences = $result['optimized_experiences'] ?? [];
            $this->optimizedSkills = $result['optimized_skills'] ?? [];
            $this->suggestions = $result['suggestions'] ?? [];
            $this->missingKeywords = $result['missing_keywords'] ?? [];
            $this->matchedKeywords = $result['matched_keywords'] ?? [];
            $this->optimizedSummary = $result['optimized_summary'] ?? '';
            $this->showResults = true;

            session()->flash('success', '✅ CV optimization completed successfully!');

        } catch (\Exception $e) {
            Log::error('CV Optimization Error: ' . $e->getMessage());
            session()->flash('error', '❌ Optimization failed: ' . $e->getMessage());
            $this->showResults = false;
        } finally {
            $this->isAnalyzing = false;
        }
    }

    public function downloadOptimizedCV()
    {
        try {
            // Store optimization data in session for the download controller
            session()->put('cv_optimization_data', [
                'experiences' => $this->optimizedExperiences,
                'educations' => $this->educations,
                'skills' => $this->optimizedSkills,
                'qualifications' => $this->qualifications,
                'ats_score' => $this->atsScore,
                'ats_breakdown' => $this->atsBreakdown,
                'summary' => $this->optimizedSummary,
                'job_title' => $this->jobTitle,
                'company_name' => $this->companyName,
                'template' => $this->selectedTemplate,
            ]);

            // Redirect to the download route - avoids Livewire JSON encoding issues
            return redirect()->route('cv-optimizer.download', [
                'template' => $this->selectedTemplate,
            ]);

        } catch (\Exception $e) {
            Log::error('PDF Download Error: ' . $e->getMessage());
            session()->flash('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->jobTitle = '';
        $this->companyName = '';
        $this->jobDescription = '';
        $this->jobDescriptionFile = null;
        $this->showResults = false;
        $this->atsScore = null;
        $this->atsBreakdown = [];
        $this->optimizedExperiences = [];
        $this->optimizedSkills = [];
        $this->suggestions = [];
        $this->missingKeywords = [];
        $this->matchedKeywords = [];
        $this->optimizedSummary = '';
    }

    public function render()
    {
        return view('livewire.cv-optimizer')
            ->layout('layouts.dashboard', [
                'pageTitle' => 'CV Optimizer',
                'pageSubtitle' => 'Optimize your CV against any job description with AI-powered ATS analysis'
            ]);
    }
}
