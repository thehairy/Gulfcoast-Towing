<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
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
        'internal_notes',
    ];

    protected $casts = [
        'is_dispatcher' => 'boolean',
        'duty_started_at' => 'datetime',
    ];

    public function rank(): HasOne
    {
        return $this->hasOne(Rank::class, 'id', 'rank_id');
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

    public function employeeTrainings(): HasMany
    {
        return $this->hasMany(EmployeeTraining::class);
    }

    public function trainings(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Training::class, 'employee_trainings')
            ->withPivot(['completed_at', 'expires_at', 'trainer_id', 'notes'])
            ->withTimestamps();
    }

    public function trainedEmployees(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EmployeeTraining::class, 'trainer_id');
    }

    public function hasTraining(string $trainingCode): bool
    {
        return $this->trainings()
            ->where('code', $trainingCode)
            ->wherePivot('completed_at', '!=', null)
            ->wherePivot('expires_at', '>', now())
            ->orWherePivotNull('expires_at')
            ->exists();
    }

    public function canManageTrainings(): bool
    {
        $managementRanks = ['Training & Development Manager', 'Chief Operating Officer', 'Chief Executive Officer'];
        return in_array($this->rank->name, $managementRanks);
    }

    public function canEditEmployees(): bool
    {
        $executiveRanks = ['Chief Operating Officer', 'Chief Executive Officer'];
        return in_array($this->rank->name, $executiveRanks);
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'steam_id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->steam_id;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        // Employees don't use passwords, they use Steam auth
        return '';
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->{$this->getRememberTokenName()};
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->{$this->getRememberTokenName()} = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
