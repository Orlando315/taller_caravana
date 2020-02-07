<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CotizacionItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cotizaciones_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'item_id',
    ];
}
