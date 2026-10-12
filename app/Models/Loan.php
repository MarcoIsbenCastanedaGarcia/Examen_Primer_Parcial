<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_at',
        'end_at',
        'purpose',
        'status',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
        'delivered_by',
        'delivered_at',
        'returned_by',
        'returned_at',
        'notes',
        'requested_at',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'reviewed_at' => 'datetime',
            'delivered_at' => 'datetime',
            'returned_at' => 'datetime',
            'requested_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'reviewed_by'
        );
    }

    public function deliveredBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'delivered_by'
        );
    }

    public function returnedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'returned_by'
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(LoanItem::class);
    }

    public function equipment(): BelongsToMany
    {
        return $this->belongsToMany(
            Equipment::class,
            'loan_items'
        )
            ->withPivot([
                'condition_on_delivery',
                'condition_on_return',
                'notes',
            ])
            ->withTimestamps();
    }
}