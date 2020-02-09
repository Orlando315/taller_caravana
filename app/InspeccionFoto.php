<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\{Model, Builder};

class InspeccionFoto extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inspecciones_fotos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'taller',
      'foto',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
      parent::boot();

      if(Auth::check()){
        static::addGlobalScope('taller', function (Builder $query) {
          $query->where('taller', Auth::user()->id);
        });
      }
    }

    /**
     * Obtener la Inspeccion
     */
    public function inspeccion()
    {
      return $this->belongsTo('App\Inspeccion');
    }
}
