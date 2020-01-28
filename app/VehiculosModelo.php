<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class VehiculosModelo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehiculos_modelos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'vehiculo_marca_id', 'modelo'
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
     * Obtener los marca
     */
    public function marca()
    {
      return $this->belongsTo('App\VehiculosMarca', 'vehiculo_marca_id');
    }

    /**
     * Obtener los vehiculos
     */
    public function vehiculos()
    {
      return $this->hasMany('App\Vehiculo', 'vehiculo_modelo_id');
    }
}