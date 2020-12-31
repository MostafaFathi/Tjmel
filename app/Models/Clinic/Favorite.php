<?php

namespace App\Models\Clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['clinic_id', 'app_user_id'];
    protected $hidden = ['created_at','updated_at'];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
