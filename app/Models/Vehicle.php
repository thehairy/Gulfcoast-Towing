<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vehicle extends Model
{
    protected $fillable = [
        'name',
        'type',
        'license_plate',
        'status',
        'description',
        'requires_special_license',
        'capabilities',
    ];

    protected $casts = [
        'capabilities' => 'array',
        'requires_special_license' => 'boolean',
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(VehicleAssignment::class);
    }

    public function currentAssignment(): HasOne
    {
        return $this->hasOne(VehicleAssignment::class)->where('status', 'active');
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available' && !$this->currentAssignment;
    }

    public function getCurrentDriver()
    {
        return $this->currentAssignment?->employee;
    }
}
