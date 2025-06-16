<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $fillable = [
        'steam_id',
        'first_name',
        'last_name',
        'phone_number',
        'rank_id',
    ];

    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }
}
