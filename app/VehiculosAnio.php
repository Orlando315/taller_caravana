<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TallerScope;

class VehiculosAnio extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehiculos_anios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'anio'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
      parent::boot();
      static::addGlobalScope(new TallerScope);
    }

    /**
     * Obtener fecha formateada
     */
    public function createdAt()
    {
      return $this->created_at->format('d-m-Y');
    }

    /**
     * Obtener el atributo formateada
     */
    public function anio()
    {
      return number_format($this->anio, 0, ',', '.');
    }

    /**
     * Obtener los vehiculos
     */
    public function vehiculos()
    {
      return $this->hasMany('App\Vehiculo', 'vehiculo_anio_id');
    }
}
