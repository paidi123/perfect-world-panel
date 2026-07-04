<?php

namespace App\Http\Controllers\API;

use App\Models\Account;
use App\Models\Character;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function globalStats()
    {
        return response()->json([
            'total_accounts' => Account::count(),
            'active_accounts' => Account::where('account_status', 'active')->count(),
            'total_characters' => Character::count(),
            'online_characters' => Character::where('status', 'online')->count(),
            'total_transactions' => Transaction::count(),
            'total_revenue' => Transaction::where('status', 'completed')
                ->sum('amount'),
        ]);
    }

    public function playerStats(Request $request)
    {
        $user = auth()->user();
        $accounts = Account::where('user_id', $user->id)->get();
        
        $stats = [
            'total_characters' => Character::whereIn('account_id', $accounts->pluck('id'))->count(),
            'total_transactions' => Transaction::whereIn('account_id', $accounts->pluck('id'))->count(),
            'total_spent' => Transaction::whereIn('account_id', $accounts->pluck('id'))
                ->where('status', 'completed')
                ->sum('amount'),
        ];

        return response()->json($stats);
    }

    public function characterStats(Character $character)
    {
        $user = auth()->user();
        if ($character->account->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $stats = [
            'character_id' => $character->id,
            'character_name' => $character->character_name,
            'level' => $character->level,
            'class' => $character->class,
            'experience' => $character->experience,
            'money' => $character->money,
            'yuanBao' => $character->yuanBao,
            'play_time' => $character->play_time,
            'last_login' => $character->last_login,
        ];

        return response()->json($stats);
    }
}
