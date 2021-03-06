<?php

namespace App\Models\User;

use App\Helpers\File;

use App\Models\Clinic\Favorite;
use App\Models\Order\Cart;
use App\Models\Order\Order;
use App\Models\Service\Reserve;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class AppUser extends Authenticatable
{
    use HasApiTokens, HasRoles, Notifiable, HasFactory;

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at',
        'account_type',
        'otp_code',
        'email'
    ];
    protected $appends = ['current_address','status_name'];
    protected $with = ['addresses'];

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reserve::class)->orderBy('id','desc');
    }
    public function addresses()
    {
        return $this->hasMany(UserAddress::class, 'app_user_id');
    }
    public function getImageAttribute($value)
    {
        if (Str::contains($value, '*facebook*')) {
            return Str::replaceFirst('*facebook*', '', $value);
        } else {
            return File::getUrl($value);
        }
    }
    public function getCurrentAddressAttribute()
    {
        return $this->addresses->where('is_current',true)->first();
    }
    public function getStatusNameAttribute()
    {
        return ['فعال','محظور'][$this->status];
    }

}
