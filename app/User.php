<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use App\Notifications\Invites;
use Illuminate\Support\Facades\Auth;
use App\Seccion;
use App\Archivo;

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
      'nombres', 'apellidos', 'email', 'password', 'status'
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
     * Obtener el nombre del Role del User
     */
    public function role()
    {
      return $this->role == 'admin' ? 'Administrador' : ($this->role == 'jefe' ? 'Jefe de taller' : 'Usuario');
    }

    /**
     * Obtener los nombres y apellidos del User
     */
    public function nombre()
    {
      return $this->nobmres.' '.$this->apellidos;
    }

    /**
     * Relacion con Users
     */
    public function users()
    {
      return $this->hasMany('App\User');
    }

    /**
     * Relacion con Users
     */
    public function jefes()
    {
      return $this->users()->where('role', 'jefe');
    }

    /**
     * Relacion con Users
     */
    public function usuarios()
    {
      return $this->users()->where('role', 'user');
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
}
