<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepuestoExtra extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'repuestos_extras';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'costo',
      'costo_total',
      'envio1',
      'envio2',
      'casilla',
      'impuestos',
      'impuestos_total',
      'generales',
      'generales_total',
      'tramitacion',
      'moneda',
      'moneda_valor',
    ];

    /**
     * Repuesto al que pertenece
     */
    public function repuesto()
    {
      return $this->belongsTo('App\Repuesto');
    }

    /**
     * Obtener el atributo formateado
     * 
     * @param  bool  $convert
     */
    public function costo($convert = false)
    {
      $value = $convert ? ($this->costo * ($this->moneda_valor ?? 1)) : $this->costo;

      return $this->costo ? number_format($value, 2, ',', '.') : null;
    }

    /**
     * Obtener el atributo formateado
     */
    public function costoTotal()
    {
      return $this->costo_total ? number_format($this->costo_total, 2, ',', '.') : null;
    }

    /**
     * Obtener el atributo formateado
     *
     * @param  bool  $convert
     */
    public function envio1($convert = false)
    {
      $value = $convert ? ($this->envio1 * ($this->moneda_valor ?? 1)) : $this->envio1;

      return $this->envio1 ? number_format($value, 2, ',', '.') : null;
    }

    /**
     * Obtener el atributo formateado
     *
     * @param  bool  $convert
     */
    public function envio2($convert = false)
    {
      $value = $convert ? ($this->envio2 * ($this->moneda_valor ?? 1)) : $this->envio2;

      return $this->envio2 ? number_format($value, 2, ',', '.') : null;
    }

    /**
     * Obtener el atributo formateado
     */
    public function casilla()
    {
      return $this->casilla ? number_format($this->casilla, 2, ',', '.') : null;
    }

    /**
     * Obtener el atributo formateado
     */
    public function impuestosTipo()
    {
      if($this->impuestos > 0){
        return ' ('.$this->impuestos.'% del FOB)';
      }

      return '';
    }

    /**
     * Obtener el atributo formateado
     *
     * @param  bool  $convert
     */
    public function impuestos($convert = false)
    {
      if($this->impuestos == 0){
        return $this->impuestos_total ? number_format($this->impuestos_total, 2, ',', '.') : null;
      }

      $convertValue = $this->repuesto->isPesos() ? 1 : ($this->moneda_valor ?? 1);
      $costoBase = ($this->costo + $this->envio1 + $this->envio2) * $convertValue;
      $fob = ($costoBase * $this->impuestos) / 100;
      return $this->impuestos ? number_format($fob, 2, ',', '.') : null;
    }

    /**
     * Obtener el atributo formateado
     */
    public function generales()
    {
      // Si es internacional, no se le agregan los decimales
      $decimales = $this->repuesto->isInternacional() ? 0 : 2;
      return $this->generales ? number_format($this->generales, $decimales, ',', '.') : null;
    }

    /**
     * Obtener el atributo formateado
     */
    public function generalesTotal()
    {
      return $this->generales_total ? number_format($this->generales_total, 2, ',', '.') : null;
    }

    /**
     * Obtener el atributo formateado
     */
    public function tramitacion()
    {
      return $this->tramitacion ? number_format($this->tramitacion, 2, ',', '.') : null;
    }

    /**
     * Obtener el atributo formateado
     */
    public function moneda()
    {
      return ucfirst($this->moneda);
    }

    /**
     * Obtener el atributo formateado
     */
    public function monedaValor()
    {
      return $this->moneda_valor ? number_format($this->moneda_valor, 2, ',', '.') : null;
    }
}
