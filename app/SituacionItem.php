<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SituacionItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'situaciones_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'insumo_id',
      'repuesto_id',
      'type',
      'descripcion',
      'valor_venta',
      'cantidad',
      'total',
      'costo',
      'utilidad',
      'descuento_type',
      'descuento',
      'total_descuento',
      'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'descuento_type' => 'boolean',
      'status' => 'boolean',
    ];

    /**
     * Obtener el Proceso
     */
    public function situacion()
    {
      return $this->belongsTo('App\Situacion');
    }

    /**
     * Obtener el Repuesto
     */
    public function repuesto()
    {
      return $this->belongsTo('App\Repuesto');
    }

    /**
     * Obtener el Insumo
     */
    public function insumo()
    {
      return $this->belongsTo('App\Insumo');
    }

    /**
     * Obtener el Parent [Repuesto / Insumo]
     */
    public function parent()
    {
      if($this->type == 'horas'){
        return 'Horas hombre';
      }

      if($this->type == 'insumo'){
        return 'Insumo';
      }

      return 'Repuesto'; 
    }

    /**
     * Obtener el Titulo segun el tipo de Item
     */
    public function titulo()
    {
      if($this->type == 'horas'){
        return 'Horas hombre';
      }

      if($this->type == 'insumo' || $this->type == 'repuesto'){
        return $this->{$this->type}->descripcion();
      }

      return 'Otros';
    }

    /**
     * Obtener el atributo formateado
     */
    public function valorVenta()
    {
      return number_format($this->valor_venta, 2, ',', '.');
    }

    /**
     * Obtener el atributo formateado
     */
    public function cantidad()
    {
      return number_format($this->cantidad, 0, ',', '.');
    }

    /**
     * Obtener el atributo formateado
     */
    public function total()
    {
      return number_format($this->total, 2, ',', '.');
    }

    /**
     * Obtener el tipo de descuento
     */
    public function descuentoType()
    {
      return $this->descuento_type ? '%' : '';
    }

    /**
     * Obtener el atributo formateado
     */
    public function descuento()
    {
      return number_format($this->descuento, 2, ',', '.');
    }

    /**
     * Obtener el atributo formateado
     */
    public function costo()
    {
      return number_format($this->costo, 2, ',', '.');
    }

    /**
     * Obtener el atributo formateado
     */
    public function utilidad()
    {
      return number_format($this->utilidad, 2, ',', '.');
    }

    /**
     * Obtener el descuento formateado como texto
     */
    public function descuentoText()
    {
      if($this->descuento < 1){
        return '';
      }

      return $this->descuento_type ? (($this->total * $this->descuento)/100).' ('.$this->descuento.'%)' : $this->descuento;
    }

    /**
     * Evaluar si el Item necesita usar Popover para mostrar su descripcion
     */
    public function hasDescripcion()
    {
      return $this->type == 'horas' || $this->type == 'otros';
    }
}
