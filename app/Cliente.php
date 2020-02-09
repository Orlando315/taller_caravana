<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'user_id', 'nombres', 'apellidos', 'email', 'rut', 'direccion', 'telefono', 'status'
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
     * Obtener el nombre completo del Cliente.
     */
    public function nombre()
    {
      return $this->user->nombres.' '.$this->user->apellidos;
    }

    /**
     * Obtener los vehiculos
     */
    public function vehiculos()
    {
      return $this->hasMany('App\Vehiculo');
    }

    /**
     * Obtener los Procesos
     */
    public function procesos()
    {
      return $this->hasMany('App\Proceso');
    }
}
