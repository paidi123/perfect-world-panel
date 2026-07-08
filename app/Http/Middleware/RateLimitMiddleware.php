<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RateLimitMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'rate-limit:' . auth()->id() . ':' . $request->path();
        $maxAttempts = 60;
        $decayMinutes = 1;

        if (cache()->has($key)) {
            $attempts = cache()->get($key);
            if ($attempts >= $maxAttempts) {
                return response()->json(['message' => 'Too many requests'], 429);
            }
            cache()->put($key, $attempts + 1, now()->addMinutes($decayMinutes));
        } else {
            cache()->put($key, 1, now()->addMinutes($decayMinutes));
        }

        return $next($request);
    }
}
