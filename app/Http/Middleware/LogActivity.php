<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\ActivityLog\Facades\ActivityLog;

class LogActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (auth()->check() && in_array($request->method(), ['POST', 'PUT', 'DELETE'])) {
            ActivityLog::useLog('admin-activity')
                ->performedOn(null)
                ->causedBy(auth()->user())
                ->withProperties([
                    'method' => $request->method(),
                    'path' => $request->path(),
                    'ip' => $request->ip(),
                ])
                ->log($request->method() . ' - ' . $request->path());
        }

        return $response;
    }
}
