<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TallerScope;

class Preevaluacion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'preevaluaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'taller',
      'proceso_id',
      'descripcion',
      'observacion',
      'referencia',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'referencia' => 'float',
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
     * Obtener el Proceso
     */
    public function proceso()
    {
      return $this->belongsTo('App\Proceso');
    }

    /**
     * Obtener el atributo formateado
     */
    public function referencia()
    {
      return $this->referencia ? number_format($this->referencia, 2, ',', '.') : null;
    }
}
