<?php
namespace App\Http\Middleware;

use Closure;
use App\Libraries\Util;

class ApiAuthenticate
{
    public function handle($request, Closure $next)
    {
        if ($request->bearerToken() === env('API_KEY')) {
            return $next($request);
        } else {
            return Util::responseJson(401, '8888', 'Invalid Access Key', []);
        }
    }
}
