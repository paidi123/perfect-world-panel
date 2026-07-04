<?php

namespace App\Http\Controllers\Admin;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $announcements = Announcement::when($request->type, function ($query) use ($request) {
            $query->where('announcement_type', $request->type);
        })
            ->when($request->published, function ($query) use ($request) {
                if ($request->published === 'true') {
                    $query->where('is_published', true);
                }
            })
            ->latest()
            ->paginate(15);

        return response()->json($announcements);
    }

    public function show(Announcement $announcement)
    {
        return response()->json($announcement);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'announcement_type' => 'in:news,maintenance,event,urgent',
            'is_published' => 'boolean',
            'expired_at' => 'nullable|date|after:now',
        ]);

        $validated['created_by'] = auth()->id();
        if ($validated['is_published'] ?? false) {
            $validated['published_at'] = now();
        }

        $announcement = Announcement::create($validated);
        return response()->json($announcement, 201);
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
            'announcement_type' => 'in:news,maintenance,event,urgent',
            'is_published' => 'boolean',
            'expired_at' => 'nullable|date|after:now',
        ]);

        if ($validated['is_published'] ?? false && !$announcement->is_published) {
            $validated['published_at'] = now();
        }

        $announcement->update($validated);
        return response()->json($announcement);
    }

    public function publish(Announcement $announcement)
    {
        $announcement->update([
            'is_published' => true,
            'published_at' => now(),
        ]);

        return response()->json(['message' => 'Announcement published successfully']);
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return response()->json(null, 204);
    }
}
