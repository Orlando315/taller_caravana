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
     */
    public function costo()
    {
      return $this->costo ? number_format($this->costo, 2, ',', '.') : null;
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
     */
    public function envio1()
    {
      return $this->envio1 ? number_format($this->envio1, 2, ',', '.') : null;
    }

    /**
     * Obtener el atributo formateado
     */
    public function envio2()
    {
      return $this->envio2 ? number_format($this->envio2, 2, ',', '.') : null;
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
     */
    public function impuestos()
    {
      if($this->impuestos == 0){
        return $this->impuestos_total ? number_format($this->impuestos_total, 2, ',', '.') : null;
      }

      $costoBase = $this->costo + $this->envio1 + $this->envio2;
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
