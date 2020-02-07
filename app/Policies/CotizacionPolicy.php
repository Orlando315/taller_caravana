<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\{Cotizacion, User, Situacion};

class CotizacionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the cotizacion.
     *
     * @param  \App\User  $user
     * @param  \App\Cotizacion  $cotizacion
     * @return mixed
     */
    public function view(User $user, Cotizacion $cotizacion)
    {
        //
    }

    /**
     * Determine whether the user can create cotizacions.
     *
     * @param  \App\User  $user
     * @param  \App\Situacion  $situacion
     * @return mixed
     */
    public function create(User $user, Situacion $situacion)
    {
      return !$situacion->proceso->status && ($situacion->proceso->etapa == 4 || $situacion->proceso->etapa == 5);
    }

    /**
     * Determine whether the user can update the cotizacion.
     *
     * @param  \App\User  $user
     * @param  \App\Cotizacion  $cotizacion
     * @return mixed
     */
    public function update(User $user, Cotizacion $cotizacion)
    {
      return !$situacion->proceso->status && ($situacion->proceso->etapa == 4 || $situacion->proceso->etapa == 5);
    }

    /**
     * Determine whether the user can delete the cotizacion.
     *
     * @param  \App\User  $user
     * @param  \App\Cotizacion  $cotizacion
     * @return mixed
     */
    public function delete(User $user, Cotizacion $cotizacion)
    {
      return !$situacion->proceso->status && ($situacion->proceso->etapa == 4 || $situacion->proceso->etapa == 5);
    }

    /**
     * Determine whether the user can restore the cotizacion.
     *
     * @param  \App\User  $user
     * @param  \App\Cotizacion  $cotizacion
     * @return mixed
     */
    public function restore(User $user, Cotizacion $cotizacion)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the cotizacion.
     *
     * @param  \App\User  $user
     * @param  \App\Cotizacion  $cotizacion
     * @return mixed
     */
    public function forceDelete(User $user, Cotizacion $cotizacion)
    {
        //
    }
}
