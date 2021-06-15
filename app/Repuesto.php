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
      'stock',
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
      'comentarios',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
      parent::boot();
      // static::addGlobalScope(new TallerScope);
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
      return $this->hasOne('App\RepuestoExtra');
    }

    /**
     * Verificar si el Repuesto es de ua procedencia especifica
     */
    public function isLocal()
    {
      return $this->procedencia == 'internacional';
    }

    /**
     * Verificar si el Repuesto es de una procedencia especifica
     */
    public function isNacional()
    {
      return $this->procedencia == 'nacional';
    }

    /**
     * Verificar si el Repuesto es de una procedencia especifica
     */
    public function isInternacional()
    {
      return $this->procedencia == 'internacional';
    }

    /**
     * Verificar si el Repuesto es en pesos
     */
    public function isPesos()
    {
      return $this->extra->moneda == 'pesos';
    }

    /**
     * Verificar si el Repuesto no esta en pesos
     */
    public function isNotPesos()
    {
      return !$this->isPesos();
    }

    /**
     * Evaluar si la hoja de situacion tiene comentarios
     * 
     * @return bool
     */
    public function hasComentarios()
    {
      return !is_null($this->comentarios);
    }

    /**
     * Obtener la url de la foto
     */
    public function getPhoto()
    {
      return asset($this->foto ? 'storage/'.$this->foto : 'images/default.jpg');
    }

    /**
     * Obtener el atributo formateado
     */
    public function anio()
    {
      return $this->anio;
    }

    /**
     * Obtener el atributo formateado
     */
    public function venta()
    {
      return $this->venta ? number_format($this->venta, 2, ',', '.') : null;
    }

    /**
     * Obtener el atributo formateado
     *
     * @param  bool $convert
     */
    public function envio($convert = false)
    {
      $value = $convert ? ($this->envio * ($this->extra->moneda_valor ?? 1)) : $this->envio;

      return $this->envio ? number_format($value, 2, ',', '.') : null;
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
      return $this->componente.' - '.$this->sistema.' - '.$this->modelo->modelo;
    }

    /**
     * Obtener el atributo formateado
     */
    public function motor()
    {
      $motor = $this->motor > 0 ? ($this->motor / 1000) : 0;
      return number_format($motor, 1, '.', ',');
    }
}
