<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivedThing extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description_text',
        'owner_name',
        'last_user_name',
        'place_name',
        'restored_at',
        'restored_by_user_id',
    ];

    protected $casts = [
        'restored_at' => 'datetime',
    ];

    public function restoredBy()
    {
        return $this->belongsTo(User::class, 'restored_by_user_id');
    }
}
