<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\VehiculosMarca;

class ModelosByMarcaController extends Controller
{
    /**
     * Usado solo para obtener la ruta en el ajax.
     */
    public function index()
    {
        abort(404);
    }

    /**
     * Obtener los Modelos de la Marca especificada
     *
     * @param  \App\VehiculosMarca  $marca
     * @return \Illuminate\Http\Response
     */
    public function modelos(VehiculosMarca $marca)
    {
      return response()->json($marca->modelos()->select(['id', 'modelo', 'vehiculo_marca_id'])->get());
    }

}
