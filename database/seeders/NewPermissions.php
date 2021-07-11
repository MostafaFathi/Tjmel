<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class NewPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'Show Dashboard', 'guard_name' => 'web']);
        Permission::create(['name' => 'Manage Advertisements', 'guard_name' => 'web']);
        Permission::create(['name' => 'Manage Tips', 'guard_name' => 'web']);
        Permission::create(['name' => 'Manage Clinics', 'guard_name' => 'web']);
        Permission::create(['name' => 'Manage Sections', 'guard_name' => 'web']);
        Permission::create(['name' => 'Manage Services', 'guard_name' => 'web']);
        Permission::create(['name' => 'Manage Offers', 'guard_name' => 'web']);
        Permission::create(['name' => 'Manage Reservations', 'guard_name' => 'web']);
        Permission::create(['name' => 'Manage App users', 'guard_name' => 'web']);
        Permission::create(['name' => 'Manage Rates', 'guard_name' => 'web']);
        Permission::create(['name' => 'Manage Settings', 'guard_name' => 'web']);
        Permission::create(['name' => 'Manage Web users', 'guard_name' => 'web']);
        Permission::create(['name' => 'Manage About us', 'guard_name' => 'web']);
        Permission::create(['name' => 'Manage Agreement', 'guard_name' => 'web']);
        Permission::create(['name' => 'Manage Contact us', 'guard_name' => 'web']);
        Permission::create(['name' => 'Manage Clinic requests', 'guard_name' => 'web']);
        Permission::create(['name' => 'Manage Telescope', 'guard_name' => 'web']);
        $allPermissions = Permission::get()->pluck('name');
        $user = User::where('email', 'dev-team@tjmel-sa.com')->first();
        $user->syncPermissions([$allPermissions]);
    }
}
