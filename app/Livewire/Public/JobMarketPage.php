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
     * The search query, live-bound to the search input via wire:model.live.
     * Matches against both the job title and location columns.
     */
    public string $searchQuery = '';

    /**
     * Use the Tailwind-styled pagination views.
     */
    protected $paginationTheme = 'tailwind';

    /**
     * Reset back to page 1 whenever the search query is updated.
     */
    public function updatingSearchQuery(): void
    {
        $this->resetPage();
    }

    /**
     * Fetch active job postings, optionally filtered by the search query.
     */
    public function render()
    {
        $search = trim($this->searchQuery);

        $jobs = JobPosting::query()
            ->where('is_active', true)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12);

        return view('livewire.public.job-market-page', [
            'jobs' => $jobs,
        ]);
    }
}
