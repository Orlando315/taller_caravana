<?php

namespace App\Policies;

use App\User;
use App\VehiculosModelo;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiculoModeloPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
      return $user->isStaff();
    }

    /**
     * Determine whether the user can view the vehiculos modelo.
     *
     * @param  \App\User  $user
     * @param  \App\VehiculosModelo  $vehiculosModelo
     * @return mixed
     */
    public function view(User $user, VehiculosModelo $vehiculosModelo)
    {
        
      return $user->isStaff();
    }

    /**
     * Determine whether the user can create vehiculos modelos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the vehiculos modelo.
     *
     * @param  \App\User  $user
     * @param  \App\VehiculosModelo  $vehiculosModelo
     * @return mixed
     */
    public function update(User $user, VehiculosModelo $vehiculosModelo)
    {
        
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the vehiculos modelo.
     *
     * @param  \App\User  $user
     * @param  \App\VehiculosModelo  $vehiculosModelo
     * @return mixed
     */
    public function delete(User $user, VehiculosModelo $vehiculosModelo)
    {
        
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the vehiculos modelo.
     *
     * @param  \App\User  $user
     * @param  \App\VehiculosModelo  $vehiculosModelo
     * @return mixed
     */
    public function restore(User $user, VehiculosModelo $vehiculosModelo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the vehiculos modelo.
     *
     * @param  \App\User  $user
     * @param  \App\VehiculosModelo  $vehiculosModelo
     * @return mixed
     */
    public function forceDelete(User $user, VehiculosModelo $vehiculosModelo)
    {
        //
    }
}
