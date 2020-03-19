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
      'descripcion',
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
     * Obtener los Imprevistos
     */
    public function imprevistos()
    {
      return $this->hasMany('App\CotizacionImprevisto');
    }

    /**
     * Obtener los Items por tipo
     * 
     * @param \String  $type
     */
    public function getItemsByType($type = 'horas')
    {
      return $this->situacionItems()->where('type', $type);
    }

    /**
     * Obtener el Total Neto del costo de los Items
     */
    public function neto($onlyNumbers = false)
    {
      $total = $this->situacionItems->sum('total');

      return $onlyNumbers ? $total : number_format($total, 2, ',', '.');
    }

    /**
     * Calcular el Iva de la Cotizacion
     */
    public function iva($onlyNumbers = false)
    {
      $neto = $this->neto(true);
      $iva = ($neto * 19) / 100;

      return $onlyNumbers ? $iva : number_format($iva, 2, ',', '.');
    }

    /**
     * Obtener el Total del costo de los Items + IVA
     */
    public function total($onlyNumbers = false)
    {
      $total = $this->neto(true) + $this->iva(true);

      return $onlyNumbers ? $total : number_format($total, 2, ',', '.');
    }

    /**
     * Obtener el Total de los Imprevisstos
     */
    public function totalImprevistos($onlyNumbers = false)
    {
      $total = $this->imprevistos()->sum('monto');

      return $onlyNumbers ? $total : number_format($total, 2, ',', '.');
    }

    /**
     * Obtener el Total Pagado
     * 
     * @param \Boolean  $onlyNumbers
     * @return  mixed
     */
    public function pagado($onlyNumbers = true)
    {
      $total = $this->pagos->sum('pago');

      return $onlyNumbers ? $total : number_format($total, 2, ',', '.');
    }

    /**
     * Obtener el total de la Utilidad
     * 
     * @param \Boolean  $onlyNumbers
     * @return  mixed
     */
    public function utilidad($onlyNumbers = true)
    {
      $total = $this->sumValue('utilidad', true) - $this->totalImprevistos(true);

      return $onlyNumbers ? $total : number_format($total, 2, ',', '.');
    }

    /**
     * Obtener la descripcion limitada a 100 caracteres
     */
    public function descripcionShort()
    {
      return str_limit($this->descripcion, 100, '...');
    }

    /**
     * Obtener la descripcion limitada a 100 caracteres
     */
    public function codigo()
    {
      return 'COD-'.str_pad($this->id, 8, '0', STR_PAD_LEFT);
    }

    /**
     * Sumar el valor de la columna dada
     *
     * @param \String   $column
     * @param \Boolean  $onlyNumbers
     * @param \Integer  $decimals
     * @param  mixed  $type  false | string
     * @return  mixed
     */
    public function sumValue($column, $onlyNumbers = false, $decimals = 2, $type = false)
    {
      $total = $this->situacionItems
                    ->when($type, function ($query, $type){
                      return $query->where('type', $type);
                    })
                    ->sum($column);

      return $onlyNumbers ? $total : number_format($total, $decimals, ',', '.');
    }

    /**
     * Obtener los Pagos
     */
    public function pagos()
    {
      return $this->hasMany('App\Pago');
    }

    /**
     * Obtener el Total pendiente por pagar
     * 
     * @param \Boolean  $onlyNumbers
     * @return  mixed
     */
    public function porPagar($onlyNumbers = true)
    {
      $pagado = $this->pagado();
      $total = ($this->total(true) - $pagado);

      return $onlyNumbers ? $total : number_format($total, 2, ',', '.');
    }

    /**
     * Evaluar si hay Pagos
     * 
     * @return  Boolean
     */
    public function hasPagos()
    {
      return $this->pagos->count() > 0;
    }

    /**
     * Badge status
     */
    public function status()
    {
      return $this->status ? '<span class="badge badge-success">Pago</span>' : '<span class="badge badge-secondary">Pendiente</span>';
    }
}
