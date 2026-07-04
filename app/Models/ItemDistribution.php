<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ActivityLog\Traits\LogsActivity;
use Spatie\ActivityLog\LogOptions;

class ItemDistribution extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'item_id',
        'character_id',
        'account_id',
        'quantity',
        'reason',
        'distributed_by',
        'distributed_at',
    ];

    protected $casts = [
        'distributed_at' => 'datetime',
        'quantity' => 'integer',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function distributedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'distributed_by');
    }

    public function getActivitylog(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['quantity', 'reason'])
            ->useLogName('item_distribution');
    }
}
