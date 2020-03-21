<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Proceso;

class ProcesoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if(Auth::user()->isStaff()){
        abort(403);
      }

      $procesos = Auth::user()->cliente->procesos;

      return view('proceso.index', compact('procesos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function show(Proceso $proceso)
    {
      $this->authorize('view', $proceso);
      if(Auth::user()->isStaff()){
        abort(403);
      }

      $preevaluaciones = $proceso->preevaluaciones;
      $preevaluacionesFotos = $proceso->preevaluacionFotos;
      $pagos = $proceso->pagos;
      $proceso->load('situacion.items');

      $situacionRepuestos = $proceso->situacion->getItemsByType('repuesto')->get();
      $situacionInsumos = $proceso->situacion->getItemsByType('insumo')->get();
      $situacionHoras = $proceso->situacion->getItemsByType()->get();
      $situacionOtros = $proceso->situacion->getItemsByType('otros')->get();

      return view('proceso.show', compact('proceso', 'preevaluaciones', 'preevaluacionesFotos', 'pagos', 'situacionRepuestos', 'situacionInsumos', 'situacionHoras', 'situacionOtros'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function edit(Proceso $proceso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proceso $proceso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proceso $proceso)
    {
        //
    }
}
