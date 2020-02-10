<?php

namespace App\Policies;

use App\User;
use App\Proveedor;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProveedorPolicy
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
     * Determine whether the user can view the proveedor.
     *
     * @param  \App\User  $user
     * @param  \App\Proveedor  $proveedor
     * @return mixed
     */
    public function view(User $user, Proveedor $proveedor)
    {
      return $user->isStaff();
    }

    /**
     * Determine whether the user can create proveedors.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the proveedor.
     *
     * @param  \App\User  $user
     * @param  \App\Proveedor  $proveedor
     * @return mixed
     */
    public function update(User $user, Proveedor $proveedor)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the proveedor.
     *
     * @param  \App\User  $user
     * @param  \App\Proveedor  $proveedor
     * @return mixed
     */
    public function delete(User $user, Proveedor $proveedor)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the proveedor.
     *
     * @param  \App\User  $user
     * @param  \App\Proveedor  $proveedor
     * @return mixed
     */
    public function restore(User $user, Proveedor $proveedor)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the proveedor.
     *
     * @param  \App\User  $user
     * @param  \App\Proveedor  $proveedor
     * @return mixed
     */
    public function forceDelete(User $user, Proveedor $proveedor)
    {
        //
    }
}
