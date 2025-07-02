<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeTraining extends Model
{
    protected $fillable = [
        'employee_id',
        'training_id',
        'completed_at',
        'expires_at',
        'trainer_id',
        'notes',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'trainer_id');
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at < now();
    }

    public function isValid(): bool
    {
        return $this->completed_at && (!$this->expires_at || !$this->isExpired());
    }
}
