<?php

namespace App\Livewire\Public;

use App\Models\JobPosting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.public')]
#[Title('Job Market')]
class JobMarketPage extends Component
{
    use WithPagination;

    /**
     * Keyword search, live-bound to the "What" input via wire:model.live.debounce.
     * Matches against title, company_name and description.
     */
    public string $keyword = '';

    /**
     * Location search, live-bound to the "Where" input via wire:model.live.debounce.
     * Matches against the location column.
     */
    public string $location = '';

    /**
     * Use the Tailwind-styled pagination views.
     */
    protected $paginationTheme = 'tailwind';

    /**
     * Reset back to page 1 whenever the keyword changes.
     */
    public function updatingKeyword(): void
    {
        $this->resetPage();
    }

    /**
     * Reset back to page 1 whenever the location changes.
     */
    public function updatingLocation(): void
    {
        $this->resetPage();
    }

    /**
     * Clear both search fields.
     */
    public function resetSearch(): void
    {
        $this->keyword = '';
        $this->location = '';
        $this->resetPage();
    }

    /**
     * Fetch active job postings, optionally filtered by keyword and/or location.
     */
    public function render()
    {
        $keyword = trim($this->keyword);
        $location = trim($this->location);

        $jobs = JobPosting::query()
            ->where('is_active', true)
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%")
                        ->orWhere('company_name', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%");
                });
            })
            ->when($location !== '', function ($query) use ($location) {
                $query->where('location', 'like', "%{$location}%");
            })
            ->latest()
            ->paginate(12);

        return view('livewire.public.job-market-page', [
            'jobs' => $jobs,
        ]);
    }
}
