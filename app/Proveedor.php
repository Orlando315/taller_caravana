<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TallerScope;

class Proveedor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'proveedores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'taller',
      'tienda',
      'vendedor',
      'direccion',
      'telefono_local',
      'telefono_celular',
      'email',
      'descuento_convenio'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'status' => 'boolean',
    ];

    /**
     * Obtener los Vehiculos del Proveedor
     */
    public function vehiculos()
    {
      return $this->hasMany('App\ProveedorVehiculo','proveedor_id');
    }

    /**
     * Obtener las Marcas del Proveedor
     */
    public function marcas()
    {
      return $this->belongsToMany('App\VehiculosMarca','proveedores_vehiculos', 'proveedor_id', 'vehiculo_marca_id')->withTimestamps();
    }

    /**
     * Relacion con Insumos
     */
    public function Insumos()
    {
      return $this->belongsToMany('App\Insumo', 'stocks')->groupBy('insumo_id');
    }

    /**
     * Obtener el atributo formateado
     */
    public function descuento()
    {
      return number_format($this->descuento_convenio, 2, ',', '.');
    }
}
