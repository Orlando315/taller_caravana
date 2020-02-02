<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\{Model, Builder};

class Proceso extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'procesos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'cliente_id',
      'vehiculo_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'status' => 'boolean',
      'etapa' => 'integer',
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
     * Obtener el Cliente
     */
    public function cliente()
    {
      return $this->belongsTo('App\Cliente');
    }

    /**
     * Obtener el Vehiculo
     */
    public function vehiculo()
    {
      return $this->belongsTo('App\Vehiculo');
    }

    /**
     * Obtener el Agendamiento
     */
    public function agendamiento()
    {
      return $this->hasOne('App\Agendamiento');
    }

    /**
     * Obtener las Preevaluaciones
     */
    public function preevaluaciones()
    {
      return $this->hasMany('App\Preevaluacion');
    }

    /**
     * Evaluar si hay Preevaluaciones
     * 
     * @return  Boolean
     */
    public function hasPreevaluaciones()
    {
      return $this->preevaluaciones->count() > 0;
    }

    /**
     * Verificar si hay Preevaluaciones y mostrarlo como badge
     */
    public function preevaluacionesStatus()
    {
      return $this->hasPreevaluaciones() ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-secondary">No</span>';
    }

    /**
     * Obtener las Fotos de las Preevaluaciones
     */
    public function preevaluacionFotos()
    {
      return $this->hasMany('App\PreevaluacionFoto');
    }

    /**
     * Obtener las Fotos como assets
     */
    public function preevaluacionFotosAsAssets()
    {
      return $this->preevaluacionFotos()
                  ->get()
                  ->pluck('foto')
                  ->map(function ($foto, $key){
                    return asset('storage/'.$foto);
                  });
    }

    /**
     * Evaluar si hay PreevaluacionFoto
     * 
     * @return  Boolean
     */
    public function hasPreevaluacionFotos()
    {
      return $this->preevaluacionFotos->count() > 0;
    }
}
