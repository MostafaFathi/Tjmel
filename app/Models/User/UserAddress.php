<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $hidden = [ 'created_at', 'updated_at','app_user_id'];
    protected $casts = ['is_current'=>'boolean'];

}
