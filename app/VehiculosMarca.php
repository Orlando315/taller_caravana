<?php

namespace App;

use Illuminate\Database\Eloquent\{Model, Builder};
use App\Scopes\TallerScope;

class VehiculosMarca extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehiculos_marcas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'marca'
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
      static::addGlobalScope(function (Builder $query ){
        $query->orderBy('marca', 'asc');
      });
    }

    /**
     * Obtener fecha formateada
     */
    public function createdAt()
    {
      return $this->created_at->format('d-m-Y');
    }

    /**
     * Obtener los modelos
     */
    public function modelos()
    {
      return $this->hasMany('App\VehiculosModelo', 'vehiculo_marca_id');
    }

    /**
     * Obtener los vehiculos
     */
    public function vehiculos()
    {
      return $this->hasMany('App\Vehiculo', 'vehiculo_marca_id');
    }


    /**
     * Obtener las Marcas que tiene Modelos, como un array
     *
     * @return array
     */
    public static function marcasToArray()
    {
      return self::select('id', 'marca')
                ->has('modelos')
                ->get()
                ->mapWithKeys(function($item){
                  return [$item['id'] => $item['marca']];
                })
                ->toArray();
    }
}
