<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('X-API-KEY') !== config('api.key')) {
            return response()->json(['error' => 'Invalid API-key'], 401);
        }

        Log::debug('API Key Auth Middleware triggered. Api key is - '.config('app.api_key'));
        return $next($request);
    }
}
