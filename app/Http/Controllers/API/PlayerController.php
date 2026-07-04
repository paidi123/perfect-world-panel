<?php

namespace App\Http\Controllers\API;

use App\Models\Account;
use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PlayerController extends Controller
{
    public function getAccounts(Request $request)
    {
        $user = auth()->user();
        $accounts = Account::where('user_id', $user->id)
            ->with('characters')
            ->get();

        return response()->json($accounts);
    }

    public function getCharacters(Request $request)
    {
        $user = auth()->user();
        $characters = Character::whereHas('account', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with('account')
            ->get();

        return response()->json($characters);
    }

    public function getCharacter(Character $character)
    {
        // Check if user owns this character
        $user = auth()->user();
        if ($character->account->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $character->load('account');
        return response()->json($character);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
        ]);

        $user->update($validated);
        return response()->json($user);
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed|different:current_password',
        ]);

        if (!\Hash::check($validated['current_password'], $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 422);
        }

        $user->update(['password' => \Hash::make($validated['password'])]);
        return response()->json(['message' => 'Password changed successfully']);
    }
}
