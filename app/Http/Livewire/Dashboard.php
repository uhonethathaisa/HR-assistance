<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\WorkHistory;
use App\Models\CVOptimization;
use App\Models\CoverLetter;

class Dashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $workCount = 0;
    public $workGrowth = 0;
    public $cvCount = 0;
    public $cvGrowth = 0;
    public $coverLetterCount = 0;
    public $coverGrowth = 0;
    public $avgAtsScore = 0;
    public $recentActivity = [];

    public function mount()
    {
        $userId = auth()->id();

        $this->workCount = WorkHistory::where('user_id', $userId)->count();
        $this->cvCount = CVOptimization::where('user_id', $userId)->count();
        $this->coverLetterCount = CoverLetter::where('user_id', $userId)->count();

        // Calculate average ATS score from CV optimizations
        $avgScore = CVOptimization::where('user_id', $userId)->avg('ats_score');
        $this->avgAtsScore = $avgScore ? round($avgScore) : 0;

        $this->loadActivity();
    }

    /**
     * When search is updated, re-filter the activity list.
     */
    public function updatedSearch()
    {
        $this->loadActivity();
    }

    /**
     * Load and filter recent activity based on the search query.
     */
    protected function loadActivity()
    {
        $userId = auth()->id();
        $search = trim($this->search);

        $this->recentActivity = collect()
            ->merge(
                WorkHistory::where('user_id', $userId)
                    ->when($search, fn($q) => $q->where(function($q) use ($search) {
                        $q->where('company', 'like', "%{$search}%")
                          ->orWhere('position', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%");
                    }))
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(fn($item) => (object) [
                        'type' => 'work',
                        'title' => $item->company ?? 'Work Entry',
                        'description' => $item->position ?? '',
                        'time' => $item->created_at->diffForHumans(),
                    ])
            )
            ->merge(
                CVOptimization::where('user_id', $userId)
                    ->when($search, fn($q) => $q->where(function($q) use ($search) {
                        $q->where('original_filename', 'like', "%{$search}%")
                          ->orWhere('optimized_content', 'like', "%{$search}%")
                          ->orWhere('ats_score', 'like', "%{$search}%");
                    }))
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(fn($item) => (object) [
                        'type' => 'cv',
                        'title' => 'CV Optimization',
                        'description' => 'ATS Score: ' . ($item->ats_score ?? 'N/A') . '%',
                        'time' => $item->created_at->diffForHumans(),
                    ])
            )
            ->merge(
                CoverLetter::where('user_id', $userId)
                    ->when($search, fn($q) => $q->where(function($q) use ($search) {
                        $q->where('company', 'like', "%{$search}%")
                          ->orWhere('position', 'like', "%{$search}%")
                          ->orWhere('content', 'like', "%{$search}%");
                    }))
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(fn($item) => (object) [
                        'type' => 'cover',
                        'title' => $item->company ?? 'Cover Letter',
                        'description' => $item->position ?? '',
                        'time' => $item->created_at->diffForHumans(),
                    ])
            )
            ->sortByDesc('time')
            ->take(10)
            ->values();
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('layouts.app');
    }
}
