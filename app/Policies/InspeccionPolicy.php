<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\{Inspeccion, User, Proceso};

class InspeccionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the inspeccion.
     *
     * @param  \App\User  $user
     * @param  \App\Inspeccion  $inspeccion
     * @return mixed
     */
    public function view(User $user, Inspeccion $inspeccion)
    {
        //
    }

    /**
     * Determine whether the user can create inspeccions.
     *
     * @param  \App\User  $user
     * @param  \App\Proceso  $proceso
     * @return mixed
     */
    public function create(User $user, Proceso $proceso)
    {
      return $user->isAdmin() && !$proceso->status && !$proceso->inspeccion;
    }

    /**
     * Determine whether the user can update the inspeccion.
     *
     * @param  \App\User  $user
     * @param  \App\Inspeccion  $inspeccion
     * @return mixed
     */
    public function update(User $user, Inspeccion $inspeccion)
    {
      return $user->isAdmin() && !$inspeccion->proceso->status;
    }

    /**
     * Determine whether the user can delete the inspeccion.
     *
     * @param  \App\User  $user
     * @param  \App\Inspeccion  $inspeccion
     * @return mixed
     */
    public function delete(User $user, Inspeccion $inspeccion)
    {
        //
    }

    /**
     * Determine whether the user can update the inspeccion.
     *
     * @param  \App\User  $user
     * @param  \App\Inspeccion  $inspeccion
     * @return mixed
     */
    public function delete_photo(User $user, Inspeccion $inspeccion)
    {
      return $user->isAdmin() && !$inspeccion->proceso->status;
    }

    /**
     * Determine whether the user can restore the inspeccion.
     *
     * @param  \App\User  $user
     * @param  \App\Inspeccion  $inspeccion
     * @return mixed
     */
    public function status(User $user, Inspeccion $inspeccion)
    {
      return $user->isCliente() && $user->cliente->id == $inspeccion->proceso->cliente_id;
    }

    /**
     * Determine whether the user can permanently delete the inspeccion.
     *
     * @param  \App\User  $user
     * @param  \App\Inspeccion  $inspeccion
     * @return mixed
     */
    public function pdf(User $user, Inspeccion $inspeccion)
    {
      return $user->isCliente() && $user->cliente->id == $inspeccion->proceso->cliente_id;
    }
}
