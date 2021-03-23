<?php

namespace App\Models\Service;

use App\Models\Clinic\Clinic;
use App\Models\Data\Tip;
use App\Models\User\AppUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reserve extends Model
{
    use HasFactory;

    protected $appends = ['clinic_name', 'service_name', 'service_price', 'offer_name', 'offer_price_before', 'offer_price_after', 'status_name','tip_image','clinic_location','day_name'];
    protected $hidden = ['created_at', 'updated_at','service','offer','clinic'];

    public function app_user()
    {
        return $this->belongsTo(AppUser::class, 'app_user_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class) ;
    }
    public function offer()
    {
        return $this->belongsTo(Offer::class,'service_id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function getStatusNameAttribute()
    {
        return ['جديد', 'مكتمل', 'غير مكتمل عدم حضور العميل', 'إلغاء من العيادة', 'إلغاء من العميل','تم الحجز'][$this->status];
    }

    public function getAppointmentDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getAppointmentTimeAttribute($value)
    {
        return Carbon::parse($value)->format('H:i a');
    }

    public function getServiceNameAttribute()
    {
        return $this->service_type == 'service' ? $this->service->name_ar ?? '' : '';
    }
    public function getOfferNameAttribute()
    {
        return $this->service_type == 'offer' ? $this->offer->name_ar ?? '' : '';
    }

    public function getServicePriceAttribute()
    {
        return $this->service_type == 'service' ?  $this->service->price ?? '' : '';
    }
    public function getOfferPriceBeforeAttribute()
    {
        return $this->service_type == 'offer' ? $this->offer->price_before ?? '' : '';
    }
    public function getOfferPriceAfterAttribute()
    {
        return $this->service_type == 'offer' ? $this->offer->price_after ?? '' : '';
    }

    public function getClinicNameAttribute()
    {
        return $this->clinic->name_ar ?? '';
    }
    public function getClinicLocationAttribute()
    {
        $location = Str::replaceFirst('(', '', $this->clinic->location);
        $location = Str::replaceLast(')', '', $location);
        return $location;
    }

    public function getTipImageAttribute()
    {
        $tip = Tip::orderBy('id', 'desc')->first();
        if (!$tip) return null;
        return $tip->image_url;
    }
    public function getDayNameAttribute()
    {
        Carbon::setLocale('ar');
        return Carbon::parse($this->appointment_date)->getTranslatedDayName();
    }
}
