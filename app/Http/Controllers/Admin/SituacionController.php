<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\{Situacion, SituacionItem, Proceso, Insumo, Repuesto};

class SituacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function create(Proceso $proceso)
    {
      $this->authorize('create', [Situacion::class, $proceso]);
      $insumos = Insumo::has('stockEnUso')->with('stockEnUso')->get();
      $repuestos = Repuesto::all();

      return view('admin.situacion.create', compact('proceso', 'insumos', 'repuestos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Proceso $proceso)
    {
      $this->authorize('create', [Situacion::class, $proceso]);
      $this->validate($request, [
        'datos' => 'required|min:1',
        'datos.*.descripcion' => 'nullable|string|max:500',
      ]);

      $datos = [];

      foreach ($request->datos as $dato) {
        if(($dato['type'] == 'insumo' || $dato['type'] == 'repuesto') && isset($dato['item'])){
          $dato["{$dato['type']}_id"] = $dato['item'];
        }

        if($dato['type'] == 'horas' && $dato['descuento'] > 0){
          $dato['total_descuento'] = $dato['descuento_type'] == 'true' ? ($dato['total'] * $dato['descuento']) / 100 : $dato['descuento'];
        }

        $dato['descuento_type'] = $dato['descuento_type'] == 'true';
        $datos[] = $dato;
      }

      $situacion = new Situacion([
                      'taller' => Auth::id(),
                    ]);

      if($proceso->situacion()->save($situacion)){
        if($situacion->items()->createMany($datos)){
          $proceso->etapa = 4;
          $proceso->save();

          return redirect()->route('admin.proceso.show', ['proceso' => $proceso->id])->with([
                  'flash_message' => 'Hoja de situación agregada exitosamente.',
                  'flash_class' => 'alert-success'
                ]);
        }else{
          $situacion->delete();
        }
      }

      return redirect()->route('admin.situacion.create', ['proceso' => $proceso->id])->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Situacion  $situacion
     * @return \Illuminate\Http\Response
     */
    public function show(Situacion $situacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Situacion  $situacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Situacion $situacion)
    {
      $this->authorize('update', $situacion);
      $insumos = Insumo::has('stockEnUso')->with('stockEnUso')->get();
      $repuestos = Repuesto::all();

      return view('admin.situacion.edit', compact('situacion', 'insumos', 'repuestos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Situacion  $situacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Situacion $situacion)
    {
      $this->authorize('update', $situacion);
      $this->validate($request, [
        'dato.*.descripcion' => 'nullable|string|max:500'
      ]);
      $datos = [];

      foreach ($request->datos as $dato) {
        if(($dato['type'] == 'insumo' || $dato['type'] == 'repuesto') && isset($dato['item'])){
          $dato["{$dato['type']}_id"] = $dato['item'];
        }

        if($dato['type'] == 'horas' && $dato['descuento'] > 0){
          $dato['total_descuento'] = $dato['descuento_type'] == 'true' ? ($dato['total'] * $dato['descuento']) / 100 : $dato['descuento'];
        }

        $dato['descuento_type'] = $dato['descuento_type'] == 'true';

        $datos[] = $dato;
      }

      if($situacion->items()->createMany($datos)){
        return redirect()->route('admin.proceso.show', ['proceso' => $situacion->proceso_id])->with([
                'flash_message' => 'Hoja de situación modificada exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.situacion.edit', ['situacion' => $situacion->id])->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Situacion  $situacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Situacion $situacion)
    {
      //
    }
}
