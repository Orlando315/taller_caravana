<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TallerScope;

class Agendamiento extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agendamientos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'taller',
      'proceso_id',
      'inmediatamente',
      'fecha',
      'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'status' => 'boolean',
      'inmediatamente' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
      'fecha',
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
     * Obtener el Vehiculo
     */
    public function vehiculo()
    {
      return $this->proceso->vehiculo();
    }

    /**
     * Obtener el Proceso al que pertenece
     */
    public function proceso()
    {
      return $this->belongsTo('App\Proceso');
    }

    /**
     * Obtener la fecha formateada
     */
    public function fecha()
    {
      return $this->fecha->format('d-m-Y H:i:s');
    }
}
