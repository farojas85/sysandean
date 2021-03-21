<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::firstOrCreate(['name' => 'master']);
        $role = Role::firstOrCreate(['name' => 'administrador']);
        $role = Role::firstOrCreate(['name' => 'jefe']);
    }
}
