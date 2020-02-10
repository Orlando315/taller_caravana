<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TallerScope;

class InspeccionFoto extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inspecciones_fotos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'taller',
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
      static::addGlobalScope(new TallerScope);
    }

    /**
     * Obtener la Inspeccion
     */
    public function inspeccion()
    {
      return $this->belongsTo('App\Inspeccion');
    }
}
