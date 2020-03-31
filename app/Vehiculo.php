<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TallerScope;

class Vehiculo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehiculos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'cliente_id',
      'vehiculo_marca_id',
      'vehiculo_modelo_id',
      'vehiculo_anio_id',
      'patentes',
      'color',
      'km',
      'vin',
      'motor',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'km' => 'decimal:2',
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
     * Obtener fecha formateada
     */
    public function createdAt()
    {
      return $this->created_at->format('d-m-Y');
    }

    /**
     * Obtener el cliente
     */
    public function cliente()
    {
      return $this->belongsTo('App\Cliente');
    }

    /**
     * Obtener los Procesos
     */
    public function procesos()
    {
      return $this->hasMany('App\Proceso');
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
     * Obtener los anio
     */
    public function anio()
    {
      return $this->belongsTo('App\VehiculosAnio', 'vehiculo_anio_id');
    }

    /**
     * Obtener los Km formateados
     */
    public function km()
    {
      return number_format($this->km, 2, ',', '.');
    }

    /**
     * Obtener todos los datos basicos del Vehiculo
     */
    public function vehiculo()
    {
      return $this->marca->marca.' - '.$this->modelo->modelo.' ('.$this->anio->anio.')';
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
