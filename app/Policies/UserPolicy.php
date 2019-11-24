<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function index(User $user)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
      return ($user->isAdmin() && $user->is($model)) || ($user->isAdmin() && $user->id == $model->user_id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can store models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can edit the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function edit(User $user, User $model)
    {
      return ($user->isAdmin() && $user->is($model)) || ($user->isAdmin() && $user->id == $model->user_id);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
      return ($user->isAdmin() && $user->is($model)) || ($user->isAdmin() && $user->id == $model->user_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
      return ($user->isAdmin() && $user->is($model)) || ($user->isAdmin() && $user->id == $model->user_id);
    }

    /**
     * Determine whether the user can change de password of the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function password(User $user, User $model)
    {
      return ($user->isAdmin() && $user->is($model)) || ($user->isAdmin() && $user->id == $model->user_id);
    }
}
