<?php

namespace App\Http\Controllers\Admin;

use App\Models\PlayerReport;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PlayerReportController extends Controller
{
    public function index(Request $request)
    {
        $reports = PlayerReport::with('reporter', 'reportedCharacter', 'handledBy')
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->type, function ($query) use ($request) {
                $query->where('report_type', $request->type);
            })
            ->latest()
            ->paginate(15);

        return response()->json($reports);
    }

    public function show(PlayerReport $report)
    {
        $report->load('reporter', 'reportedCharacter', 'handledBy');
        return response()->json($report);
    }

    public function update(Request $request, PlayerReport $report)
    {
        $validated = $request->validate([
            'status' => 'in:pending,investigating,resolved,dismissed',
            'action_taken' => 'string',
        ]);

        if ($validated['status'] !== 'pending' && !$report->handled_by) {
            $validated['handled_by'] = auth()->id();
        }

        if ($validated['status'] === 'resolved' || $validated['status'] === 'dismissed') {
            $validated['resolved_at'] = now();
        }

        $report->update($validated);
        return response()->json($report);
    }

    public function destroy(PlayerReport $report)
    {
        $report->delete();
        return response()->json(null, 204);
    }
}
