<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Support\Facades\Auth;

class AcceptLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        App::setLocale($request->header('Accept-Language'));

        return $next($request);
    }
}
