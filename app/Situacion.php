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
      // static::addGlobalScope(new TallerScope);
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
     * Obtener los Items por tipo
     * 
     * @param \String  $type
     */
    public function getItemsByType($type = 'horas')
    {
      return $this->items()->where('type', $type);
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

    /**
     * Obtener la Utilidad de los Items
     * 
     * @param \Boolean  $onlyNumbers
     * @return  mixed
     */
    public function utilidad($onlyNumbers = true)
    {
      $total = $this->items->sum('utilidad');
      return $onlyNumbers ? $total : number_format($total, 2, ',', '.');
    }

    /**
     * Sumar el valor de la columna dada de los Items
     *
     * @param \String   $column
     * @param \Boolean  $onlyNumbers
     * @param \Integer  $decimals
     * @param  mixed  $type  false | string
     * @return  mixed
     */
    public function sumValue($column, $onlyNumbers = false, $decimals = 2, $type = false)
    {
      $total = $this->items
                    ->when($type, function ($query, $type){
                      return $query->where('type', $type);
                    })
                    ->sum($column);

      return $onlyNumbers ? $total : number_format($total, $decimals, ',', '.');
    }

    /**
     * Modificar el stock de los items especificados
     *
     * @param  array  $items
     * @param  bool  $increment
     */
    public static function updateStock($items, $increment = false)
    {
      $function = $increment ? 'increment' : 'decrement';

      if(count($items['repuesto']) > 0){
        foreach ($items['repuesto'] as $repuesto) {
          Repuesto::where('id', $repuesto['id'])
                  ->$function('stock', $repuesto['cantidad']);
        }
      }

      if(count($items['insumo']) > 0){
        foreach($items['insumo'] as $dataInsumo){
          $cantidad = $dataInsumo['cantidad'];
          $insumo = Insumo::find($dataInsumo['id']);
          $stockEnUso = $insumo->stockEnUso;

          if($function == 'decrement' && $stockEnUso->stock < $cantidad){
            foreach($insumo->stocks as $stock){
              $aRestar = ($stock->stock < $cantidad) ? $stock->stock : $cantidad;
              $cantidad -= $aRestar;
              $stock->decrement('stock', $aRestar);

              if($cantidad <= 0){
                break;
              }
            }
          }else{
            $stockEnUso->$function('stock', $cantidad);
          }
        }
      }
    }
}
