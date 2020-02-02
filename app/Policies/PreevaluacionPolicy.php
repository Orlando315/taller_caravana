<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\{User, Proceso, Preevaluacion};

class PreevaluacionPolicy
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

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Preevaluacion  $model
     * @return mixed
     */
    public function view(User $user, Preevaluacion $model)
    {

    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @param  \App\Proceso  $proceso
     * @return mixed
     */
    public function create(User $user, Proceso $proceso)
    {
      return $proceso->etapa == 2 && !$proceso->hasPreevaluaciones() && !$proceso->hasPreevaluacionFotos();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Proceso  $proceso
     * @return mixed
     */
    public function update(User $user, Proceso $proceso)
    {
      return ($proceso->hasPreevaluaciones() || $proceso->preevaluaciones->count() <= 12);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Preevaluacion  $model
     * @return mixed
     */
    public function delete(User $user, Preevaluacion $model)
    {

    }
}
