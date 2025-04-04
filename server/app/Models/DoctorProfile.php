<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'specialization_id',
        'degree',
        'experience',
        'profile_picture',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
