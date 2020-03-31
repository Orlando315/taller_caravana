<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\UserScope;

class Configuration extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'configurations';

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
      'dollar'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
      parent::boot();
      // static::addGlobalScope(new UserScope);
    }

    /**
     * User al que pertenece la Configuration
     */
    public function user(){
      return $this->belongsTo('App\User');
    }

    /**
     * Darle formato al campo venta
     */
    public function dollar()
    {
      return number_format($this->dollar, 2, '.', ',');
    }
}
