<?php

namespace App\Models\Service;

use App\Helpers\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at'];

    public function getImageAttribute($value)
    {
        if ($value)
            return File::getUrl($value);
        else
            return null;
    }
}
