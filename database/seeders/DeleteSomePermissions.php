<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DeleteSomePermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::wherein('name', ['show users', 'create users', 'edit users', 'delete users'])->get()->pluck('id');
        Permission::destroy($permissions);
    }
}
