<?php
// app/Http/Livewire/CoverLetterOptimizer.php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CoverLetter;
use App\Models\WorkHistory;
use App\Models\Skill;
use App\Services\DeepSeekService;
use Illuminate\Support\Facades\Log;

class CoverLetterOptimizer extends Component
{
    use WithFileUploads;

    // Form properties
    public $jobTitle = '';
    public $companyName = '';
    public $jobDescription = '';
    public $jobDescriptionFile = null;
    public $additionalNotes = '';

    // State properties
    public $isGenerating = false;
    public $showForm = true;
    public $showResult = false;
    public $editingId = null;

    // Generated content
    public $generatedContent = '';
    public $customContent = '';

    // User data
    public $experiences = [];
    public $skills = [];

    // History
    public $coverLetters = [];

    protected $rules = [
        'jobTitle' => 'required|string|max:255',
        'companyName' => 'required|string|max:255',
        'jobDescription' => 'required|string|min:10',
        'jobDescriptionFile' => 'nullable|file|mimes:pdf,txt|max:5120',
        'additionalNotes' => 'nullable|string|max:1000',
    ];

    protected $messages = [
        'jobTitle.required' => 'Please enter the job title.',
        'companyName.required' => 'Please enter the company name.',
        'jobDescription.required' => 'Please enter or upload the job description.',
        'jobDescription.min' => 'Job description must be at least 10 characters.',
    ];

    public function mount()
    {
        $this->loadUserData();
        $this->loadCoverLetters();
    }

    public function loadUserData()
    {
        $user = auth()->user();
        $this->experiences = WorkHistory::where('user_id', $user->id)
            ->orderBy('start_date', 'desc')
            ->get()
            ->toArray();
        $this->skills = Skill::where('user_id', $user->id)
            ->orderBy('name')
            ->get()
            ->pluck('name')
            ->toArray();
    }

    public function loadCoverLetters()
    {
        $this->coverLetters = CoverLetter::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
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

            session()->flash('message', 'Job description extracted from file successfully!');

        } catch (\Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            session()->flash('error', 'Failed to read file: ' . $e->getMessage());
        }
    }

    public function generate()
    {
        $this->validate();

        $this->isGenerating = true;

        try {
            $deepSeek = new DeepSeekService();
            $prompt = $this->buildPrompt();
            $response = $deepSeek->callAPI($prompt);

            if ($response && isset($response['choices'][0]['message']['content'])) {
                $this->generatedContent = $response['choices'][0]['message']['content'];
            } else {
                // Fallback to simulated generation if API fails
                $this->generatedContent = $this->simulateGeneration();
            }

            $this->customContent = $this->generatedContent;
            $this->showForm = false;
            $this->showResult = true;

            session()->flash('success', '✅ Cover letter generated successfully!');

        } catch (\Exception $e) {
            Log::error('Cover letter generation failed: ' . $e->getMessage());
            // Fallback to simulated generation
            $this->generatedContent = $this->simulateGeneration();
            $this->customContent = $this->generatedContent;
            $this->showForm = false;
            $this->showResult = true;
            session()->flash('message', 'Cover letter generated (offline mode).');
        } finally {
            $this->isGenerating = false;
        }
    }

    private function buildPrompt()
    {
        $userName = auth()->user()->name;
        $userEmail = auth()->user()->email;

        $prompt = "Write a professional cover letter for the following application:\n\n";
        $prompt .= "Applicant Name: {$userName}\n";
        $prompt .= "Applicant Email: {$userEmail}\n";
        $prompt .= "Job Title: {$this->jobTitle}\n";
        $prompt .= "Company Name: {$this->companyName}\n\n";

        // Add work experience
        if (!empty($this->experiences)) {
            $prompt .= "WORK EXPERIENCE:\n";
            foreach ($this->experiences as $exp) {
                $prompt .= "- {$exp['job_title']} at {$exp['company_name']}";
                $endDate = $exp['end_date'] ?? 'Present';
                $prompt .= " ({$exp['start_date']} - {$endDate})\n";
                if (!empty($exp['description'])) {
                    $prompt .= "  Description: {$exp['description']}\n";
                }
            }
            $prompt .= "\n";
        }

        // Add skills
        if (!empty($this->skills)) {
            $prompt .= "SKILLS:\n" . implode(', ', $this->skills) . "\n\n";
        }

        // Add job description
        $prompt .= "JOB DESCRIPTION:\n{$this->jobDescription}\n\n";

        // Add additional notes
        if (!empty($this->additionalNotes)) {
            $prompt .= "ADDITIONAL NOTES FROM APPLICANT:\n{$this->additionalNotes}\n\n";
        }

        $prompt .= "Write a compelling, professional cover letter that:\n";
        $prompt .= "1. Addresses the hiring manager professionally\n";
        $prompt .= "2. Highlights relevant experience matching the job requirements\n";
        $prompt .= "3. Demonstrates knowledge of the company and role\n";
        $prompt .= "4. Shows enthusiasm and cultural fit\n";
        $prompt .= "5. Includes a call to action for an interview\n";
        $prompt .= "6. Is properly formatted with date, salutation, body, and closing\n\n";
        $prompt .= "Return ONLY the cover letter text. No explanations, no JSON formatting.";

        return $prompt;
    }

    private function simulateGeneration()
    {
        $userName = auth()->user()->name;

        $letter = date('F d, Y') . "\n\n";
        $letter .= "Hiring Manager\n{$this->companyName}\n\n";
        $letter .= "Dear Hiring Manager,\n\n";
        $letter .= "I am writing to express my strong interest in the {$this->jobTitle} position at {$this->companyName}. ";
        $letter .= "With my background and experience, I am confident that I would be a valuable addition to your team.\n\n";

        if (!empty($this->experiences)) {
            $exp = $this->experiences[0];
            $letter .= "In my current role as {$exp['job_title']} at {$exp['company_name']}, ";
            $letter .= "I have developed strong skills that align perfectly with this opportunity. ";
            if (!empty($exp['description'])) {
                $letter .= "My experience includes: " . substr($exp['description'], 0, 200) . "\n\n";
            }
        }

        if (!empty($this->skills)) {
            $letter .= "My key skills include: " . implode(', ', array_slice($this->skills, 0, 8)) . ".\n\n";
        }

        $letter .= "I am particularly excited about this opportunity at {$this->companyName} because it aligns with my career goals ";
        $letter .= "and I am eager to contribute to your team's success.\n\n";
        $letter .= "Thank you for considering my application. I look forward to the opportunity to discuss how my experience ";
        $letter .= "and skills can benefit {$this->companyName}.\n\n";
        $letter .= "Best regards,\n{$userName}\n{$userName}";

        return $letter;
    }

    public function save()
    {
        $data = [
            'user_id' => auth()->id(),
            'job_title' => $this->jobTitle,
            'company_name' => $this->companyName,
            'job_description' => $this->jobDescription,
            'generated_content' => $this->generatedContent,
            'custom_content' => $this->customContent,
            'additional_notes' => $this->additionalNotes,
            'status' => 'generated',
        ];

        if ($this->editingId) {
            CoverLetter::where('user_id', auth()->id())
                ->where('id', $this->editingId)
                ->update($data);
            session()->flash('success', '✅ Cover letter updated successfully.');
        } else {
            CoverLetter::create($data);
            session()->flash('success', '✅ Cover letter saved successfully.');
        }

        $this->resetForm();
        $this->loadCoverLetters();
    }

    public function edit($id)
    {
        $letter = CoverLetter::where('user_id', auth()->id())->findOrFail($id);
        $this->editingId = $id;
        $this->jobTitle = $letter->job_title;
        $this->companyName = $letter->company_name;
        $this->jobDescription = $letter->job_description;
        $this->generatedContent = $letter->generated_content;
        $this->customContent = $letter->custom_content ?? $letter->generated_content;
        $this->additionalNotes = $letter->additional_notes ?? '';
        $this->showForm = false;
        $this->showResult = true;
    }

    public function view($id)
    {
        $this->edit($id);
    }

    public function delete($id)
    {
        CoverLetter::where('user_id', auth()->id())
            ->where('id', $id)
            ->delete();
        $this->loadCoverLetters();
        session()->flash('success', '✅ Cover letter deleted successfully.');
    }

    public function resetForm()
    {
        $this->showForm = true;
        $this->showResult = false;
        $this->editingId = null;
        $this->jobTitle = '';
        $this->companyName = '';
        $this->jobDescription = '';
        $this->jobDescriptionFile = null;
        $this->additionalNotes = '';
        $this->generatedContent = '';
        $this->customContent = '';
    }

    public function render()
    {
        return view('livewire.cover-letter-optimizer')
            ->layout('layouts.dashboard', [
                'pageTitle' => 'Cover Letter Generator',
                'pageSubtitle' => 'Generate AI-powered cover letters tailored to any job'
            ]);
    }
}
