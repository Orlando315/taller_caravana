<?php

namespace App\Policies;

use App\User;
use App\Insumo;
use Illuminate\Auth\Access\HandlesAuthorization;

class InsumoPolicy
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
      return true;
    }

    /**
     * Determine whether the user can view the insumo.
     *
     * @param  \App\User  $user
     * @param  \App\Insumo  $insumo
     * @return mixed
     */
    public function view(User $user, Insumo $insumo)
    {
      return true;
    }

    /**
     * Determine whether the user can create insumos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->role != 'user';
    }

    /**
     * Determine whether the user can update the insumo.
     *
     * @param  \App\User  $user
     * @param  \App\Insumo  $insumo
     * @return mixed
     */
    public function update(User $user, Insumo $insumo)
    {
      return $user->role != 'user';
    }

    /**
     * Determine whether the user can delete the insumo.
     *
     * @param  \App\User  $user
     * @param  \App\Insumo  $insumo
     * @return mixed
     */
    public function delete(User $user, Insumo $insumo)
    {
      return $user->role != 'user';
    }
}
