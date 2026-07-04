<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ActivityLog\Traits\LogsActivity;
use Spatie\ActivityLog\LogOptions;

class Character extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'account_id',
        'character_name',
        'level',
        'class',
        'faction',
        'gender',
        'experience',
        'money',
        'yuanBao',
        'boundYuanBao',
        'status',
        'last_login',
        'play_time',
    ];

    protected $casts = [
        'last_login' => 'datetime',
        'experience' => 'integer',
        'money' => 'decimal:2',
        'yuanBao' => 'integer',
        'boundYuanBao' => 'integer',
        'level' => 'integer',
        'play_time' => 'integer',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function getActivitylog(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['level', 'status', 'money', 'yuanBao'])
            ->useLogName('character');
    }
}
