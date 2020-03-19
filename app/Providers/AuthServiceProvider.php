<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\{UserPolicy, InsumoTipoPolicy, InsumoFormatoPolicy, InsumoPolicy, ConfigurationPolicy, PreevaluacionPolicy, PagoPolicy, AgendamientoPolicy, SituacionPolicy, CotizacionPolicy, InspeccionPolicy};
use App\Policies\{ProveedorPolicy, RepuestoPolicy, VehiculoPolicy, VehiculoAnioPolicy, VehiculoMarcaPolicy, VehiculoModeloPolicy, ClientePolicy, ProcesoPolicy, ImprevistoPolicy};
use App\{User, InsumoTipo, InsumoFormato, Insumo, Configuration, Preevaluacion, Pago, Agendamiento, Situacion, Cotizacion, Inspeccion, Proveedor, Repuesto};
use App\{Vehiculo, VehiculosAnio, VehiculosMarca, VehiculosModelo, Cliente, Proceso, CotizacionImprevisto};

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
        Pago::class => PagoPolicy::class,
        Agendamiento::class => AgendamientoPolicy::class,
        Situacion::class => SituacionPolicy::class,
        Cotizacion::class => CotizacionPolicy::class,
        Inspeccion::class => InspeccionPolicy::class,
        Proveedor::class => ProveedorPolicy::class,
        Repuesto::class => RepuestoPolicy::class,
        Vehiculo::class => VehiculoPolicy::class,
        VehiculosAnio::class =>  VehiculoAnioPolicy::class,
        VehiculosMarca::class => VehiculoMarcaPolicy::class,
        VehiculosModelo::class => VehiculoModeloPolicy::class,
        Cliente::class => ClientePolicy::class,
        Proceso::class => ProcesoPolicy::class,
        CotizacionImprevisto::class => ImprevistoPolicy::class,
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
