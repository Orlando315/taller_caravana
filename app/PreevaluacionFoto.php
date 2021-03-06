<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TallerScope;

class PreevaluacionFoto extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'preevaluaciones_fotos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'taller',
      'proceso_id',
      'foto',
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
    }

    /**
     * Obtener el Proceso
     */
    public function proceso()
    {
      return $this->belongsTo('App\Proceso');
    }
}
