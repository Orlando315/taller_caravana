<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\{Scope, Model, Builder};
use Illuminate\Support\Facades\Auth;

class TallerScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
      $builder->where('taller', Auth::user()->user_id ?? Auth::user()->id);
    }
}
