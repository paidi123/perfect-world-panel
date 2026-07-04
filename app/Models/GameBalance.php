<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ActivityLog\Traits\LogsActivity;
use Spatie\ActivityLog\LogOptions;

class GameBalance extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'balance_type',
        'balance_key',
        'value',
        'description',
        'is_active',
    ];

    protected $casts = [
        'value' => 'float',
        'is_active' => 'boolean',
    ];

    public function getActivitylog(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['value', 'is_active'])
            ->useLogName('game_balance');
    }
}
