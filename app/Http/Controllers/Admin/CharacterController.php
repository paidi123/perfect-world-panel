<?php

namespace App\Http\Controllers\Admin;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CharacterController extends Controller
{
    public function index(Request $request)
    {
        $characters = Character::with('account')
            ->when($request->search, function ($query) use ($request) {
                $query->where('character_name', 'like', "%{$request->search}%");
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->class, function ($query) use ($request) {
                $query->where('class', $request->class);
            })
            ->latest()
            ->paginate(15);

        return response()->json($characters);
    }

    public function show(Character $character)
    {
        $character->load('account');
        return response()->json($character);
    }

    public function update(Request $request, Character $character)
    {
        $validated = $request->validate([
            'level' => 'integer|min:1|max:150',
            'experience' => 'integer|min:0',
            'money' => 'numeric|min:0',
            'yuanBao' => 'integer|min:0',
            'boundYuanBao' => 'integer|min:0',
            'status' => 'in:online,offline',
        ]);

        $character->update($validated);
        return response()->json($character);
    }

    public function addCurrency(Request $request, Character $character)
    {
        $validated = $request->validate([
            'type' => 'required|in:money,yuanBao,boundYuanBao',
            'amount' => 'required|integer|min:1',
            'reason' => 'string|max:255',
        ]);

        $character->{$validated['type']} += $validated['amount'];
        $character->save();

        return response()->json([
            'message' => 'Currency added successfully',
            'character' => $character,
        ]);
    }

    public function resetLevel(Character $character)
    {
        $character->update([
            'level' => 1,
            'experience' => 0,
        ]);

        return response()->json(['message' => 'Character level reset successfully']);
    }
}
