<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\WorkHistory;
use App\Models\CVOptimization;
use App\Models\CoverLetter;
use Livewire\Component;

class AdminDashboard extends Component
{
    public $totalUsers = 0;
    public $pendingUsers = 0;
    public $totalWorkHistories = 0;
    public $totalCvOptimizations = 0;
    public $totalCoverLetters = 0;
    public $recentUsers = [];
    public $adminName = '';

    public function mount()
    {
        $this->adminName = auth()->user()->name ?? 'Admin';
        $this->loadStats();
        $this->loadRecentUsers();
    }

    public function loadStats()
    {
        $this->totalUsers = User::count();
        $this->pendingUsers = User::where('is_approved', false)->count();
        $this->totalWorkHistories = WorkHistory::count();
        $this->totalCvOptimizations = CVOptimization::count();
        $this->totalCoverLetters = CoverLetter::count();
    }

    public function loadRecentUsers()
    {
        $this->recentUsers = User::latest()
            ->take(5)
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin-dashboard')
            ->layout('layouts.dashboard');
    }
}
