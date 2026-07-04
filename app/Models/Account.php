<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ActivityLog\Traits\LogsActivity;
use Spatie\ActivityLog\LogOptions;

class Account extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id',
        'account_name',
        'account_status',
        'created_at',
        'last_login',
        'ban_reason',
        'ban_until',
        'is_banned',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'last_login' => 'datetime',
        'ban_until' => 'datetime',
        'is_banned' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function getActivitylog(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['account_name', 'account_status', 'is_banned'])
            ->useLogName('account');
    }
}
