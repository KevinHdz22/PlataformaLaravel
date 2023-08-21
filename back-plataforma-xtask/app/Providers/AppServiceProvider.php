<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ServiciosInterface\ServicioUsuarioI;
use App\Services\ServiciosImplementacion\ServicioUsuario;
use App\Services\ServiciosInterface\ServicioLoginI;
use App\Services\ServiciosImplementacion\ServicioLogin;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        #$this->app->bind(\App\Services\ServiciosInterface\ServicioUsuarioI::class, App\Services\ServiciosImplementacion\ServicioUsuario::class);

        $this->app->bind(ServicioUsuarioI::class, ServicioUsuario::class);
        $this->app->bind(ServicioLoginI::class, ServicioLogin::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
