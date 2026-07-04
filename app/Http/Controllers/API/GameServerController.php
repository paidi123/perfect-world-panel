<?php

namespace App\Http\Controllers\API;

use App\Models\GameServer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GameServerController extends Controller
{
    public function index()
    {
        $servers = GameServer::where('is_active', true)
            ->select('id', 'server_name', 'status', 'current_players', 'max_players')
            ->get();

        return response()->json($servers);
    }

    public function show(GameServer $server)
    {
        return response()->json($server);
    }
}
