<?php

namespace App\Policies;

use App\User;
use App\Configuration;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConfigurationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the insumo.
     *
     * @param  \App\Insumo  $insumo
     * @return mixed
     */
    public function update(User $user)
    {
      return $user->isAdmin();
    }
}
