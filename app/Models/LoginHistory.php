<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoginHistory extends Model
{
    protected $table = 'login_history';

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'location',
        'successful',
        'auth_method',
        'login_at',
    ];

    protected $casts = [
        'successful' => 'boolean',
        'login_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Parse user agent to determine device type, browser, and platform.
     */
    public static function parseUserAgent(?string $userAgent): array
    {
        $result = [
            'device_type' => 'desktop',
            'browser' => 'Unknown',
            'platform' => 'Unknown',
        ];

        if (!$userAgent) {
            return $result;
        }

        // Device type
        if (preg_match('/Mobile|Android|iPhone|iPad|iPod/i', $userAgent)) {
            $result['device_type'] = preg_match('/iPad/i', $userAgent) ? 'tablet' : 'mobile';
        }

        // Browser
        if (preg_match('/Edg/i', $userAgent)) {
            $result['browser'] = 'Edge';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            $result['browser'] = 'Chrome';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $result['browser'] = 'Firefox';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $result['browser'] = 'Safari';
        } elseif (preg_match('/Opera|OPR/i', $userAgent)) {
            $result['browser'] = 'Opera';
        }

        // Platform
        if (preg_match('/Windows/i', $userAgent)) {
            $result['platform'] = 'Windows';
        } elseif (preg_match('/Macintosh|Mac OS X/i', $userAgent)) {
            $result['platform'] = 'macOS';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $result['platform'] = 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $result['platform'] = 'Android';
        } elseif (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
            $result['platform'] = 'iOS';
        }

        return $result;
    }

    /**
     * Record a login attempt.
     */
    public static function recordLogin($user, string $authMethod = 'email', bool $successful = true): self
    {
        $parsed = self::parseUserAgent(request()->userAgent());

        return self::create([
            'user_id' => $user->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'device_type' => $parsed['device_type'],
            'browser' => $parsed['browser'],
            'platform' => $parsed['platform'],
            'location' => null, // Could integrate with a geo-IP service
            'successful' => $successful,
            'auth_method' => $authMethod,
            'login_at' => now(),
        ]);
    }
}
