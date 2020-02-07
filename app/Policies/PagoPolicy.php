<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\{User, Pago, Cotizacion};

class PagoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the pago.
     *
     * @param  \App\User  $user
     * @param  \App\Pago  $pago
     * @return mixed
     */
    public function view(User $user, Pago $pago)
    {
        //
    }

    /**
     * Determine whether the user can create pagos.
     *
     * @param  \App\User  $user
     * @param  \App\Cotizacion  $cotizacion
     * @return mixed
     */
    public function create(User $user, Cotizacion $cotizacion)
    {
      return !$cotizacion->status;
    }

    /**
     * Determine whether the user can update the pago.
     *
     * @param  \App\User  $user
     * @param  \App\Pago  $pago
     * @return mixed
     */
    public function update(User $user, Pago $pago)
    {
        //
    }

    /**
     * Determine whether the user can delete the pago.
     *
     * @param  \App\User  $user
     * @param  \App\Pago  $pago
     * @return mixed
     */
    public function delete(User $user, Pago $pago)
    {
        //
    }

    /**
     * Determine whether the user can restore the pago.
     *
     * @param  \App\User  $user
     * @param  \App\Pago  $pago
     * @return mixed
     */
    public function restore(User $user, Pago $pago)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the pago.
     *
     * @param  \App\User  $user
     * @param  \App\Pago  $pago
     * @return mixed
     */
    public function forceDelete(User $user, Pago $pago)
    {
      return !$cotizacion->status;
    }
}
