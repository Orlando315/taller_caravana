<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cotizaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'user_id',
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
     * Obtener el User
     */
    public function user()
    {
      return $this->belongsTo('App\User');
    }

    /**
     * Obtener el Situacion
     */
    public function situacion()
    {
      return $this->belongsTo('App\Situacion');
    }

    /**
     * Obtener los Items
     */
    public function items()
    {
      return $this->hasMany('App\CotizacionItem');
    }

    /**
     * Obtener los Items
     */
    public function situacionItems()
    {
      return $this->belongsToMany('App\SituacionItem', 'cotizaciones_items', 'cotizacion_id', 'item_id');
    }

    /**
     * Obtener el Total del costo de los Items
     */
    public function total($onlyNumbers = false)
    {
      $total = $this->situacionItems->sum('total');

      return $onlyNumbers ? $total : number_format($total, 2, ',', '.');
    }

    /**
     * Obtener el Total Pagado
     */
    public function pagado()
    {
      return 0;
    }

    /**
     * Obtener el Total Pagado
     *
     * @param \String   $column
     * @param \Boolean  $onlyNumbers
     * @param \Integer  $decimals
     * @return  mixed
     */
    public function sumValue($column, $onlyNumbers = false, $decimals = 2)
    {
      $total = $this->situacionItems->sum($column);

      return $onlyNumbers ? $total : number_format($total, $decimals, ',', '.');
    }
}
