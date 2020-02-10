<?php

namespace App\Policies;

use App\User;
use App\Vehiculo;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiculoPolicy
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
     * Determine whether the user can view the vehiculo.
     *
     * @param  \App\User  $user
     * @param  \App\Vehiculo  $vehiculo
     * @return mixed
     */
    public function view(User $user, Vehiculo $vehiculo)
    {
      if($user->isCliente()){
        return $user->cliente->id == $vehiculo->cliente_id;
      }

      return $user->isStaff();
    }

    /**
     * Determine whether the user can create vehiculos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {        
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the vehiculo.
     *
     * @param  \App\User  $user
     * @param  \App\Vehiculo  $vehiculo
     * @return mixed
     */
    public function update(User $user, Vehiculo $vehiculo)
    {
      if($user->isCliente()){
        return $user->cliente->id == $vehiculo->cliente_id;
      }
         
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the vehiculo.
     *
     * @param  \App\User  $user
     * @param  \App\Vehiculo  $vehiculo
     * @return mixed
     */
    public function delete(User $user, Vehiculo $vehiculo)
    {
      if($user->isCliente()){
        return $user->cliente->id == $vehiculo->cliente_id;
      }
        
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the vehiculo.
     *
     * @param  \App\User  $user
     * @param  \App\Vehiculo  $vehiculo
     * @return mixed
     */
    public function restore(User $user, Vehiculo $vehiculo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the vehiculo.
     *
     * @param  \App\User  $user
     * @param  \App\Vehiculo  $vehiculo
     * @return mixed
     */
    public function forceDelete(User $user, Vehiculo $vehiculo)
    {
        //
    }
}
