<?php

use App\Http\Livewire\AdminUserManagement;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\WorkHistory;
use App\Http\Livewire\CVOptimizer;
use App\Http\Livewire\CoverLetterOptimizer;
use App\Http\Livewire\Settings;
use App\Http\Controllers\OptimizedCVDownloadController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Public routes - Landing page
Route::get('/', function () {
    return view('landing');
});


// Test route for DeepSeek API connection
Route::get('/test-deepseek', function () {
    $deepSeek = new \App\Services\DeepSeekService();
    $result = $deepSeek->testConnection();

    return response()->json($result);
});

// Authentication routes
require __DIR__.'/auth.php';

// Protected routes - All dashboard pages
Route::middleware(['auth'])->group(function () {
    // Main dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Work History - Full CRUD
    Route::get('/work-history', WorkHistory::class)->name('work-history');

    // CV Optimizer
    Route::get('/cv-optimizer', CVOptimizer::class)->name('cv-optimizer');

    // CV Optimizer - PDF Download (separate route to avoid Livewire JSON encoding issues)
    Route::get('/cv-optimizer/download', [OptimizedCVDownloadController::class, 'download'])
        ->name('cv-optimizer.download');

    // Cover Letters
    Route::get('/cover-letters', CoverLetterOptimizer::class)->name('cover-letters');

    // Settings (optional)
    Route::get('/settings', Settings::class)->name('settings');

    // Settings - Data Export
    Route::get('/settings/export', function () {
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

        return response()->streamDownload(function () use ($json) {
            echo $json;
        }, $filename, ['Content-Type' => 'application/json']);
    })->name('settings.export');


    // ============================================
    // Admin-only routes
    // ============================================
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // User Management (Livewire component)
        Route::get('/users', AdminUserManagement::class)->name('users');

        // System Settings
        Route::match(['get', 'post'], '/system', function () {
            if (request()->isMethod('post')) {
                $action = request('action');
                $messages = [
                    'cache' => 'Application cache cleared!',
                    'views' => 'View cache cleared!',
                    'config' => 'Config cache cleared!',
                    'routes' => 'Route cache cleared!',
                ];

                if (array_key_exists($action, $messages)) {
                    Artisan::call($action . ':clear');
                    return redirect()->route('admin.system')->with('success', $messages[$action]);
                }
            }
            return view('admin.system');
        })->name('system');

    });

    // Fallback for undefined routes
    Route::fallback(function () {
        return redirect('/dashboard');
    });

});
