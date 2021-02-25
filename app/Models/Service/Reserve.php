<?php

namespace App\Models\Service;

use App\Models\Clinic\Clinic;
use App\Models\Data\Tip;
use App\Models\User\AppUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;

    protected $appends = ['clinic_name', 'service_name', 'service_price', 'status_name','tip_image'];
    protected $hidden = ['created_at', 'updated_at'];

    public function app_user()
    {
        return $this->belongsTo(AppUser::class, 'app_user_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function getStatusNameAttribute()
    {
        return ['جديد', 'مكتمل', 'غير مكتمل عدم حضور العميل', 'إلغاء من العيادة', 'إلغاء من العميل'][$this->status];
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
        return $this->service->name_ar ?? '';
    }

    public function getServicePriceAttribute()
    {
        return $this->service->price ?? '';
    }

    public function getClinicNameAttribute()
    {
        return $this->clinic->name_ar ?? '';
    }

    public function getTipImageAttribute()
    {
        $tip = Tip::orderBy('id', 'desc')->first();
        if (!$tip) return null;
        return $tip->image_url;
    }
}
