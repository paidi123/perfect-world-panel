<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ActivityLog\Traits\LogsActivity;
use Spatie\ActivityLog\LogOptions;

class GameEvent extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'event_name',
        'event_description',
        'event_type',
        'start_date',
        'end_date',
        'reward_item_id',
        'reward_quantity',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'reward_quantity' => 'integer',
    ];

    public function getActivitylog(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['event_name', 'event_type', 'is_active'])
            ->useLogName('game_event');
    }
}
