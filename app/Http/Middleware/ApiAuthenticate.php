<?php
namespace App\Http\Middleware;

use Closure;

class ApiAuthenticate
{
    public function handle($request, Closure $next)
    {
        if ($request->bearerToken() === env('API_KEY')) {
            return $next($request);
        } else {
            return response('Invalid access key');
        }
    }
}
