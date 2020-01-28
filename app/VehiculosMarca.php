<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

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

      if(Auth::check()){
        static::addGlobalScope('taller', function (Builder $query) {
          $query->where('taller', Auth::user()->id);
        });
      }
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
}