<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function reviewedLoans(): HasMany
    {
        return $this->hasMany(
            Loan::class,
            'reviewed_by'
        );
    }

    public function deliveredLoans(): HasMany
    {
        return $this->hasMany(
            Loan::class,
            'delivered_by'
        );
    }

    public function returnedLoans(): HasMany
    {
        return $this->hasMany(
            Loan::class,
            'returned_by'
        );
    }

    public function reportedIncidents(): HasMany
    {
        return $this->hasMany(
            Incident::class,
            'reported_by'
        );
    }

    public function attendedIncidents(): HasMany
    {
        return $this->hasMany(
            Incident::class,
            'attended_by'
        );
    }

    public function isSolicitante(): bool
    {
        return $this->role === 'solicitante';
    }

    public function isEncargado(): bool
    {
        return $this->role === 'encargado';
    }
}