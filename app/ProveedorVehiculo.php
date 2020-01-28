<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ProveedorVehiculo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'proveedores_vehiculos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'taller',
      'proveedor_id',
      'vehiculo_marca_id',
      'vehiculo_modelo_id',
      'vehiculo_anio_id',
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

    public function marca()
    {
      return $this->belongsTo('App\VehiculosMarca','vehiculo_marca_id');
    }

    public function modelo()
    {
      return $this->belongsTo('App\VehiculosModelo','vehiculo_modelo_id');
    }

    public function anio_vehiculo()
    {
      return $this->belongsTo('App\VehiculosAnio','vehiculo_anio_id');
    }
}
