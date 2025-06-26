<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    protected $fillable = [
        'steam_id',
        'first_name',
        'last_name',
        'phone_number',
        'rank_id',
        'is_dispatcher',
        'duty_status',
        'duty_started_at',
        'current_location',
    ];

    protected $casts = [
        'is_dispatcher' => 'boolean',
        'duty_started_at' => 'datetime',
    ];

    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }

    public function vehicleAssignments(): HasMany
    {
        return $this->hasMany(VehicleAssignment::class);
    }

    public function currentVehicleAssignment(): HasOne
    {
        return $this->hasOne(VehicleAssignment::class)->where('status', 'active');
    }

    public function getCurrentVehicle()
    {
        return $this->currentVehicleAssignment?->vehicle;
    }

    public function isOnDuty(): bool
    {
        return in_array($this->duty_status, ['available', 'busy', 'break']);
    }

    public function canDispatch(): bool
    {
        return $this->is_dispatcher && $this->isOnDuty();
    }
}
