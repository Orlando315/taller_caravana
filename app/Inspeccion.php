<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TallerScope;

class Inspeccion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inspecciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'taller',
      'combustible',
      'observacion',
      'radio',
      'antena',
      'pisos_delanteros',
      'pisos_traseros',
      'cinturones',
      'tapiz',
      'triangulos',
      'extintor',
      'botiquin',
      'gata',
      'herramientas',
      'neumatico_repuesto',
      'luces_altas',
      'luces_bajas',
      'intermitentes',
      'encendedor',
      'limpia_parabrisas_delantero',
      'limpia_parabrisas_trasero',
      'tapa_combustible',
      'seguro_ruedas',
      'perilla_interior',
      'perilla_exterior',
      'manuales',
      'documentacion',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'radio' => 'boolean',
      'antena' => 'boolean',
      'pisos_delanteros' => 'boolean',
      'pisos_traseros' => 'boolean',
      'cinturones' => 'boolean',
      'tapiz' => 'boolean',
      'triangulos' => 'boolean',
      'extintor' => 'boolean',
      'botiquin' => 'boolean',
      'gata' => 'boolean',
      'herramientas' => 'boolean',
      'neumatico_repuesto' => 'boolean',
      'luces_altas' => 'boolean',
      'luces_bajas' => 'boolean',
      'intermitentes' => 'boolean',
      'encendedor' => 'boolean',
      'limpia_parabrisas_delantero' => 'boolean',
      'limpia_parabrisas_trasero' => 'boolean',
      'tapa_combustible' => 'boolean',
      'seguro_ruedas' => 'boolean',
      'perilla_interior' => 'boolean',
      'perilla_exterior' => 'boolean',
      'manuales' => 'boolean',
      'documentacion' => 'boolean',
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
     * Obtener el Proceso
     */
    public function fotos()
    {
      return $this->hasMany('App\InspeccionFoto');
    }

    /**
     * Obtener el atributo formateado como badge
     *
     * @param   \String  $attribute
     * @return  \String
     */
    public function badge($attribute)
    {
      return $this->{$attribute} ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-secondary">No</span>';
    }

    /**
     * Obtener el atributo formatead
     */
    public function combustible()
    {
      return number_format($this->combustible, 1, ',', '.');
    }

    /**
     * Obtener las Fotos como assets
     */
    public function fotosAsAssets()
    {
      return $this->fotos()
                  ->get()
                  ->pluck('foto')
                  ->map(function ($foto, $key){
                    return asset('storage/'.$foto);
                  });
    }
}
