<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCareerHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && !$user->hasCareerHistory()) {
            $missing = $user->getMissingCareerFields();
            $missingList = implode(', ', array_values($missing));

            return redirect()->route('career-history')
                ->with('warning', 'Please complete your career history before optimizing your CV. Missing: ' . $missingList . '. Import your CV or add your details manually.');
        }

        return $next($request);
    }
}
