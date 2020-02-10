<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TallerScope;

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
      static::addGlobalScope(new TallerScope);
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
      return $this->statusBadge($this->hasPreevaluaciones());
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

    /**
     * Obtener la Situzacion Principal
     * 
     * @return  Boolean
     */
    public function situacion()
    {
      return $this->hasOne('App\Situacion');
    }

    /**
     * Verificar si hay Preevaluaciones y mostrarlo como badge
     */
    public function situacionStatus()
    {
      return $this->statusBadge($this->situacion);
    }

    /**
     * Obtener las Cotizaciones
     * 
     * @return  Boolean
     */
    public function cotizaciones()
    {
      return $this->hasManyThrough('App\Cotizacion', 'App\Situacion');
    }

    /**
     * Evaluar si hay Preevaluaciones
     * 
     * @return  Boolean
     */
    public function hasCotizaciones()
    {
      return $this->cotizaciones->count() > 0;
    }

    /**
     * Verificar si hay Cotizaciones y mostrarlo como badge
     */
    public function cotizacionesStatus()
    {
      return $this->statusBadge($this->hasCotizaciones());
    }

    /**
     * Badge status
     */
    public function statusBadge($status)
    {
      return $status ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-secondary">No</span>';
    }

    /**
     * Obtener el Status como bagde
     */
    public function status()
    {
      return $this->status ? '<span class="badge badge-success">Completado</span>' : '<span class="badge badge-secondary">Pendiente</span>';
    }

    /**
     * Obtener el Total de la Situacion
     * 
     * @param \Boolean  $onlyNumbers
     * @return  mixed
     */
    public function total($onlyNumbers = true)
    {
      return $this->situacion->total($onlyNumbers);
    }

    /**
     * Obtener los Pagos
     * 
     */
    public function pagos()
    {
      return $this->hasMany('App\Pago');
    }

    /**
     * Evaluar si hay Preevaluaciones
     * 
     * @return  Boolean
     */
    public function hasPagos()
    {
      return $this->pagos->count() > 0;
    }

    /**
     * Obtener el Total Pagado
     * 
     * @param \Boolean  $onlyNumbers
     * @return  mixed
     */
    public function pagado($onlyNumbers = true)
    {
      $total = $this->pagos->sum('pago');

      return $onlyNumbers ? $total : number_format($total, 2, ',', '.');
    }

    /**
     * Obtener la Inspeccion
     * 
     */
    public function Inspeccion()
    {
      return $this->hasOne('App\Inspeccion');
    }

    /**
     * Verificar si hay Inspecion y mostrarlo como badge
     */
    public function inspeccionStatus()
    {
      return $this->statusBadge($this->inspeccion);
    }
}
