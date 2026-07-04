<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ActivityLog\Traits\LogsActivity;
use Spatie\ActivityLog\LogOptions;

class GameServer extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'server_name',
        'server_ip',
        'server_port',
        'status',
        'max_players',
        'current_players',
        'is_active',
        'maintenance_mode',
        'last_restart',
    ];

    protected $casts = [
        'max_players' => 'integer',
        'current_players' => 'integer',
        'is_active' => 'boolean',
        'maintenance_mode' => 'boolean',
        'last_restart' => 'datetime',
    ];

    public function getActivitylog(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['server_name', 'status', 'is_active', 'maintenance_mode'])
            ->useLogName('game_server');
    }
}
