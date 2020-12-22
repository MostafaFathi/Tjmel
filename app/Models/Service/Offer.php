<?php

namespace App\Models\Service;

use App\Models\Clinic\Clinic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $appends = ['status_name', 'status_color'];

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
}
