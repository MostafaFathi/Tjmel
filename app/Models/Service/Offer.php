<?php

namespace App\Models\Service;

use App\Models\Clinic\Clinic;
use App\Models\Data\Setting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $appends = ['status_name', 'status_color','clinic_logo', 'section_name', 'section_logo','advanced_payment',];
    protected $hidden = ['created_at','updated_at','clinic', 'section'];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
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
}
