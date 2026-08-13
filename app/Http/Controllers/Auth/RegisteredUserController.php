<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Models\User;
use App\Notifications\NewUserRegisteredNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        // Resolve the target job (if any) so the form can surface the conversion context.
        $targetJob = null;

        if ($request->filled('target_job')) {
            $targetJob = JobPosting::where('id', $request->integer('target_job'))
                ->where('is_active', true)
                ->first();
        }

        return view('auth.register', [
            'targetJob' => $targetJob,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'target_job' => ['nullable', 'integer'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_approved' => false,
        ]);

        event(new Registered($user));

        // Notify all admin users about the new registration
        $admins = User::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new NewUserRegisteredNotification($user));
        }

        // ─── Job Market conversion hook ─────────────────────────────────────
        // If the visitor arrived from the "Optimize CV for this role" CTA,
        // carry the job context over to the CV Optimizer and fast-track them
        // straight into the tool so the conversion isn't lost to the
        // admin-approval queue. Admin pages remain protected by role.
        $targetJob = null;

        if ($request->filled('target_job')) {
            $targetJob = JobPosting::where('id', $request->integer('target_job'))
                ->where('is_active', true)
                ->first();
        }

        if ($targetJob) {
            session()->put('pending_cv_optimization', $targetJob->toArray());

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('cv-optimizer');
        }

        // Standard flow: do NOT log the user in automatically.
        // Redirect to login with a pending approval message.
        return redirect()->route('login')->with('status', 'Your account has been created and is awaiting admin approval. You will be notified once approved.');
    }
}
