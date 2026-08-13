<?php

namespace App\Livewire\Admin;

use App\Models\JobPosting;
use Livewire\Component;
use Livewire\WithPagination;

class ManageJobPostings extends Component
{
    use WithPagination;

    public string $title = '';
    public string $company_name = '';
    public string $location = '';
    public string $description = '';
    public string $apply_url = '';

    public string $search = '';
    public string $filter = 'all';

    protected $queryString = ['search', 'filter'];

    protected $paginationTheme = 'tailwind';

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'apply_url' => ['required', 'url', 'max:500'],
        ];
    }

    protected $messages = [
        'title.required' => 'Please enter the job title.',
        'company_name.required' => 'Please enter the company name.',
        'location.required' => 'Please enter the job location.',
        'description.required' => 'Please enter a job description.',
        'apply_url.required' => 'Please enter the external apply URL.',
        'apply_url.url' => 'Please enter a valid URL (e.g. https://linkedin.com/jobs/...).',
    ];

    /**
     * Reset pagination when search changes.
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when filter changes.
     */
    public function updatingFilter(): void
    {
        $this->resetPage();
    }

    /**
     * Create a new job posting.
     */
    public function createJob(): void
    {
        $validated = $this->validate();

        JobPosting::create([
            ...$validated,
            'source' => 'manual',
            'is_active' => true,
        ]);

        $this->reset(['title', 'company_name', 'location', 'description', 'apply_url']);
        session()->flash('success', 'Job posting created successfully!');
    }

    /**
     * Toggle the active status of a job posting.
     */
    public function toggleActive(int $jobId): void
    {
        $job = JobPosting::findOrFail($jobId);
        $job->update([
            'is_active' => !$job->is_active,
        ]);

        session()->flash(
            'success',
            $job->is_active
                ? "{$job->title} has been activated."
                : "{$job->title} has been deactivated."
        );
    }

    /**
     * Delete a job posting.
     */
    public function deleteJob(int $jobId): void
    {
        $job = JobPosting::findOrFail($jobId);
        $jobTitle = $job->title;
        $job->delete();

        session()->flash('success', "{$jobTitle} has been deleted.");
    }

    /**
     * Render the component.
     */
    public function render()
    {
        $query = JobPosting::query();

        // Apply filter
        if ($this->filter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filter === 'inactive') {
            $query->where('is_active', false);
        }

        // Apply search
        if (!empty($this->search)) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $jobs = $query->latest()->paginate(10);

        $stats = [
            'total' => JobPosting::count(),
            'active' => JobPosting::where('is_active', true)->count(),
            'inactive' => JobPosting::where('is_active', false)->count(),
        ];

        return view('livewire.admin.manage-job-postings', [
            'jobs' => $jobs,
            'stats' => $stats,
        ]);
    }
}
