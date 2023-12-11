<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InvMgmtXplorAPI
{
    /**
     * Handle an incoming request 
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $bearToken = $request->bearerToken();
        $tokenValue = env('INV_API_TOKEN', 'chandan_api_topken');
        if ($bearToken == $tokenValue) {
            return $next($request);
        } else {
            return response([
                'message' => 'UnAuthorized access'
            ], 403);
        }
    }
}