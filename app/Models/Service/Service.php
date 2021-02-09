<?php

namespace App\Models\Service;

use App\Models\Clinic\Clinic;
use App\Models\Data\Setting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $appends = ['status_name', 'status_color', 'clinic_logo', 'section_name', 'section_logo','advanced_payment', 'earliest_appointment'];
    protected $hidden = ['created_at', 'updated_at', 'clinic', 'section'];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class)->orderBy('date', 'asc');
    }

    public function reservations()
    {
        return $this->hasMany(Reserve::class);
    }

    public function getStatusNameAttribute()
    {
        return ['قيد الانتظار', 'تم نشره', 'مرفوض'][$this->status];
    }

    public function getStatusColorAttribute()
    {
        return ['warning', 'success', 'danger'][$this->status];
    }

    public function getClinicLogoAttribute()
    {
        return $this->clinic->logo;
    }

    public function getSectionLogoAttribute()
    {
        return $this->section->image;
    }

    public function getSectionNameAttribute()
    {
        return $this->section->title_ar;
    }

    public function getAdvancedPaymentAttribute()
    {
        return Setting::getValue('advance_payment');
    }

    public function getEarliestAppointmentAttribute()
    {
        $appointments = $this->appointments->where('date', '>=', Carbon::today());
        foreach ($appointments as $appointment) {
            foreach ($appointment->times as $time) {
                if (!$time['status']) {
                    $myTime = Carbon::createFromFormat('Y-m-d H:i a', $appointment->date->format('Y-m-d') . ' ' . $time['time']);
                    if ((Carbon::today()->format('Y-m-d') == $appointment->date->format('Y-m-d'))) {
                        if ($myTime > Carbon::now()) {
                            Carbon::setLocale('ar');
                            return $myTime->diffForHumans();
                        }
                    } else {
                        Carbon::setLocale('ar');
                        return $myTime->diffForHumans();
                    }

                }
            }
        }
        return 'لا يوجد موعد متاح';
    }
}
