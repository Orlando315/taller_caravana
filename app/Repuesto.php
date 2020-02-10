<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TallerScope;

class Repuesto extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'repuestos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'taller',
      'vehiculo_marca_id',
      'vehiculo_modelo_id',
      'nro_parte',
      'nro_oem',
      'marca_oem',
      'anio',
      'motor',
      'sistema',
      'componente',
      'foto',
      'procedencia',
      'venta',
      'envio',
      'aduana',
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
     * Obtener los Extras
     */
    public function extra()
    {
      return $this->hasOne('App\repuestoExtra');
    }

    /**
     * Obtener la url de la foto
     */
    public function getPhoto()
    {
      return asset('storage/'.$this->foto);
    }

    /**
     * Obtener el atributo formateado
     */
    public function anio()
    {
      return number_format($this->anio, 0, ',', '.');
    }

    /**
     * Obtener el atributo formateado
     */
    public function venta()
    {
      return number_format($this->venta, 2, ',', '.');
    }

    /**
     * Obtener el atributo formateado
     */
    public function envio()
    {
      return number_format($this->envio, 2, ',', '.');
    }

    /**
     * Obtener el atributo formateado
     */
    public function aduana()
    {
      return number_format($this->aduana, 2, ',', '.');
    }

    /**
     * Obtener la Marca, el Modelo y Anio
     */
    public function marcaModeloAnio()
    {
      return $this->marca->marca.' - '.$this->modelo->modelo.' ('.$this->anio().')';
    }

    /**
     * Obtener el atributo formateado
     */
    public function procedencia()
    {
      return ucfirst($this->procedencia);
    }

    /**
     * Obtener la descripcion
     */
    public function descripcion()
    {
      return $this->nro_oem.' | '.$this->marcaModeloAnio();
    }
}
