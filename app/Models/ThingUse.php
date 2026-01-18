<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThingUse extends Model
{
    use HasFactory;

    protected $table = 'use';

    protected $fillable = [
        'thing_id',
        'place_id',
        'user_id',
        'amount',
        'unit_id',
    ];

    public function thing()
    {
        return $this->belongsTo(Thing::class, 'thing_id');
    }

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
