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
      'minimo'
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
     * Relacion con Proveedores
     */
    public function proveedores()
    {
      return $this->belongsToMany('App\Proveedor', 'stocks')->groupBy('proveedor_id');
    }

    /**
     * Obtener la url de la foto solicitada
     *
     * @param   string $type
     */
    public function getPhoto($type)
    {
      return asset($this->{$type} ? 'storage/'.$this->{$type} : 'images/default.jpg');
    }

    /**
     * Stock del Insumo
     */
    public function stocks()
    {
      return $this->hasMany('App\Stock');
    }

    /**
     * Stock del Insumo
     */
    public function hasLowStockAlert()
    {
      return $this->minimo !== null;
    }

    /**
     * Stock del Insumo
     */
    public function isLowStock()
    {
      return $this->minimo >= $this->getStock();
    }

    /**
     * Stock del Insumo
     *
     * @param  \Bool $foramt  Define si devolver el Stock formateado o no
     */
    public function getStock($format = false)
    {
      return $format ? number_format($this->stocks()->sum('stock'), 0, ',', '.') : $this->stocks()->sum('stock');
    }

    /**
     * Obtener el stock en uso actual
     */
    public function stockEnUso()
    {
      return $this->hasOne('App\Stock')->where('stock', '>', 0);
    }

    /**
     * Obtener la decsripcion
     */
    public function descripcion()
    {
      return $this->nombre.' ('.$this->formato->formato.')';
    }
}
