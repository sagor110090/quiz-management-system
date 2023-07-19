<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::check()) {
                if (Auth::guard($guard)->check()) {
                    if (Auth::user()->hasRole('teacher')) {
                        return redirect('dashboard');
                    }
                    if (Auth::user()->hasRole('admin')) {
                        return redirect('dashboard');
                    }

                    if (Auth::user()->hasRole('student')) {
                        return redirect('/classroom/list');
                    }

                }
            }
        }

        return $next($request);
    }
}
