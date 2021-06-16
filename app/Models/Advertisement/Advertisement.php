<?php

namespace App\Models\Advertisement;

use App\Helpers\File;
use App\Models\Clinic\Clinic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $hidden = ['title_ar', 'title_en', 'image', 'description_ar', 'description_en', 'created_at', 'updated_at'];
    protected $appends = ['image_url'];

    public function clinic()
    {
        if ($this->clinic_id == 0) return null;
        return $this->belongsTo(Clinic::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image)
            return File::getUrl($this->image);
        else
            return null;
    }
}
