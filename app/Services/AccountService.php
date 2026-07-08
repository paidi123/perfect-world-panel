<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Character;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class AccountService
{
    public function createAccount($userId, $accountName)
    {
        return Account::create([
            'user_id' => $userId,
            'account_name' => $accountName,
            'account_status' => 'active',
        ]);
    }

    public function banAccount(Account $account, $reason, $duration = null)
    {
        return $account->update([
            'is_banned' => true,
            'ban_reason' => $reason,
            'ban_until' => $duration ? now()->addDays($duration) : null,
        ]);
    }

    public function unbanAccount(Account $account)
    {
        return $account->update([
            'is_banned' => false,
            'ban_reason' => null,
            'ban_until' => null,
        ]);
    }

    public function getAccountStats(Account $account)
    {
        return [
            'total_characters' => $account->characters()->count(),
            'online_characters' => $account->characters()->where('status', 'online')->count(),
            'total_transactions' => $account->transactions()->count(),
            'total_spent' => $account->transactions()
                ->where('status', 'completed')
                ->sum('amount'),
        ];
    }

    public function deleteAccount(Account $account)
    {
        return $account->forceDelete();
    }
}
