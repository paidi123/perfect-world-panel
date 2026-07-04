<?php

namespace App\Http\Controllers\API;

use App\Models\PlayerReport;
use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reported_character_id' => 'required|exists:characters,id',
            'report_type' => 'required|in:cheat,abuse,botting,rmt,spam,other',
            'report_description' => 'required|string|max:1000',
            'evidence' => 'nullable|string',
        ]);

        $user = auth()->user();
        $character = Character::whereHas('account', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->first();

        if (!$character) {
            return response()->json(['message' => 'No character found for your account'], 422);
        }

        $validated['reporter_id'] = $character->id;
        $report = PlayerReport::create($validated);

        return response()->json([
            'message' => 'Report submitted successfully',
            'report' => $report,
        ], 201);
    }

    public function myReports()
    {
        $user = auth()->user();
        $character = Character::whereHas('account', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->first();

        if (!$character) {
            return response()->json([]);
        }

        $reports = PlayerReport::where('reporter_id', $character->id)
            ->latest()
            ->paginate(10);

        return response()->json($reports);
    }
}
