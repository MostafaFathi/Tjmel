<?php

namespace App\Models\Service;

use App\Helpers\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public function getImageAttribute($value)
    {
        if ($value)
            return File::getUrl($value);
        else
            return null;
    }
}
