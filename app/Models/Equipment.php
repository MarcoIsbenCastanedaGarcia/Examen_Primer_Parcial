<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment';

    protected $fillable = [
        'category_id',
        'inventory_code',
        'name',
        'brand',
        'model',
        'serial_number',
        'description',
        'availability_status',
        'physical_state',
        'location',
        'notes',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function loanItems(): HasMany
    {
        return $this->hasMany(LoanItem::class);
    }

    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query
            ->where(
                'availability_status',
                'disponible'
            )
            ->whereNotIn(
                'physical_state',
                [
                    'danado',
                    'mantenimiento',
                    'baja',
                ]
            );
    }

    public function hasActiveIncidents(): bool
    {
        return $this->incidents()
            ->whereNotIn(
                'status',
                ['cerrada']
            )
            ->exists();
    }
}