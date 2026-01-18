<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thing extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'wrnt',
        'master_id',
        'current_description_id',
        'total_amount',
        'unit_id',
    ];

    public function master()
    {
        return $this->belongsTo(User::class, 'master_id');
    }

    public function currentDescription()
    {
        return $this->belongsTo(ThingDescription::class, 'current_description_id');
    }

    public function descriptions()
    {
        return $this->hasMany(ThingDescription::class);
    }

    public function uses()
    {
        return $this->hasMany(ThingUse::class, 'thing_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
