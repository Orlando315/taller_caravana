<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TallerScope;

class Pago extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pagos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'taller',
      'proceso_id',
      'pago'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
      parent::boot();
    }

    /**
     * Obtener el atributo formateado
     *
     * @param  float  $value
     * @return float
     */
    public function getPagoAttribute($value)
    {
      return round($value, 2);
    }

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
    public function pago()
    {
      return number_format($this->pago, 2, ',', '.');
    }
}
