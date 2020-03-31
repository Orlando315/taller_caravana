<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\UserScope;

class InsumoFormato extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'insumos_formatos';

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
      'formato'
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
     * Los Insumos que pertenecen a InsumoFormato.
     */
    public function insumos()
    {
      return $this->hasMany('App\Insumo', 'formato_id', 'id');
    }
}
