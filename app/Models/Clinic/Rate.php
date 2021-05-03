<?php

namespace App\Models\Clinic;

use App\Models\User\AppUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at'];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
    public function app_user()
    {
        return $this->belongsTo(AppUser::class,'app_user_id');
    }

}
