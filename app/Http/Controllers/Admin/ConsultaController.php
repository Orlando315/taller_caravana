<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Proceso;

class ConsultaController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function finanzas()
    {
      return view('admin.consulta.finanzas');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getFinanzas(Request $request)
    {
      $finanzas = Proceso::finanzas($request->inicio, $request->fin);

      return response()->json(['response' =>  true, 'finanzas' => $finanzas]);
    }
}
