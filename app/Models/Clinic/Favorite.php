<?php

namespace App\Models\Clinic;

use App\Models\Service\Offer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['clinic_id', 'offer_id', 'app_user_id', 'type'];
    protected $hidden = ['created_at','updated_at'];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    public function getFavoriteTypeAttribute()
    {
        return ['Clinic','Offer'][$this->type];
    }
}
