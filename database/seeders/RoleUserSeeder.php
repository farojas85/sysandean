<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleMaster = Role::findByName('master');

        $userMaster = User::firstOrCreate([
            'nombre' => 'Masrer',
            'usuario' =>'master',
            'email' => 'master@me.com',
            'password' => Hash::make('123456789'),
            'estado' => 1
        ]);

        $userMaster->syncRoles([$roleMaster->name]);
    }
}
