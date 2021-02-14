<?php

namespace App\Models\Clinic;

use App\Helpers\File;
use App\Models\Data\City;
use App\Models\Data\District;
use App\Models\Service\Offer;
use App\Models\Service\Reserve;
use App\Models\Service\Service;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Clinic extends Model
{
    use HasFactory;

    protected $hidden = ['images', 'city_id', 'district_id', 'created_at', 'updated_at', 'city', 'district', 'location'];
    protected $casts = [
        'images' => 'json'
    ];
    //,'city_name','district_name'
    protected $appends = ['rating', 'images_urls', 'location_on_map', 'city', 'district', 'is_favorite'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reserve::class);
    }

    public function rejectedReservationsByClinic()
    {
        return $this->hasMany(Reserve::class)->where('status', 3);
    }

    public function getLogoAttribute($logo)
    {
        if ($logo)
            return File::getUrl($logo);
        else
            return null;
    }

    public function getImagesUrlsAttribute()
    {
        $urlImages = [];
        if ($this->images != null) {
            foreach ($this->images as $image) {
                array_push($urlImages, File::getUrl($image));
            }
        }
        return $urlImages;
    }

    public function getRatingAttribute()
    {
        $rate = count($this->rates) > 0 ? $this->rates->sum('rate') / count($this->rates) : 0;
        return $rate;
    }

    public function getIsFavoriteAttribute()
    {
        if (auth('sanctum')->user()->id == 10101010)
            return null;
//        dd(auth('sanctum')->user()->favorites);
        $isFavorite = false;
        foreach (auth('sanctum')->user()->favorites as $favorite) {
           if ($favorite->clinic_id == $this->id){
               $isFavorite = true;
               break;
           }
        }
        return $isFavorite;
    }

//    public function getCityNameAttribute()
//    {
//        return $this->city->name_ar ?? '';
//    }
//    public function getDistrictNameAttribute()
//    {
//        return $this->district->name_ar ?? '';
//    }
    public function getLocationOnMapAttribute()
    {
        $location = Str::replaceFirst('(', '', $this->location);
        $location = Str::replaceLast(')', '', $location);
        return $location;
    }

    public function getCityAttribute()
    {
        return trim(explode('-', $request->city_district ?? '')[0] ?? '');
    }

    public function getDistrictAttribute()
    {
        return trim(explode('-', $request->city_district ?? '')[1] ?? '');
    }
}
