<?php

namespace App\Livewire;

use App\Models\CareerProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ResumeProfileWizard extends Component
{
    use WithFileUploads;

    /** @var int Current wizard step (1-3) */
    public int $step = 1;

    // Step 1: Career Goals
    public string $target_job_title = '';
    public string $industry = '';

    // Step 2: Skill Inventory
    public ?int $years_of_experience = null;
    public array $tech_stack = [];
    public string $skillInput = '';

    // Step 3: Resume Upload
    public $resume = null; // Livewire temporary upload
    public string $uploadStatus = '';
    public bool $uploadSuccess = false;

    /** @var array<string, string> */
    protected array $messages = [
        'target_job_title.required' => 'Please enter your target job title.',
        'industry.required' => 'Please select your target industry.',
        'years_of_experience.required' => 'Please enter your years of experience.',
        'years_of_experience.integer' => 'Years of experience must be a number.',
        'years_of_experience.min' => 'Years of experience cannot be negative.',
        'resume.max' => 'The resume file must not exceed 5MB.',
        'resume.mimes' => 'Only PDF files are allowed.',
    ];

    /** @var array<string, mixed> */
    protected function rules(): array
    {
        return match ($this->step) {
            1 => [
                'target_job_title' => ['required', 'string', 'max:255'],
                'industry' => ['required', 'string', 'max:100'],
            ],
            2 => [
                'years_of_experience' => ['required', 'integer', 'min:0', 'max:100'],
                'tech_stack' => ['nullable', 'array'],
            ],
            3 => [
                'resume' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // 5MB
            ],
            default => [],
        };
    }

    /**
     * Add a skill to the tech stack.
     */
    public function addSkill(): void
    {
        $skill = trim($this->skillInput);

        if (empty($skill)) {
            return;
        }

        if (in_array($skill, $this->tech_stack)) {
            $this->dispatch('notify', type: 'warning', message: 'Skill already added.');
            $this->skillInput = '';
            return;
        }

        $this->tech_stack[] = $skill;
        $this->skillInput = '';
    }

    /**
     * Add a suggested skill by clicking the chip.
     */
    public function addSuggestedSkill(string $skill): void
    {
        $skill = trim($skill);

        if (empty($skill) || in_array($skill, $this->tech_stack)) {
            return;
        }

        $this->tech_stack[] = $skill;
    }

    /**
     * Remove a skill from the tech stack.
     */
    public function removeSkill(int $index): void

    {
        if (isset($this->tech_stack[$index])) {
            unset($this->tech_stack[$index]);
            $this->tech_stack = array_values($this->tech_stack); // Re-index
        }
    }

    /**
     * Go to the next step.
     */
    public function nextStep(): void
    {
        $this->validate();

        if ($this->step < 3) {
            $this->step++;
        }
    }

    /**
     * Go to the previous step.
     */
    public function previousStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    /**
     * Save the career profile and resume.
     */
    public function save(): void
    {
        $this->validate();

        try {
            $user = Auth::user();

            if (!$user) {
                $this->dispatch('notify', type: 'error', message: 'You must be logged in.');
                return;
            }

            $data = [
                'user_id' => $user->id,
                'target_job_title' => $this->target_job_title,
                'industry' => $this->industry,
                'years_of_experience' => $this->years_of_experience,
                'tech_stack' => $this->tech_stack,
            ];

            // Handle resume upload
            if ($this->resume) {
                $path = $this->resume->store('resumes/' . $user->id, 'public');
                $data['resume_path'] = $path;
                $this->uploadSuccess = true;
                $this->uploadStatus = 'Resume uploaded successfully!';
            }

            // Update or create the career profile
            CareerProfile::updateOrCreate(
                ['user_id' => $user->id],
                $data
            );

            $this->dispatch('notify', type: 'success', message: 'Profile completed successfully!');
            $this->dispatch('profile-completed');

        } catch (\Exception $e) {
            Log::error('Failed to save career profile', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            $this->dispatch('notify', type: 'error', message: 'Failed to save profile. Please try again.');
        }
    }

    /**
     * Remove the uploaded resume.
     */
    public function removeResume(): void
    {
        $this->resume = null;
        $this->uploadStatus = '';
        $this->uploadSuccess = false;
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.resume-profile-wizard');
    }
}
