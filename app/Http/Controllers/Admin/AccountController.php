<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $accounts = Account::with('user', 'characters')
            ->when($request->search, function ($query) use ($request) {
                $query->where('account_name', 'like', "%{$request->search}%")
                    ->orWhereHas('user', function ($q) use ($request) {
                        $q->where('email', 'like', "%{$request->search}%");
                    });
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('account_status', $request->status);
            })
            ->latest()
            ->paginate(15);

        return response()->json($accounts);
    }

    public function show(Account $account)
    {
        $account->load('user', 'characters', 'transactions');
        return response()->json($account);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'account_name' => 'required|unique:accounts|string|max:255',
            'account_status' => 'in:active,inactive,suspended',
        ]);

        $account = Account::create($validated);
        return response()->json($account, 201);
    }

    public function update(Request $request, Account $account)
    {
        $validated = $request->validate([
            'account_status' => 'in:active,inactive,suspended',
            'is_banned' => 'boolean',
            'ban_reason' => 'nullable|string',
            'ban_until' => 'nullable|date',
        ]);

        $account->update($validated);
        return response()->json($account);
    }

    public function ban(Request $request, Account $account)
    {
        $validated = $request->validate([
            'reason' => 'required|string',
            'until' => 'nullable|date|after:now',
        ]);

        $account->update([
            'is_banned' => true,
            'ban_reason' => $validated['reason'],
            'ban_until' => $validated['until'] ?? null,
        ]);

        return response()->json(['message' => 'Account banned successfully']);
    }

    public function unban(Account $account)
    {
        $account->update([
            'is_banned' => false,
            'ban_reason' => null,
            'ban_until' => null,
        ]);

        return response()->json(['message' => 'Account unbanned successfully']);
    }

    public function destroy(Account $account)
    {
        $account->delete();
        return response()->json(null, 204);
    }
}
