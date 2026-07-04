<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ActivityLog\Traits\LogsActivity;
use Spatie\ActivityLog\LogOptions;

class Item extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'item_id',
        'item_name',
        'item_type',
        'item_quality',
        'level_required',
        'price',
        'description',
        'is_tradeable',
        'is_stackable',
        'max_stack',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'level_required' => 'integer',
        'is_tradeable' => 'boolean',
        'is_stackable' => 'boolean',
        'max_stack' => 'integer',
    ];

    public function distributions(): HasMany
    {
        return $this->hasMany(ItemDistribution::class);
    }

    public function getActivitylog(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['item_name', 'price', 'description'])
            ->useLogName('item');
    }
}
