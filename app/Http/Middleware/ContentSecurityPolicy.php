<?php
namespace App\Http\Middleware;

use Closure;

class ContentSecurityPolicy
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
        $response = $next($request);

        $csp = "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.gstatic.com https://www.googleapis.com; ";
        $csp .= "style-src 'self' 'unsafe-inline' https://stackpath.bootstrapcdn.com;";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}