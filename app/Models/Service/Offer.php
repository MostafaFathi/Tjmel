<?php

namespace App\Models\Service;

use App\Helpers\File;
use App\Models\Clinic\Clinic;
use App\Models\Data\Setting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Offer extends Model
{
    use HasFactory;

    protected $appends = ['status_name', 'status_color', 'is_favorite','favorite_type','clinic_logo', 'section_name', 'section_logo','advanced_payment','image_url', 'earliest_appointment'];
    protected $hidden = ['created_at','updated_at', 'section'];

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
        return $this->hasMany(Appointment::class,'service_id')->where('service_type','offer')->where('date', '>=', Carbon::today())->orderBy('date', 'asc');
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
    public function getImageUrlAttribute()
    {
        if ($this->image)
            return File::getUrl($this->image);
        else
            return null;
    }
    public function getFavoriteTypeAttribute()
    {
        return 'Offer';
    }
    public function getEarliestAppointmentAttribute()
    {
        $appointments = $this->appointments;
        foreach ($appointments as $appointment) {
            foreach ($appointment->times as $time) {
                if (!$time['status']) {
                    $myTime = Carbon::createFromFormat('Y-m-d H:i a', $appointment->date->format('Y-m-d') . ' ' . $time['time']);
                    if ((Carbon::today()->format('Y-m-d') == $appointment->date->format('Y-m-d'))) {
                        if ($myTime > Carbon::now()) {
                            Carbon::setLocale('ar');
                            return Str::replaceFirst('من الآن','',$myTime->diffForHumans());
                        }
                    } else {
                        Carbon::setLocale('ar');
                        return Str::replaceFirst('من الآن','',$myTime->diffForHumans());
                    }

                }
            }
        }
        return 'لا يوجد موعد متاح';
    }
    public function getIsFavoriteAttribute()
    {
        if (auth('sanctum')->user() and auth('sanctum')->user()->id == 10101010)
            return null;
//        dd(auth('sanctum')->user()->favorites);
        $isFavorite = false;
        foreach (auth('sanctum')->user()->favorites ?? [] as $favorite) {
            if ( $favorite->type == 1 and $favorite->offer_id == $this->id ){
                $isFavorite = true;
                break;
            }
        }
        return $isFavorite;
    }
}
