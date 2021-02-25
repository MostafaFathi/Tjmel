<?php

namespace App\Models\Data;

use App\Helpers\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at'];
    protected $appends = ['image_url'];
    public function getImageUrlAttribute()
    {
        if ($this->image)
            return File::getUrl($this->image);
        else
            return null;
    }
}
