<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\UserScope;

class Insumo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'insumos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'nombre',
      'marca',
      'tipo_id',
      'grado',
      'formato_id',
      'descripcion', 
      'factura',
      'coste',
      'venta',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'numero_factura' => 'integer',
      'valor_coste' => 'float',
      'valor_venta' => 'float',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
      parent::boot();

      static::addGlobalScope(new UserScope);
    }

    /**
     * InsumoTipo al que pertenece el Insumo.
     */
    public function tipo()
    {
      return $this->belongsTo('App\InsumoTipo');
    }

    /**
     * InsumoFormato al que pertenece el Insumo
     */
    public function formato()
    {
      return $this->belongsTo('App\InsumoFormato');
    }

    /**
     * Obtener la url de la foto
     */
    public function getPhoto($foto)
    {
      return asset('storage/'.$foto);
    }

    /**
     * Darle formato al campo costo
     */
    public function costo()
    {
      return number_format($this->coste, 0, ',', '.');
    }

    /**
     * Darle formato al campo venta
     */
    public function venta()
    {
      return number_format($this->venta, 0, ',', '.');
    }

    /**
     * Stock del Insumo
     */
    public function stock()
    {
      return $this->hasOne('App\Stock');
    }
}
