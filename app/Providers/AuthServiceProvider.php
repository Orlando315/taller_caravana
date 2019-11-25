<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\UserPolicy;
use App\User;
use App\Policies\InsumoTipoPolicy;
use App\InsumoTipo;
use App\Policies\InsumoFormatoPolicy;
use App\InsumoFormato;
use App\Policies\InsumoPolicy;
use App\Insumo;
use App\Policies\ConfigurationPolicy;
use App\Configuration;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        InsumoTipo::class => InsumoTipoPolicy::class,
        InsumoFormato::class => InsumoFormatoPolicy::class,
        Insumo::class => InsumoPolicy::class,
        Configuration::class => ConfigurationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
