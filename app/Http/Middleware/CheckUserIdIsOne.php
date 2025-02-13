<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserIdIsOne
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->id == 1) {
            return $next($request);
        }

        // Redirect or show a 403 Forbidden error
        return redirect()->route('home')->withErrors('Unauthorized access');
    }
}
