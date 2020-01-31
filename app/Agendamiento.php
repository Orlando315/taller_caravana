<?php

namespace App;

use Illuminate\Database\Eloquent\{Model, Builder};
use Illuminate\Support\Facades\Auth;

class Agendamiento extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agendamientos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'taller',
      'vehiculo_id',
      'inmediatamente',
      'fecha',
      'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'status' => 'boolean',
      'inmediatamente' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
      'fecha',
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
     * Obtener el Vehiculo al que pertenece
     */
    public function vehiculo()
    {
      return $this->belongsTo('App\Vehiculo');
    }
}
