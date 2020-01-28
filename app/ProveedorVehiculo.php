<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
