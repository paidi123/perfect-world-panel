<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\Character;
use App\Models\Transaction;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_accounts' => Account::count(),
            'active_accounts' => Account::where('account_status', 'active')->count(),
            'banned_accounts' => Account::where('is_banned', true)->count(),
            'total_characters' => Character::count(),
            'online_characters' => Character::where('status', 'online')->count(),
            'total_transactions' => Transaction::count(),
            'pending_transactions' => Transaction::where('status', 'pending')->count(),
        ];

        $recentTransactions = Transaction::with('account')
            ->latest()
            ->limit(10)
            ->get();

        $recentReports = DB::table('player_reports')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        $accountGrowth = Account::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->get();

        return response()->json([
            'stats' => $stats,
            'recent_transactions' => $recentTransactions,
            'recent_reports' => $recentReports,
            'account_growth' => $accountGrowth,
        ]);
    }
}
