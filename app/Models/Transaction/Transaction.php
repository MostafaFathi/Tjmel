<?php

namespace App\Models\Transaction;

use App\Models\Clinic\Clinic;
use App\Models\Service\Reserve;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
    public function reserve()
    {
        return $this->belongsTo(Reserve::class);
    }
}
