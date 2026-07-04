<?php

namespace App\Http\Controllers\API;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $announcements = Announcement::where('is_published', true)
            ->when($request->type, function ($query) use ($request) {
                $query->where('announcement_type', $request->type);
            })
            ->where(function ($query) {
                $query->whereNull('expired_at')
                    ->orWhere('expired_at', '>', now());
            })
            ->latest('published_at')
            ->paginate(10);

        return response()->json($announcements);
    }

    public function show(Announcement $announcement)
    {
        if (!$announcement->is_published) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($announcement);
    }
}
