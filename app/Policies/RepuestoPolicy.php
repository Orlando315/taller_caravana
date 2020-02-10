<?php

namespace App\Policies;

use App\User;
use App\Repuesto;
use Illuminate\Auth\Access\HandlesAuthorization;

class RepuestoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the repuesto.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
      return $user->isStaff();
    }

    /**
     * Determine whether the user can view the repuesto.
     *
     * @param  \App\User  $user
     * @param  \App\Repuesto  $repuesto
     * @return mixed
     */
    public function view(User $user, Repuesto $repuesto)
    {
      return $user->isStaff();
    }

    /**
     * Determine whether the user can create repuestos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the repuesto.
     *
     * @param  \App\User  $user
     * @param  \App\Repuesto  $repuesto
     * @return mixed
     */
    public function update(User $user, Repuesto $repuesto)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the repuesto.
     *
     * @param  \App\User  $user
     * @param  \App\Repuesto  $repuesto
     * @return mixed
     */
    public function delete(User $user, Repuesto $repuesto)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the repuesto.
     *
     * @param  \App\User  $user
     * @param  \App\Repuesto  $repuesto
     * @return mixed
     */
    public function restore(User $user, Repuesto $repuesto)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the repuesto.
     *
     * @param  \App\User  $user
     * @param  \App\Repuesto  $repuesto
     * @return mixed
     */
    public function forceDelete(User $user, Repuesto $repuesto)
    {
        //
    }
}
