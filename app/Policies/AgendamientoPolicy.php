<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\{Agendamiento, User, Proceso};

class AgendamientoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the agendamiento.
     *
     * @param  \App\User  $user
     * @param  \App\Agendamiento  $agendamiento
     * @return mixed
     */
    public function index(User $user)
    {
      return $user->isStaff();
    }

    /**
     * Determine whether the user can view the agendamiento.
     *
     * @param  \App\User  $user
     * @param  \App\Agendamiento  $agendamiento
     * @return mixed
     */
    public function view(User $user, Agendamiento $agendamiento)
    {
        //
    }

    /**
     * Determine whether the user can create agendamientos.
     *
     * @param  \App\User  $user
     * @param  \App\Proceso  $proceso
     * @return mixed
     */
    public function create(User $user, Proceso $proceso)
    {
      return $user->isAdmin() && !$proceso->status && !$proceso->agendamiento && $proceso->etapa == 1;
    }

    /**
     * Determine whether the user can update the agendamiento.
     *
     * @param  \App\User  $user
     * @param  \App\Agendamiento  $agendamiento
     * @return mixed
     */
    public function update(User $user, Agendamiento $agendamiento)
    {
      return $user->isAdmin() && !$agendamiento->proceso->status;
    }

    /**
     * Determine whether the user can delete the agendamiento.
     *
     * @param  \App\User  $user
     * @param  \App\Agendamiento  $agendamiento
     * @return mixed
     */
    public function delete(User $user, Agendamiento $agendamiento)
    {
      return false;
    }

    /**
     * Determine whether the user can restore the agendamiento.
     *
     * @param  \App\User  $user
     * @param  \App\Agendamiento  $agendamiento
     * @return mixed
     */
    public function restore(User $user, Agendamiento $agendamiento)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the agendamiento.
     *
     * @param  \App\User  $user
     * @param  \App\Agendamiento  $agendamiento
     * @return mixed
     */
    public function forceDelete(User $user, Agendamiento $agendamiento)
    {
        //
    }
}
