<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Stock extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stocks';

    /**
     * Llave primaria de la tabla asociada al modelo.
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'proveedor_id',
      'coste',
      'venta',
      'stock',
      'factura',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'coste' => 'float',
      'venta' => 'float',
      'stock' => 'integer',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
      parent::boot();

      static::addGlobalScope('insumo', function (Builder $builder) {
        $builder->has('insumo')->with('insumo');
      });
    }

    /**
     * Obtener el Insumo
     */
    public function insumo()
    {
      return $this->belongsTo('App\Insumo');
    }

    /**
     * Obtener el proveedor
     */
    public function proveedor()
    {
      return $this->belongsTo('App\Proveedor');
    }

    /**
     * Obtener el atributo formateado
     */
    public function coste()
    {
      return number_format($this->coste, 2, ',', '.');
    }

    /**
     * Obtener el atributo formateado
     */
    public function venta()
    {
      return number_format($this->venta, 2, ',', '.');
    }

    /**
     * Obtener el atributo formateado
     */
    public function stock()
    {
      return number_format($this->stock, 0, ',', '.');
    }

    /**
     * Obtener la url de la foto de la factura
     */
    public function getPhotoFactura()
    {
      return asset($this->foto_factura ? 'storage/'.$this->foto_factura : 'images/default.jpg');
    }
}
