<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\{Model, Builder};

class Proceso extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'procesos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'cliente_id',
      'vehiculo_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'status' => 'boolean',
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
     * Obtener el Cliente
     */
    public function cliente()
    {
      return $this->belongsTo('App\Cliente');
    }

    /**
     * Obtener el Vehiculo
     */
    public function vehiculo()
    {
      return $this->belongsTo('App\Vehiculo');
    }

    /**
     * Obtener el Agendamiento
     */
    public function agendamiento()
    {
      return $this->hasOne('App\Agendamiento');
    }
}
