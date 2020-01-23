<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class Vehiculo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehiculos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'cliente_id',
      'vehiculo_marca_id',
      'vehiculo_modelo_id',
      'vehiculo_anio_id',
      'patentes',
      'color',
      'km',
      'vin'
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
     * Obtener fecha formateada
     */
    public function createdAt()
    {
      return $this->created_at->format('d-m-Y');
    }

    /**
     * Obtener los cliente
     */
    public function cliente()
    {
      return $this->belongsTo('App\Cliente');
    }

    /**
     * Obtener los marca
     */
    public function marca()
    {
      return $this->belongsTo('App\VehiculosMarca', 'vehiculo_marca_id');
    }

    /**
     * Obtener los modelo
     */
    public function modelo()
    {
      return $this->belongsTo('App\VehiculosModelo', 'vehiculo_modelo_id');
    }

    /**
     * Obtener los anio
     */
    public function anio()
    {
      return $this->belongsTo('App\VehiculosAnio', 'vehiculo_anio_id');
    }

    /**
     * Obtener los Km formateados
     */
    public function km()
    {
      return number_format($this->km, 2, ',', '.');
    }
}
