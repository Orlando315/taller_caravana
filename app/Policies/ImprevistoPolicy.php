<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\{User, CotizacionImprevisto, Cotizacion};

class ImprevistoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the cotizacion imprevisto.
     *
     * @param  \App\User  $user
     * @param  \App\CotizacionImprevisto  $imprevisto
     * @return mixed
     */
    public function view(User $user, CotizacionImprevisto $imprevisto)
    {
        //
    }

    /**
     * Determine whether the user can create cotizacion imprevistos.
     *
     * @param  \App\User  $user
     * @param  \App\Cotizacion  $Cotizacion
     * @return mixed
     */
    public function create(User $user, Cotizacion $cotizacion)
    {
      return $user->isAdmin() && !$cotizacion->situacion->proceso->status;
    }

    /**
     * Determine whether the user can update the cotizacion imprevisto.
     *
     * @param  \App\User  $user
     * @param  \App\CotizacionImprevisto  $imprevisto
     * @return mixed
     */
    public function update(User $user, CotizacionImprevisto $imprevisto)
    {
      return $user->isAdmin() && !$imprevisto->cotizacion->situacion->proceso->status;
    }

    /**
     * Determine whether the user can delete the cotizacion imprevisto.
     *
     * @param  \App\User  $user
     * @param  \App\CotizacionImprevisto  $imprevisto
     * @return mixed
     */
    public function delete(User $user, CotizacionImprevisto $imprevisto)
    {
      return $user->isAdmin() && !$imprevisto->cotizacion->situacion->proceso->status;
    }
}
