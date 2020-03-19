<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CotizacionImprevisto extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cotizaciones_imprevistos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'tipo',
      'descripcion',
      'monto',
    ];

    /**
     * Obtener la Cotizacion
     */
    public function cotizacion()
    {
      return $this->belongsTo('App\Cotizacion');
    }

    /**
     * Obtener el atributo formateado
     */
    public function tipo()
    {
      switch ($this->tipo) {
        case 'horas':
          $tipo = 'HH';
          break;
        case 'repuesto':
          $tipo = 'Repuestos';
          break;
        case 'isumo':
          $tipo = 'Insumos';
          break;
        case 'terceros':
          $tipo = 'Servicios de terceros';
          break;
        default:
          $tipo = 'Otros';
          break;
      }

      return $tipo;
    }

    /**
     * Obtener el atributo formateado
     */
    public function monto()
    {
      return number_format($this->monto, 2, ',', '.');
    }
}
