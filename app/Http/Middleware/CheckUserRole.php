<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, ...$levels)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user's level matches the allowed levels
        $userLevel = auth()->user()->level;
        if (!in_array($userLevel, $levels)) {
            return response()->view('errors.403')->header('Refresh', '2;url=/');
        }

        return $next($request);
    }
}

