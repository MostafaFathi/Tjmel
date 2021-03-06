<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(UsersSeeder::class);
//        $this->call(PermissionsSeeder::class);
        $this->call(DeleteSomePermissions::class);
        $this->call(NewPermissions::class);
        $this->call(NewRole::class);
//        $this->call(SettingSeeder::class);
//        $this->call(VisitorsSeed::class);
    }
}
