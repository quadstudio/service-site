<?php

namespace QuadStudio\Service\Site\Middleware;

/**
 * @license MIT
 * @package QuadStudio\Service\Site
 */


use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::check() && Auth::user()->admin == 1) {
            return $next($request);
        }
        return app()->abort(403);
    }
}