<?php

namespace App\Services;

use App\Models\ItemDistribution;
use App\Models\Character;
use App\Models\Account;
use App\Models\Item;

class ItemService
{
    public function distributeItem(Item $item, $recipientId, $quantity, $reason = null, $adminId = null)
    {
        $recipient = Character::findOrFail($recipientId);

        return ItemDistribution::create([
            'item_id' => $item->id,
            'character_id' => $recipient->id,
            'account_id' => $recipient->account_id,
            'quantity' => $quantity,
            'reason' => $reason,
            'distributed_by' => $adminId,
            'distributed_at' => now(),
        ]);
    }

    public function bulkDistribute(Item $item, $characterIds, $quantity, $reason = null, $adminId = null)
    {
        $distributions = [];
        foreach ($characterIds as $characterId) {
            $distributions[] = $this->distributeItem($item, $characterId, $quantity, $reason, $adminId);
        }
        return $distributions;
    }

    public function distributeToAccount(Item $item, Account $account, $quantity, $reason = null, $adminId = null)
    {
        $mainCharacter = $account->characters()->first();
        if (!$mainCharacter) {
            throw new \Exception('Account has no characters');
        }

        return $this->distributeItem($item, $mainCharacter->id, $quantity, $reason, $adminId);
    }

    public function getDistributionHistory(Item $item)
    {
        return $item->distributions()
            ->with('character', 'account', 'distributedBy')
            ->latest()
            ->get();
    }
}
