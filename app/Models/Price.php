<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'duration_type',
        'duration_value',
        'price',
        'usage_type',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
