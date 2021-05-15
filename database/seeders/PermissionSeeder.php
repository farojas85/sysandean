<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permi1 = Permission::firstOrCreate(['name' => 'sistema.inicio']);        
        $permi2 = Permission::firstOrCreate(['name' => 'roles.inicio']);
        $permi3 = Permission::firstOrCreate(['name' => 'roles.crear']);
        $permi4 = Permission::firstOrCreate(['name' => 'roles.mostrar']);
        $permi5 = Permission::firstOrCreate(['name' => 'roles.editar']);
        $permi6 = Permission::firstOrCreate(['name' => 'roles.eliminar']);
        $permi7 = Permission::firstOrCreate(['name' => 'usuarios.inicio']);
        $permi8 = Permission::firstOrCreate(['name' => 'usuarios.crear']);
        $permi9 = Permission::firstOrCreate(['name' => 'usuarios.mostrar']);
        $permi10 = Permission::firstOrCreate(['name' => 'usuarios.editar']);
        $permi11 = Permission::firstOrCreate(['name' => 'usuarios.eliminar']);
        $permi12 = Permission::firstOrCreate(['name' => 'usuarios.restaurar']);
        $permi13 = Permission::firstOrCreate(['name' => 'trabajadores.inicio']);
        $permi14 = Permission::firstOrCreate(['name' => 'trabajadores.crear']);
        $permi15 = Permission::firstOrCreate(['name' => 'trabajadores.mostrar']);
        $permi16 = Permission::firstOrCreate(['name' => 'trabajadores.editar']);
        $permi17 = Permission::firstOrCreate(['name' => 'trabajadores.eliminar']);
        $permi18 = Permission::firstOrCreate(['name' => 'trabajadores.restaurar']);
        $permi19 = Permission::firstOrCreate(['name' => 'permisos.inicio']);
        $permi20 = Permission::firstOrCreate(['name' => 'permisos.crear']);
        $permi21 = Permission::firstOrCreate(['name' => 'permisos.mostrar']);
        $permi22 = Permission::firstOrCreate(['name' => 'permisos.editar']);
        $permi23 = Permission::firstOrCreate(['name' => 'permisos.eliminar']);
        $permi24 = Permission::firstOrCreate(['name' => 'permiso-role.inicio']);
        $permi25 = Permission::firstOrCreate(['name' => 'permiso-role.guardar']);
        $permi25 = Permission::firstOrCreate(['name' => 'permiso-role.guardar']);

        //PERMISOS PARA SUPER USUARIOS
        $role1 = Role::where('name','master')->first();
        $role1->syncPermissions([
            $permi1->name,$permi2->name,$permi3->name,$permi4->name,$permi5->name,$permi6->name,$permi7->name,$permi8->name,$permi9->name,$permi10->name,
            $permi11->name,$permi12->name,$permi13->name,$permi14->name,$permi15->name,$permi16->name,$permi17->name,$permi18->name,$permi19->name,$permi20->name,
            $permi21->name,$permi22->name,$permi23->name,$permi24->name,$permi25->name
        ]);
        //PERMISOS PARA ADMINISTRADOR
        $role2 =Role::where('name','administrador')->first();
        $role2->syncPermissions([
            $permi1->name,$permi2->name,$permi3->name,$permi4->name,$permi5->name,$permi6->name,$permi7->name,$permi8->name,$permi9->name,$permi10->name,
            $permi11->name,$permi12->name,$permi13->name,$permi14->name,$permi15->name,$permi16->name,$permi17->name,$permi18->name,$permi19->name,$permi20->name,
            $permi21->name,$permi22->name,$permi23->name,$permi24->name,$permi25->name
        ]);

        //PERMISO PARA JEFES
        $role3 =Role::where('name','jefe')->first();
        $role3->syncPermissions([
            $permi1->name,
        ]);
    }
}
