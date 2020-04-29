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
     * Verificar si el Repuesto es de ua procedencia especifica
     */
    public function isNacional()
    {
      return $this->procedencia == 'nacional';
    }

    /**
     * Verificar si el Repuesto es de ua procedencia especifica
     */
    public function isInternacional()
    {
      return $this->procedencia == 'internacional';
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
     */
    public function envio()
    {
      return $this->envio ? number_format($this->envio, 2, ',', '.') : null;
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

    /**
     * Obtener el atributo formateado
     */
    public function motor()
    {
      $motor = $this->motor > 0 ? ($this->motor / 1000) : 0;
      return number_format($motor, 1, '.', ',');
    }

    /**
     * Calcular los impuestos del Repuesto (Solo Internacional)
     */
    public function calculateCostoTotal()
    {
      if($this->isInternacional()){
        $this->calculateImpuestosTotal();
        $this->calculateGeneralesTotal();
      }

      $total = $this->extra->costo;

      if($this->isInternacional()){
        $total += $this->extra->envio1 + $this->extra->envio2 + $this->extra->casilla + $this->extra->impuestos_total + $this->extra->generales_total + $this->extra->tramitacion;
      }else{
        // A los repuestos nacionales se les suma el envio
        $total += $this->extra->generales + ($this->isNacional() ? $this->envio : 0);
      }

      $this->extra->costo_total = $total;
    }

    /**
     * Calcular los impuestos del Repuesto (Solo Internacional)
     */
    protected function calculateImpuestosTotal()
    {
      $costoBase = $this->extra->costo + $this->extra->envio1 + $this->extra->envio2;
      $total = ($costoBase * $this->extra->impuestos) / 100;
      $this->extra->impuestos_total = $total;
    }

    /**
     * Calcular los gastos Generales del Repuesto (Solo Internacional)
     */
    protected function calculateGeneralesTotal()
    {
      $costoGeneral = $this->extra->costo + $this->extra->envio1 + $this->extra->envio2 + $this->extra->casilla + $this->extra->impuestos_total;
      $total = ($costoGeneral * $this->extra->generales) / 100;
      $this->extra->generales_total = $total;
    }
}
