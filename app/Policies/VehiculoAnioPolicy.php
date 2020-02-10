<?php

namespace App\Policies;

use App\User;
use App\VehiculosAnio;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiculoAnioPolicy
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
     * Determine whether the user can view the vehiculos anio.
     *
     * @param  \App\User  $user
     * @param  \App\VehiculosAnio  $vehiculosAnio
     * @return mixed
     */
    public function view(User $user, VehiculosAnio $vehiculosAnio)
    {
      return $user->isStaff();
    }

    /**
     * Determine whether the user can create vehiculos anios.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the vehiculos anio.
     *
     * @param  \App\User  $user
     * @param  \App\VehiculosAnio  $vehiculosAnio
     * @return mixed
     */
    public function update(User $user, VehiculosAnio $vehiculosAnio)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the vehiculos anio.
     *
     * @param  \App\User  $user
     * @param  \App\VehiculosAnio  $vehiculosAnio
     * @return mixed
     */
    public function delete(User $user, VehiculosAnio $vehiculosAnio)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the vehiculos anio.
     *
     * @param  \App\User  $user
     * @param  \App\VehiculosAnio  $vehiculosAnio
     * @return mixed
     */
    public function restore(User $user, VehiculosAnio $vehiculosAnio)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the vehiculos anio.
     *
     * @param  \App\User  $user
     * @param  \App\VehiculosAnio  $vehiculosAnio
     * @return mixed
     */
    public function forceDelete(User $user, VehiculosAnio $vehiculosAnio)
    {
        //
    }
}
