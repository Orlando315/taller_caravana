<?php

namespace App;

use Illuminate\Database\Eloquent\Model, Builder;
use App\Scopes\TallerScope;

class Situacion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'situaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'taller',
      'proceso_id',
      'status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'status' => 'boolean',
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
     * Obtener el Proceso
     */
    public function proceso()
    {
      return $this->belongsTo('App\Proceso');
    }

    /**
     * Obtener los Items
     */
    public function items()
    {
      return $this->hasMany('App\SituacionItem');
    }

    /**
     * Obtener las Cotizaciones
     */
    public function cotizaciones()
    {
      return $this->hasMany('App\Cotizacion');
    }

    /**
     * Obtener el Total de los Items
     * 
     * @param \Boolean  $onlyNumbers
     * @return  mixed
     */
    public function total($onlyNumbers = true)
    {
      $total = $this->items->sum('total');
      return $onlyNumbers ? $total : number_format($total, 2, ',', '.');
    }
}
