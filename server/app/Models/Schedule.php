<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'doctor_id',
        'room_id',
        'day',
        'period',
        'booking_limit',
    ];

    public function doctor()
    {
        return $this->belongsTo(DoctorProfile::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
