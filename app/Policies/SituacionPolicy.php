<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\{Situacion, User, Proceso};

class SituacionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the situacion.
     *
     * @param  \App\User  $user
     * @param  \App\Situacion  $situacion
     * @return mixed
     */
    public function view(User $user, Situacion $situacion)
    {
        //
    }

    /**
     * Determine whether the user can create situacions.
     *
     * @param  \App\User  $user
     * @param  \App\Proceso  $proceso
     * @return mixed
     */
    public function create(User $user, Proceso $proceso)
    {
      return $proceso->etapa == 3 && !$proceso->status && !$proceso->situacion;
    }

    /**
     * Determine whether the user can update the situacion.
     *
     * @param  \App\User  $user
     * @param  \App\Situacion  $situacion
     * @return mixed
     */
    public function update(User $user, Situacion $situacion)
    {
      return $situacion->proceso->etapa > 3 && !$situacion->proceso->status && $situacion->proceso->situacion;
    }

    /**
     * Determine whether the user can delete the situacion.
     *
     * @param  \App\User  $user
     * @param  \App\Situacion  $situacion
     * @return mixed
     */
    public function delete_item(User $user, Situacion $situacion)
    {
      return $situacion->proceso->etapa > 3 && !$situacion->proceso->status && $situacion->proceso->situacion;
    }

    /**
     * Determine whether the user can restore the situacion.
     *
     * @param  \App\User  $user
     * @param  \App\Situacion  $situacion
     * @return mixed
     */
    public function restore(User $user, Situacion $situacion)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the situacion.
     *
     * @param  \App\User  $user
     * @param  \App\Situacion  $situacion
     * @return mixed
     */
    public function forceDelete(User $user, Situacion $situacion)
    {
        //
    }
}
