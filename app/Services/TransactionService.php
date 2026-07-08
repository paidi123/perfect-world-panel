<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Account;

class TransactionService
{
    public function createTransaction($accountId, $type, $amount, $currencyType, $reference = null, $notes = null, $adminId = null)
    {
        return Transaction::create([
            'account_id' => $accountId,
            'transaction_type' => $type,
            'amount' => $amount,
            'currency_type' => $currencyType,
            'status' => 'pending',
            'reference_id' => $reference,
            'notes' => $notes,
            'processed_by' => $adminId,
        ]);
    }

    public function completeTransaction(Transaction $transaction, $adminId = null)
    {
        return $transaction->update([
            'status' => 'completed',
            'processed_at' => now(),
            'processed_by' => $adminId,
        ]);
    }

    public function failTransaction(Transaction $transaction, $reason = null)
    {
        return $transaction->update([
            'status' => 'failed',
            'notes' => $reason,
        ]);
    }

    public function refundTransaction(Transaction $transaction)
    {
        if ($transaction->status !== 'completed') {
            throw new \Exception('Only completed transactions can be refunded');
        }

        return $transaction->update(['status' => 'cancelled']);
    }

    public function getAccountTransactions(Account $account)
    {
        return $account->transactions()
            ->with('processedBy')
            ->latest()
            ->get();
    }

    public function getTotalRevenue($days = 30)
    {
        return Transaction::where('status', 'completed')
            ->where('created_at', '>=', now()->subDays($days))
            ->sum('amount');
    }
}
