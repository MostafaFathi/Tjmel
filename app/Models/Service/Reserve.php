<?php

namespace App\Models\Service;

use App\Models\Clinic\Clinic;
use App\Models\User\AppUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;

    protected $appends = ['status_name'];

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
}
