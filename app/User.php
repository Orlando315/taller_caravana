<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use App\Configuration;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'user_id', 'nombres', 'apellidos', 'email', 'password', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'password', 'remember_token',
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

      static::addGlobalScope('active', function(Builder $query){
        $query->where('status', true);
      });
    }

    /**
     * Enviar correo para recuperar password
     */
    public function sendPasswordResetNotification($token)
    {
      $this->notify(new ResetPassword($token));
    }

    /**
     * Verificar si el User tiene el Role solicitado
     */
    public function checkRole($role)
    {
      return $this->role == $role;
    }

    /**
     * Verificar si el User tiene Role admin
     */
    public function isAdmin()
    {
      return $this->role == 'admin';
    }

    /**
     * Verificar si el User tiene Role Jefe
     */
    public function isJefe()
    {
      return $this->role == 'jefe';
    }

    /**
     * Verificar si el User tiene Role Jefe o Admin
     */
    public function isStaff()
    {
      return $this->isAdmin() || $this->isJefe();
    }

    /**
     * Verificar si el User tiene es un Cliente
     */
    public function isCliente()
    {
      return $this->role == 'user' && $this->cliente;
    }

    /**
     * Obtener el nombre del Role del User
     */
    public function role()
    {
      return $this->role == 'admin' ? 'Administrador' : ($this->role == 'jefe' ? 'Jefe de taller' : 'Cliente');
    }

    /**
     * Obtener los nombres y apellidos del User
     */
    public function nombre()
    {
      return $this->nombres.' '.$this->apellidos;
    }

    /**
     * Relacion con Users
     */
    public function users()
    {
      return $this->hasMany('App\User')->where('role', '!=', 'user');
    }

    /**
     * Obtener solo los Jefes
     */
    public function jefes()
    {
      return $this->users()->where('role', 'jefe');
    }

    /**
     * Obtener el nombre del Role del User
     */
    public function taller(){
      return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * InsumoTipo que pertecenen al User
     */
    public function tipos()
    {
      return $this->hasMany('App\InsumoTipo');
    }

    /**
     * InsumoFormato que pertecenen al User
     */
    public function formatos()
    {
      return $this->hasMany('App\InsumoFormato');
    }

    /**
     * Configuration que pertecenen al User
     */
    public function configuration()
    {
      return $this->hasOne('App\Configuration');
    }

    /**
     * Optener valor del campo Dollar
     */
    public function getDollar()
    {
      return optional(Configuration::first())->dollar() ?? '-';
    }

    /**
     * Obtener los Clientes
     */
    public function clientes()
    {
      return $this->hasMany('App\Cliente', 'taller');
    }

    /**
     * Obtener el Cliente del User (role = user)
     */
    public function cliente()
    {
      return $this->hasOne('App\Cliente');
    }

    /**
     * Obtener las marcas
     */
    public function marcas()
    {
      return $this->hasMany('App\VehiculosMarca', 'taller');
    }

    /**
     * Obtener los anios
     */
    public function anios()
    {
      return $this->hasMany('App\VehiculosAnio', 'taller');
    }

    /**
     * Obtener los modelos
     */
    public function modelos()
    {
      return $this->hasMany('App\VehiculosModelo', 'taller');
    }

    /**
     * Obtener los vehiculos
     */
    public function vehiculos()
    {
      return $this->hasMany('App\Vehiculo', 'taller');
    }

    /**
     * Obtener los Agendamientos
     */
    public function agendamientos()
    {
      return $this->hasMany('App\Agendamiento', 'taller');
    }

    /**
     * Obtener los Proveedores
     */
    public function proveedores()
    {
      return $this->hasMany('App\Proveedor', 'taller');
    }

    /**
     * Obtener los Procesos
     */
    public function procesos()
    {
      return $this->hasMany('App\Proceso', 'taller');
    }

    /**
     * Obtener los Repuestos
     */
    public function repuestos()
    {
      return $this->hasMany('App\Repuesto', 'taller');
    }
}
