<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Trabajador;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('sistema.usuario.inicio', function ($view) {
            $usuarios = User::select('id','nombre','usuario','email','deleted_at',
                            DB::Raw("case
                                        when estado = 0 then 'Inactivo'
                                        when estado = 1 then 'Activo'
                                    end as estado_nombre"),
                            DB::Raw("case
                                    when estado = 0 then 'badge bage-secondary'
                                    when estado = 1 then 'badge badge-success'
                                end as estado_clase")
                            )
                        ->paginate(5);

            $view->with('usuarios', $usuarios);

        });

        view()->composer('principal',function($view){
           $trabajadores_count = Trabajador::where('estado',1)->count();
           $view->with('trabajadores_count',$trabajadores_count);
        });
    }
}
