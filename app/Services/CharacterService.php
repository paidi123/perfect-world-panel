<?php

namespace App\Services;

use App\Models\Character;
use App\Models\ItemDistribution;

class CharacterService
{
    public function updateLevel(Character $character, $level)
    {
        $character->level = min($level, 150); // Max level 150
        $character->save();
        return $character;
    }

    public function addCurrency(Character $character, $type, $amount, $reason = null)
    {
        if (!in_array($type, ['money', 'yuanBao', 'boundYuanBao'])) {
            throw new \InvalidArgumentException('Invalid currency type');
        }

        $character->{$type} += abs($amount);
        $character->save();

        return $character;
    }

    public function removeCurrency(Character $character, $type, $amount)
    {
        if (!in_array($type, ['money', 'yuanBao', 'boundYuanBao'])) {
            throw new \InvalidArgumentException('Invalid currency type');
        }

        $current = $character->{$type};
        if ($current < $amount) {
            throw new \Exception('Insufficient currency');
        }

        $character->{$type} -= $amount;
        $character->save();

        return $character;
    }

    public function resetCharacter(Character $character)
    {
        return $character->update([
            'level' => 1,
            'experience' => 0,
            'money' => 0,
            'yuanBao' => 0,
        ]);
    }

    public function getCharacterStats(Character $character)
    {
        return [
            'level' => $character->level,
            'experience' => $character->experience,
            'money' => $character->money,
            'yuanBao' => $character->yuanBao,
            'boundYuanBao' => $character->boundYuanBao,
            'play_time' => $character->play_time,
            'last_login' => $character->last_login,
        ];
    }
}
