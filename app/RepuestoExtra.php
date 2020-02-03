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
      'envio1',
      'envio2',
      'casilla',
      'impuestos',
      'generales',
      'tramitacion',
      'moneda',
    ];

    /**
     * Obtener el atributo formateado
     */
    public function costo()
    {
      return number_format($this->costo, 2, ',', '.');
    }

    /**
     * Obtener el atributo formateado
     */
    public function envio1()
    {
      return number_format($this->envio1, 2, ',', '.');
    }

    /**
     * Obtener el atributo formateado
     */
    public function envio2()
    {
      return number_format($this->envio2, 2, ',', '.');
    }

    /**
     * Obtener el atributo formateado
     */
    public function casilla()
    {
      return number_format($this->casilla, 2, ',', '.');
    }

    /**
     * Obtener el atributo formateado
     */
    public function impuestos()
    {
      return number_format($this->impuestos, 2, ',', '.');
    }

    /**
     * Obtener el atributo formateado
     */
    public function generales()
    {
      return number_format($this->generales, 2, ',', '.');
    }

    /**
     * Obtener el atributo formateado
     */
    public function tramitacion()
    {
      return number_format($this->tramitacion, 2, ',', '.');
    }

    /**
     * Obtener el atributo formateado
     */
    public function moneda()
    {
      return number_format($this->moneda, 2, ',', '.');
    }
}
