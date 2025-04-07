<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'schedule_id',
        'patient_id',
        'booking_no',
        'booking_date',
        'status',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function patient()
    {
        return $this->belongsTo(PatientProfile::class);
    }

    public function remark()
    {
        return $this->hasOne(DoctorRemark::class);
    }
}
