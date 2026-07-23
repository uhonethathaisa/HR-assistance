<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class Settings extends Component
{
    use WithFileUploads;

    // Active tab
    public $activeTab = 'profile';

    // Profile fields
    public $name;
    public $email;
    public $phone;
    public $job_title;
    public $company;
    public $location;
    public $bio;
    public $avatar;
    public $tempAvatar;

    // Password fields
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    // Notification preferences
    public $notify_cv_updates = true;
    public $notify_cover_letters = true;
    public $notify_marketing = false;
    public $notify_security = true;
    public $notify_in_app = true;

    // Application preferences
    public $theme = 'dark';
    public $timezone = 'UTC';
    public $locale = 'en';

    // Privacy
    public $profile_visibility = 'public';
    public $data_sharing = false;

    // Danger zone
    public $deleteConfirmText = '';
    public $deactivateConfirm = false;

    // Login history
    public $loginHistory;
    public $activeSessions;

    // Success/error messages
    public $successMessage = '';
    public $errorMessage = '';


    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'phone' => ['nullable', 'string', 'max:30'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'tempAvatar' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->job_title = $user->job_title ?? '';
        $this->company = $user->company ?? '';
        $this->location = $user->location ?? '';
        $this->bio = $user->bio ?? '';
        $this->timezone = $user->timezone ?? date_default_timezone_get();
        $this->locale = $user->locale ?? 'en';

        // Load preferences from JSON
        $prefs = $user->preferences ?? [];
        $this->theme = $prefs['theme'] ?? 'dark';
        $this->notify_cv_updates = $prefs['notify_cv_updates'] ?? true;
        $this->notify_cover_letters = $prefs['notify_cover_letters'] ?? true;
        $this->notify_marketing = $prefs['notify_marketing'] ?? false;
        $this->notify_security = $prefs['notify_security'] ?? true;
        $this->notify_in_app = $prefs['notify_in_app'] ?? true;
        $this->profile_visibility = $prefs['profile_visibility'] ?? 'public';
        $this->data_sharing = $prefs['data_sharing'] ?? false;
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->successMessage = '';
        $this->errorMessage = '';
    }

    // ──────────────────────────────────────────────
    // 1. PROFILE SETTINGS
    // ──────────────────────────────────────────────

    public function updateProfile()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'phone' => ['nullable', 'string', 'max:30'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        Auth::user()->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
            'job_title' => $this->job_title ?: null,
            'company' => $this->company ?: null,
            'location' => $this->location ?: null,
            'bio' => $this->bio ?: null,
        ]);

        $this->successMessage = 'Profile updated successfully!';
    }

    public function updatedTempAvatar()
    {
        $this->validate(['tempAvatar' => 'image|max:2048']);

        $path = $this->tempAvatar->store('avatars', 'public');
        Auth::user()->update(['avatar' => $path]);

        $this->avatar = $path;
        $this->tempAvatar = null;
        $this->successMessage = 'Profile photo updated!';
    }

    public function removeAvatar()
    {
        $user = Auth::user();
        if ($user->avatar && !str_starts_with($user->avatar, 'http')) {
            Storage::disk('public')->delete($user->avatar);
        }
        $user->update(['avatar' => null]);
        $this->avatar = null;
        $this->successMessage = 'Profile photo removed.';
    }

    // ──────────────────────────────────────────────
    // 2. ACCOUNT SECURITY
    // ──────────────────────────────────────────────

    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';

        $this->successMessage = 'Password updated successfully!';
    }

    public function resendVerification()
    {
        $user = Auth::user();
        if ($user->hasVerifiedEmail()) {
            $this->errorMessage = 'Your email is already verified.';
            return;
        }

        $user->sendEmailVerificationNotification();
        $this->successMessage = 'Verification email sent!';
    }

    public function logoutOtherDevices()
    {
        Auth::logoutOtherDevices($this->current_password ?: '');
        $this->successMessage = 'Other devices logged out successfully!';
    }

    // ──────────────────────────────────────────────
    // 3. NOTIFICATION PREFERENCES
    // ──────────────────────────────────────────────

    public function saveNotifications()
    {
        $user = Auth::user();
        $prefs = $user->preferences ?? [];
        $prefs['notify_cv_updates'] = (bool) $this->notify_cv_updates;
        $prefs['notify_cover_letters'] = (bool) $this->notify_cover_letters;
        $prefs['notify_marketing'] = (bool) $this->notify_marketing;
        $prefs['notify_security'] = (bool) $this->notify_security;
        $prefs['notify_in_app'] = (bool) $this->notify_in_app;
        $user->update(['preferences' => $prefs]);

        $this->successMessage = 'Notification preferences saved!';
    }

    // ──────────────────────────────────────────────
    // 4. APPLICATION PREFERENCES
    // ──────────────────────────────────────────────

    public function savePreferences()
    {
        $user = Auth::user();
        $prefs = $user->preferences ?? [];
        $prefs['theme'] = $this->theme;
        $prefs['profile_visibility'] = $this->profile_visibility;
        $prefs['data_sharing'] = (bool) $this->data_sharing;
        $user->update([
            'preferences' => $prefs,
            'timezone' => $this->timezone,
            'locale' => $this->locale,
        ]);

        $this->successMessage = 'Preferences saved!';
    }

    // ──────────────────────────────────────────────
    // 5. DANGER ZONE
    // ──────────────────────────────────────────────

    public function deleteAccount()
    {
        if ($this->deleteConfirmText !== 'DELETE') {
            $this->errorMessage = 'Please type DELETE to confirm.';
            return;
        }

        $user = Auth::user();
        Auth::logout();
        $user->delete();

        return redirect('/');
    }

    public function deactivateAccount()
    {
        if (!$this->deactivateConfirm) {
            $this->errorMessage = 'Please confirm deactivation.';
            return;
        }

        $user = Auth::user();
        $user->update(['preferences' => array_merge($user->preferences ?? [], ['deactivated' => true])]);
        Auth::logout();

        return redirect('/');
    }

    // ──────────────────────────────────────────────
    // 6. DATA EXPORT
    // ──────────────────────────────────────────────

    public function exportData()
    {
        $user = Auth::user()->load([
            'workHistories',
            'workHistories.skills',
            'workHistories.education',
            'workHistories.qualifications',
        ]);

        $data = [
            'profile' => $user->toArray(),
            'exported_at' => now()->toIso8601String(),
        ];

        $json = json_encode($data, JSON_PRETTY_PRINT);
        $filename = 'user-data-' . now()->format('Y-m-d-His') . '.json';
        Storage::disk('local')->put('exports/' . $filename, $json);

        return response()->download(storage_path('app/exports/' . $filename))->deleteFileAfterSend(true);
    }

    public function render()
    {
        return view('livewire.settings')
            ->layout('layouts.dashboard');
    }
}
