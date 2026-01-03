<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'room_id',
        'booking_date',
        'start_time',
        'end_time',
        'duration_type',
        'purpose',
        'status',
        'google_calendar_event_id',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function log(string $action, ?string $from = null, ?string $to = null, ?string $note = null)
    {
        $this->logs()->create([
            'user_id' => auth()->id(),
            'action' => $action,
            'from_status' => $from,
            'to_status' => $to,
            'note' => $note,
        ]);
    }

    public function logs()
    {
        return $this->hasMany(BookingLog::class);
    }
}
