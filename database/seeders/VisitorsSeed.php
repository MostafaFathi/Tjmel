<?php

namespace Database\Seeders;

use App\Models\User\AppUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VisitorsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppUser::create([
            'id' => 10101010,
            'name' => "Guest",
            'email' => 'Guest@tjmel.com',
            'password' => Hash::make("123123123"),
            'account_type' => 1,
        ]);
    }
}
