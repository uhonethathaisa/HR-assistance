<?php

namespace App\Http\Livewire;

use App\Models\CareerProfile;
use Livewire\Component;
use Livewire\WithFileUploads;

class ResumeProfileWizard extends Component
{
    use WithFileUploads;

    public int $currentStep = 1;
    public string $targetJobTitle = '';
    public string $industry = '';
    public ?int $yearsOfExperience = null;
    public array $techStack = [];
    public string $currentSkill = '';
    public $resume = null;
    public string $uploadedFileName = '';

    public array $industries = [
        'Technology', 'Healthcare', 'Finance', 'Education',
        'Manufacturing', 'Retail', 'Media', 'Construction',
        'Transportation', 'Other'
    ];

    public array $suggestedSkills = [
        'JavaScript', 'Python', 'React', 'Vue.js', 'Angular',
        'Laravel', 'PHP', 'Node.js', 'Express.js', 'Django',
        'Ruby on Rails', 'Java', 'Spring Boot', 'C#', '.NET',
        'Go', 'Rust', 'AWS', 'Docker', 'Kubernetes',
        'MySQL', 'PostgreSQL', 'MongoDB', 'Redis',
        'TypeScript', 'Tailwind CSS', 'Bootstrap', 'SASS'
    ];

    protected function rules(): array
    {
        return match ($this->currentStep) {
            1 => [
                'targetJobTitle' => ['required', 'string', 'max:255'],
                'industry' => ['required', 'string', 'in:' . implode(',', $this->industries)],
            ],
            2 => [
                'yearsOfExperience' => ['required', 'integer', 'min:0', 'max:60'],
                'techStack' => ['required', 'array', 'min:1'],
            ],
            3 => [
                'resume' => ['required', 'file', 'mimes:pdf', 'max:5120'],
            ],
            default => [],
        };
    }

    protected $messages = [
        'targetJobTitle.required' => 'Please enter your target job title.',
        'industry.required' => 'Please select your industry.',
        'industry.in' => 'Please select a valid industry.',
        'yearsOfExperience.required' => 'Please enter your years of experience.',
        'yearsOfExperience.integer' => 'Years of experience must be a number.',
        'yearsOfExperience.min' => 'Years of experience cannot be negative.',
        'yearsOfExperience.max' => 'Please enter a valid number of years.',
        'techStack.required' => 'Please add at least one skill.',
        'techStack.min' => 'Please add at least one skill.',
        'resume.required' => 'Please upload your resume (PDF format).',
        'resume.file' => 'Resume must be a valid file.',
        'resume.mimes' => 'Resume must be a PDF file.',
        'resume.max' => 'Resume file size must be less than 5MB.',
    ];

    public function mount(): void
    {
        $existingProfile = CareerProfile::where('user_id', auth()->id())->first();

        if ($existingProfile) {
            $this->targetJobTitle = $existingProfile->target_job_title ?? '';
            $this->industry = $existingProfile->industry ?? '';
            $this->yearsOfExperience = $existingProfile->years_of_experience;
            $this->techStack = $existingProfile->tech_stack ?? [];
            $this->uploadedFileName = $existingProfile->resume_path
                ? basename($existingProfile->resume_path)
                : '';
        }
    }

    public function addSkill(): void
    {
        $skill = trim($this->currentSkill);

        if (empty($skill)) {
            $this->addError('currentSkill', 'Please enter a skill.');
            return;
        }

        if (in_array($skill, $this->techStack)) {
            $this->addError('currentSkill', 'This skill is already added.');
            $this->currentSkill = '';
            return;
        }

        $this->techStack[] = $skill;
        $this->currentSkill = '';
        $this->resetErrorBag('currentSkill');
    }

    public function removeSkill(int $index): void
    {
        unset($this->techStack[$index]);
        $this->techStack = array_values($this->techStack);
    }

    public function addSuggestedSkill(string $skill): void
    {
        if (!in_array($skill, $this->techStack)) {
            $this->techStack[] = $skill;
        }
    }

    public function nextStep(): void
    {
        $this->validate();
        $this->currentStep++;
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function saveProfile()
    {
        $this->validate();

        try {
            $resumePath = null;

            if ($this->resume) {
                $fileName = 'resume_' . auth()->id() . '_' . time() . '.' . $this->resume->getClientOriginalExtension();
                $resumePath = $this->resume->storeAs('resumes', $fileName, 'public');
            }

            CareerProfile::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'target_job_title' => $this->targetJobTitle,
                    'industry' => $this->industry,
                    'years_of_experience' => $this->yearsOfExperience,
                    'tech_stack' => $this->techStack,
                    'resume_path' => $resumePath ?? $this->uploadedFileName,
                ]
            );

            session()->flash('message', 'Profile completed successfully!');
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save profile: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.resume-profile-wizard')
            ->layout('layouts.app');
    }
}
