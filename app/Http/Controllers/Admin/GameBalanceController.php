<?php

namespace App\Http\Controllers\Admin;

use App\Models\GameBalance;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GameBalanceController extends Controller
{
    public function index()
    {
        $balances = GameBalance::all();
        return response()->json($balances);
    }

    public function show(GameBalance $balance)
    {
        return response()->json($balance);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'balance_type' => 'required|string',
            'balance_key' => 'required|unique:game_balances|string',
            'value' => 'required|numeric|min:0',
            'description' => 'string',
            'is_active' => 'boolean',
        ]);

        $balance = GameBalance::create($validated);
        return response()->json($balance, 201);
    }

    public function update(Request $request, GameBalance $balance)
    {
        $validated = $request->validate([
            'value' => 'numeric|min:0',
            'description' => 'string',
            'is_active' => 'boolean',
        ]);

        $balance->update($validated);
        return response()->json($balance);
    }

    public function destroy(GameBalance $balance)
    {
        $balance->delete();
        return response()->json(null, 204);
    }
}
