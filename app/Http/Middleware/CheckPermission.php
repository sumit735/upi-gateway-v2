<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $page
     * @param  string  $action
     * @param  string  $scope (optional)
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $page, string $action, string $scope = 'self'): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['error' => 'Please login to continue.']);
        }

        $user = auth()->user();

        // Check if user is blocked
        if ($user->is_blocked) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['error' => 'Your account has been blocked.']);
        }

        // Check if user has permission
        if (!$user->hasPermission($page, $action, $scope)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
