<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThingDescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'thing_id',
        'description',
        'created_by',
    ];

    public function thing()
    {
        return $this->belongsTo(Thing::class, 'thing_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
