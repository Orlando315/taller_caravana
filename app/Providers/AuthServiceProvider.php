<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\{UserPolicy, InsumoTipoPolicy, InsumoFormatoPolicy, InsumoPolicy, ConfigurationPolicy, PreevaluacionPolicy};
use App\{User, InsumoTipo, InsumoFormato, Insumo, Configuration, Preevaluacion};

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
        Preevaluacion::class => PreevaluacionPolicy::class,
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
