<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountOwnership
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $accountId = $request->route('account')?->id ?? $request->input('account_id');

        if ($accountId && !$user->hasRole('admin')) {
            $account = \App\Models\Account::find($accountId);
            if (!$account || $account->user_id !== $user->id) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        return $next($request);
    }
}
