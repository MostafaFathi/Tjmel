<?php

namespace App\Models\Service;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $casts = ['times' => 'array','reserved_times' => 'array',
        'date' => 'date'];
    protected $hidden = ['created_at','date','reserved_times', 'updated_at', 'clinic_id', 'service_id'];
    protected $appends = ['appointment_date','day_name'];

    public function getAppointmentDateAttribute()
    {
        return Carbon::parse($this->date)->format('d-m-Y');
    }
    public function getDayNameAttribute()
    {
        return Carbon::parse($this->date)->getTranslatedDayName();
    }
}
