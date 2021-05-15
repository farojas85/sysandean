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
        $permi26 = Permission::firstOrCreate(['name' => 'materia-prima.inicio']);
        $permi27 = Permission::firstOrCreate(['name' => 'materia-prima.crear']);
        $permi28 = Permission::firstOrCreate(['name' => 'materia-prima.mostrar']);
        $permi29 = Permission::firstOrCreate(['name' => 'materia-prima.editar']);
        $permi30 = Permission::firstOrCreate(['name' => 'materia-prima.eliminar']);
        $permi31 = Permission::firstOrCreate(['name' => 'materia-prima.restaurar']);
        $permi32 = Permission::firstOrCreate(['name' => 'lotes.inicio']);
        $permi33 = Permission::firstOrCreate(['name' => 'lotes.crear']);
        $permi34 = Permission::firstOrCreate(['name' => 'lotes.mostrar']);
        $permi35 = Permission::firstOrCreate(['name' => 'lotes.editar']);
        $permi36 = Permission::firstOrCreate(['name' => 'lotes.eliminar']);
        $permi37 = Permission::firstOrCreate(['name' => 'lotes.restaurar']);
        $permi38 = Permission::firstOrCreate(['name' => 'pelado-quimico.inicio']);
        $permi39 = Permission::firstOrCreate(['name' => 'pelado-quimico.crear']);
        $permi40 = Permission::firstOrCreate(['name' => 'pelado-quimico.mostrar']);
        $permi41 = Permission::firstOrCreate(['name' => 'pelado-quimico.editar']);
        $permi42 = Permission::firstOrCreate(['name' => 'pelado-quimico.eliminar']);
        $permi43 = Permission::firstOrCreate(['name' => 'pelado-quimico.restaurar']);
        $permi44 = Permission::firstOrCreate(['name' => 'rectificados.inicio']);
        $permi45 = Permission::firstOrCreate(['name' => 'rectificados.crear']);
        $permi46 = Permission::firstOrCreate(['name' => 'rectificados.mostrar']);
        $permi47 = Permission::firstOrCreate(['name' => 'rectificados.editar']);
        $permi48 = Permission::firstOrCreate(['name' => 'rectificados.eliminar']);
        $permi49 = Permission::firstOrCreate(['name' => 'rectificados.restaurar']);
        $permi50 = Permission::firstOrCreate(['name' => 'plaqueados.inicio']);
        $permi51 = Permission::firstOrCreate(['name' => 'plaqueados.crear']);
        $permi52 = Permission::firstOrCreate(['name' => 'plaqueados.mostrar']);
        $permi53 = Permission::firstOrCreate(['name' => 'plaqueados.editar']);
        $permi54 = Permission::firstOrCreate(['name' => 'plaqueados.eliminar']);
        $permi55 = Permission::firstOrCreate(['name' => 'plaqueados.restaurar']);
        $permi56 = Permission::firstOrCreate(['name' => 'congelados.inicio']);
        $permi57 = Permission::firstOrCreate(['name' => 'congelados.crear']);
        $permi58 = Permission::firstOrCreate(['name' => 'congelados.mostrar']);
        $permi59 = Permission::firstOrCreate(['name' => 'congelados.editar']);
        $permi60 = Permission::firstOrCreate(['name' => 'congelados.eliminar']);
        $permi61 = Permission::firstOrCreate(['name' => 'congelados.restaurar']);
        $permi62 = Permission::firstOrCreate(['name' => 'envasados.inicio']);
        $permi63 = Permission::firstOrCreate(['name' => 'envasados.crear']);
        $permi64 = Permission::firstOrCreate(['name' => 'envasados.mostrar']);
        $permi65 = Permission::firstOrCreate(['name' => 'envasados.editar']);
        $permi66 = Permission::firstOrCreate(['name' => 'envasados.eliminar']);
        $permi67 = Permission::firstOrCreate(['name' => 'envasados.restaurar']);
        $permi68 = Permission::firstOrCreate(['name' => 'almacenados.inicio']);
        $permi69 = Permission::firstOrCreate(['name' => 'almacenados.crear']);
        $permi70 = Permission::firstOrCreate(['name' => 'almacenados.mostrar']);
        $permi71 = Permission::firstOrCreate(['name' => 'almacenados.editar']);
        $permi72 = Permission::firstOrCreate(['name' => 'almacenados.eliminar']);
        $permi73 = Permission::firstOrCreate(['name' => 'almacenados.restaurar']);

        //PERMISOS PARA SUPER USUARIOS
        $role1 = Role::where('name','master')->first();
        $role1->syncPermissions([
            $permi1->name,$permi2->name,$permi3->name,$permi4->name,$permi5->name,$permi6->name,$permi7->name,$permi8->name,$permi9->name,$permi10->name,
            $permi11->name,$permi12->name,$permi13->name,$permi14->name,$permi15->name,$permi16->name,$permi17->name,$permi18->name,$permi19->name,$permi20->name,
            $permi21->name,$permi22->name,$permi23->name,$permi24->name,$permi25->name,$permi26->name,$permi27->name,$permi28->name,$permi29->name,$permi30->name,
            $permi31->name,$permi32->name,$permi33->name,$permi34->name,$permi35->name,$permi36->name,$permi37->name,$permi38->name,$permi39->name,$permi40->name,
            $permi41->name,$permi42->name,$permi43->name,$permi44->name,$permi45->name,$permi46->name,$permi47->name,$permi48->name,$permi49->name,$permi50->name,
            $permi51->name,$permi52->name,$permi53->name,$permi54->name,$permi55->name,$permi56->name,$permi57->name,$permi58->name,$permi59->name,$permi60->name,
            $permi61->name,$permi62->name,$permi63->name,$permi64->name,$permi65->name,$permi66->name,$permi67->name,$permi68->name,$permi69->name,$permi70->name,
            $permi71->name,$permi72->name,$permi73->name
        ]);
        //PERMISOS PARA ADMINISTRADOR
        $role2 =Role::where('name','administrador')->first();
        $role2->syncPermissions([
            $permi1->name,$permi2->name,$permi3->name,$permi4->name,$permi5->name,$permi6->name,$permi7->name,$permi8->name,$permi9->name,$permi10->name,
            $permi11->name,$permi12->name,$permi13->name,$permi14->name,$permi15->name,$permi16->name,$permi17->name,$permi18->name,$permi19->name,$permi20->name,
            $permi21->name,$permi22->name,$permi23->name,$permi24->name,$permi25->name,$permi26->name,$permi27->name,$permi28->name,$permi29->name,$permi30->name,
            $permi31->name,$permi32->name,$permi33->name,$permi34->name,$permi35->name,$permi36->name,$permi37->name,$permi38->name,$permi39->name,$permi40->name,
            $permi41->name,$permi42->name,$permi43->name,$permi44->name,$permi45->name,$permi46->name,$permi47->name,$permi48->name,$permi49->name,$permi50->name,
            $permi51->name,$permi52->name,$permi53->name,$permi54->name,$permi55->name,$permi56->name,$permi57->name,$permi58->name,$permi59->name,$permi60->name,
            $permi61->name,$permi62->name,$permi63->name,$permi64->name,$permi65->name,$permi66->name,$permi67->name,$permi68->name,$permi69->name,$permi70->name,
            $permi71->name,$permi72->name,$permi73->name
        ]);

        //PERMISO PARA JEFES
        $role3 =Role::where('name','jefe')->first();
        $role3->syncPermissions([
            $permi1->name,$permi13->name,$permi14->name,$permi15->name,$permi16->name,$permi17->name,$permi18->name,
            $permi38->name,$permi39->name,$permi40->name,
            $permi41->name,$permi42->name,$permi43->name,$permi44->name,$permi45->name,$permi46->name,$permi47->name,$permi48->name,$permi49->name,$permi50->name,
            $permi51->name,$permi52->name,$permi53->name,$permi54->name,$permi55->name,$permi56->name,$permi57->name,$permi58->name,$permi59->name,$permi60->name,
            $permi61->name,$permi62->name,$permi63->name,$permi64->name,$permi65->name,$permi66->name,$permi67->name,$permi68->name,$permi69->name,$permi70->name,
            $permi71->name,$permi72->name,$permi73->name
        ]);
    }
}
