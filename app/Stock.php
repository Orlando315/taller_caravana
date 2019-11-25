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
      'stock',
      'minimo'
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
     * Stock del Insumo
     */
    public function insumo()
    {
      return $this->belongsTo('App\Insumo');
    }
}
