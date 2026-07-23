<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Notifications\AccountApprovedNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class AdminUserManagement extends Component
{
    use WithPagination;

    public string $filter = 'all';
    public string $search = '';

    protected $queryString = ['filter', 'search'];

    /**
     * Approve a user.
     */
    public function approve(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->update(['is_approved' => true]);

        // Notify the user that their account has been approved
        try {
            $user->notify(new AccountApprovedNotification());
        } catch (\Exception $e) {
            // Log but don't fail if notification fails
            \Illuminate\Support\Facades\Log::warning('Failed to send approval notification', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);
        }

        session()->flash('success', "User {$user->name} has been approved successfully.");
    }

    /**
     * Reject (delete) a user.
     */
    public function reject(int $userId): void
    {
        $user = User::findOrFail($userId);

        // Don't allow rejecting admins
        if ($user->isAdmin()) {
            session()->flash('error', 'Cannot reject an admin user.');
            return;
        }

        $userName = $user->name;
        $user->delete();

        session()->flash('success', "User {$userName} has been rejected and removed.");
    }

    /**
     * Reset pagination when filter changes.
     */
    public function updatingFilter(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when search changes.
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Render the component.
     */
    public function render()
    {
        $query = User::query();

        // Apply filter
        if ($this->filter === 'pending') {
            $query->where('is_approved', false);
        } elseif ($this->filter === 'approved') {
            $query->where('is_approved', true);
        }

        // Apply search
        if (!empty($this->search)) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(20);

        $stats = [
            'total' => User::count(),
            'pending' => User::where('is_approved', false)->count(),
            'approved' => User::where('is_approved', true)->count(),
        ];

        return view('livewire.admin-user-management', [
            'users' => $users,
            'stats' => $stats,
        ]);
    }
}
