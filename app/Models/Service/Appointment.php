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

    public function getTimesAttribute($value)
    {
        $value = json_decode($value,true);
        $newArray = [];
        if ($value != null and !empty($value)){
            foreach ($value  as $key => $item) {
                $myTime = Carbon::createFromFormat('Y-m-d H:i a', $this->date->format('Y-m-d') . ' ' . $item['time']);

                if ($item['status'] != "reserved" and $myTime > Carbon::now()->addHour())
                    array_push($newArray,$item);
            }
        }
        return $newArray;
    }
}
