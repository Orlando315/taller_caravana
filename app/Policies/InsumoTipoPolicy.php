<?php

namespace App\Policies;

use App\User;
use App\InsumoTipo;
use Illuminate\Auth\Access\HandlesAuthorization;

class InsumoTipoPolicy
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
      return $user->role != 'user';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\InsumoTipo  $model
     * @return mixed
     */
    public function view(User $user, InsumoTipo $model)
    {
      return $user->role != 'user';
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->role != 'user';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\InsumoTipo  $model
     * @return mixed
     */
    public function update(User $user, InsumoTipo $model)
    {
      return $user->role != 'user';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\InsumoTipo  $model
     * @return mixed
     */
    public function delete(User $user, InsumoTipo $model)
    {
      return $user->isAdmin();
    }
}
