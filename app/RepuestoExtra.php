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
      'generales',
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
     *
     * @param  bool  $convert
     */
    public function impuestos($convert = false)
    {
      return $this->impuestos ? number_format($this->impuestos, 2, ',', '.') : null;
    }

    /**
     * Obtener el atributo formateado
     */
    public function generales()
    {
      return $this->generales ? number_format($this->generales, 2, ',', '.') : null;
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
