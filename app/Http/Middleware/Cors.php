<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, DELETE, PUT, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Origin, Authorization, X-Requested-With, X-XSRF-TOKEN');
    }
}
