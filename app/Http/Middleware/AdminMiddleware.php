<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    //all workers of app will pass this middleware
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check() && auth()->user()->isAdmin()){
            return $next($request);
        }
        return redirect()->route('home');

    }
}
