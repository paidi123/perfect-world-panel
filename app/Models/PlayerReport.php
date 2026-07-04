<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ActivityLog\Traits\LogsActivity;
use Spatie\ActivityLog\LogOptions;

class PlayerReport extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'reporter_id',
        'reported_character_id',
        'report_type',
        'report_description',
        'evidence',
        'status',
        'handled_by',
        'action_taken',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'reporter_id');
    }

    public function reportedCharacter(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'reported_character_id');
    }

    public function handledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function getActivitylog(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['report_type', 'status', 'action_taken'])
            ->useLogName('player_report');
    }
}
