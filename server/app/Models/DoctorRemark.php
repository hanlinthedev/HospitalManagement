<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorRemark extends Model
{
    use HasFactory;
    
    protected $fillable = ['appointment_id', 'remark'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
