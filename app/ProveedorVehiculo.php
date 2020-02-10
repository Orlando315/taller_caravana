<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TallerScope;

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
      static::addGlobalScope(new TallerScope);
    }

    /**
     * Obtener el Proveedor
     */
    public function proveedor()
    {
      return $this->belongsTo('App\Proveedor');
    }

    /**
     * Obtener la marca
     */
    public function marca()
    {
      return $this->belongsTo('App\VehiculosMarca', 'vehiculo_marca_id');
    }

    /**
     * Obtener el modelo
     */
    public function modelo()
    {
      return $this->belongsTo('App\VehiculosModelo', 'vehiculo_modelo_id');
    }


    /**
     * Obtener el Anio
     */
    public function anio()
    {
      return $this->belongsTo('App\VehiculosAnio', 'vehiculo_anio_id');
    }
}
