<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info('Route accessed:', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'route' => $request->route()->getName(),
            'ip' => $request->ip(),
            // 'user_agent' => $request->header('User-Agent'),
        ]);

        return $next($request);
    }
}
