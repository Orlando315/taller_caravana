<?php

namespace App\Policies;

use App\User;
use App\Proceso;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProcesoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the index.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
      return $user->isStaff();
    }

    /**
     * Determine whether the user can view the proceso.
     *
     * @param  \App\User  $user
     * @param  \App\Proceso  $proceso
     * @return mixed
     */
    public function view(User $user, Proceso $proceso)
    {
      if($user->isCliente()){
        return $user->cliente->id == $proceso->cliente_id;
      }

      return $user->isStaff();
    }

    /**
     * Determine whether the user can create procesos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the proceso.
     *
     * @param  \App\User  $user
     * @param  \App\Proceso  $proceso
     * @return mixed
     */
    public function update(User $user, Proceso $proceso)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the proceso.
     *
     * @param  \App\User  $user
     * @param  \App\Proceso  $proceso
     * @return mixed
     */
    public function delete(User $user, Proceso $proceso)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the proceso.
     *
     * @param  \App\User  $user
     * @param  \App\Proceso  $proceso
     * @return mixed
     */
    public function restore(User $user, Proceso $proceso)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the proceso.
     *
     * @param  \App\User  $user
     * @param  \App\Proceso  $proceso
     * @return mixed
     */
    public function forceDelete(User $user, Proceso $proceso)
    {
        //
    }
}
