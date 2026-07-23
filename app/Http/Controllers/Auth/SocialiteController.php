<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NewUserRegisteredNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Supported social providers.
     */
    private const SUPPORTED_PROVIDERS = ['google', 'linkedin', 'apple', 'github', 'twitter'];

    /**
     * Redirect the user to the provider's authentication page.
     */
    public function redirect(string $provider): RedirectResponse
    {
        if (!in_array($provider, self::SUPPORTED_PROVIDERS)) {
            abort(404, "Provider '{$provider}' is not supported.");
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the callback from the provider.
     */
    public function callback(string $provider): RedirectResponse
    {
        if (!in_array($provider, self::SUPPORTED_PROVIDERS)) {
            abort(404, "Provider '{$provider}' is not supported.");
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            Log::error('Socialite callback failed', [
                'provider' => $provider,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('login')
                ->with('error', 'Unable to authenticate with ' . ucfirst($provider) . '. Please try again.');
        }

        try {
            $user = User::findOrCreateFromSocial($provider, $socialUser);
        } catch (\Exception $e) {
            Log::error('Failed to find/create user from social login', [
                'provider' => $provider,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('login')
                ->with('error', 'An error occurred while creating your account. Please try again.');
        }

        // Check if the user is approved (skip for existing users who were already approved)
        if (!$user->is_approved) {
            Auth::logout();

            return redirect()->route('login')
                ->with('error', 'Your account is awaiting admin approval. You will be notified once approved.');
        }

        Auth::login($user, true);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
