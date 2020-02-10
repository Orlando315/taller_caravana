<?php

namespace App\Policies;

use App\User;
use App\VehiculosMarca;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiculoMarcaPolicy
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
     * Determine whether the user can view the vehiculos marca.
     *
     * @param  \App\User  $user
     * @param  \App\VehiculosMarca  $vehiculosMarca
     * @return mixed
     */
    public function view(User $user, VehiculosMarca $vehiculosMarca)
    {
      return $user->isStaff();
    }

    /**
     * Determine whether the user can create vehiculos marcas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the vehiculos marca.
     *
     * @param  \App\User  $user
     * @param  \App\VehiculosMarca  $vehiculosMarca
     * @return mixed
     */
    public function update(User $user, VehiculosMarca $vehiculosMarca)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the vehiculos marca.
     *
     * @param  \App\User  $user
     * @param  \App\VehiculosMarca  $vehiculosMarca
     * @return mixed
     */
    public function delete(User $user, VehiculosMarca $vehiculosMarca)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the vehiculos marca.
     *
     * @param  \App\User  $user
     * @param  \App\VehiculosMarca  $vehiculosMarca
     * @return mixed
     */
    public function restore(User $user, VehiculosMarca $vehiculosMarca)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the vehiculos marca.
     *
     * @param  \App\User  $user
     * @param  \App\VehiculosMarca  $vehiculosMarca
     * @return mixed
     */
    public function forceDelete(User $user, VehiculosMarca $vehiculosMarca)
    {
        //
    }
}
