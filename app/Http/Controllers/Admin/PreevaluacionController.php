<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Auth, Storage};
use Illuminate\Http\Request;
use App\{Preevaluacion, Proceso};

class PreevaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function create(Proceso $proceso)
    {
      $this->authorize('create', [Preevaluacion::class, $proceso]);
      return view('admin.preevaluacion.create', compact('proceso'));
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
      $this->authorize('create', [Preevaluacion::class, $proceso]);
      $this->validate($request, [
        'fotos.*' => 'nullable|image|max:12000|mimes:jpeg,jpg,png',
        'datos' => 'required|min:1|max:12',
        'datos.1.descripcion' => 'required|string',
        'datos.*.descripcion' => 'nullable|string',
        'datos.*.observacion' => 'nullable|string',
        'datos.*.referencia' => 'nullable|numeric|min:0',
      ]);

      $datos = [];

      foreach ($request->datos as $dato) {
        if($dato['descripcion']){
          $dato['taller'] = Auth::id();
          $datos[] = $dato;
        }
      }

      if($proceso->preevaluaciones()->createMany($datos)){
        if($request->hasFile('fotos')){
          $directory = Auth::id().'/procesos/'.$proceso->id.'/preevaluacion';
          if(!Storage::exists($directory)){
            Storage::makeDirectory($directory);
          }

          $fotos = [];

          foreach ($request->file('fotos') as $foto) {
            $fotos[] = [
              'taller' => Auth::id(),
              'foto' => $foto->store($directory),
            ];
          }

          $proceso->preevaluacionFotos()->createMany($fotos);
        }

        $proceso->etapa = 3;
        $proceso->save();

        return redirect()->route('admin.situacion.create', ['proceso' => $proceso->id])->with([
                'flash_message' => 'Pre-evaluación agregada exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.preevaluacion.create', ['prceso' => $proceso->id])->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Preevaluacion  $preevaluacion
     * @return \Illuminate\Http\Response
     */
    public function show(Preevaluacion $preevaluacion)
    {
      //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function edit(Proceso $proceso)
    {
      $this->authorize('update', [Preevaluacion::class, $proceso]);
      $preevaluaciones = $proceso->preevaluaciones;

      return view('admin.preevaluacion.edit', compact('proceso', 'preevaluaciones'));
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
      $this->authorize('update', [Preevaluacion::class, $proceso]);
      $this->validate($request, [
        'fotos.*' => 'nullable|image|max:12000|mimes:jpeg,jpg,png',
        'datos' => 'required|min:1|max:12',
        'datos.1.descripcion' => 'required|string',
        'datos.*.descripcion' => 'nullable|string',
        'datos.*.observacion' => 'nullable|string',
        'datos.*.referencia' => 'nullable|numeric|min:0',
      ]);

      $newDatos = [];
      $preevaluaciones = $proceso->preevaluaciones;

      foreach ($request->datos as $dato) {
        if(!$dato['descripcion']){
          continue;
        }

        if(isset($dato['id'])){
          $preevaluaciones->find($dato['id'])
                          ->update([
                            'descripcion' => $dato['descripcion'],
                            'observacion' => $dato['observacion'],
                            'referencia' => $dato['referencia'],
                          ]);
        }else{
          $dato['taller'] = Auth::id();
          $newDatos[] = $dato;
        }
      }

      if($preevaluaciones->count() < 12){
        // En caso de que hayan mas elementos de los permitidos
        // Guardar solo la cantidad faltante para alcanzar el maximo de 12. 
        $store = array_slice($newDatos, 0, (12 - $preevaluaciones->count()));
        $proceso->preevaluaciones()->createMany($store);
      }

      if($request->hasFile('fotos') && ($proceso->preevaluacionFotos()->count() < 6)){
        $directory = Auth::id().'/procesos/'.$proceso->id.'/preevaluacion';
        if(!Storage::exists($directory)){
          Storage::makeDirectory($directory);
        }

        $fotos = [];

        foreach ($request->file('fotos') as $foto) {
          $fotos[] = [
            'taller' => Auth::id(),
            'foto' => $foto->store($directory),
          ];
        }

        $proceso->preevaluacionFotos()->createMany($fotos);
      }

      return redirect()->route('admin.proceso.show', ['proceso' => $proceso->id])->with([
              'flash_message' => 'Pre-evaluación modificada exitosamente.',
              'flash_class' => 'alert-success'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Preevaluacion  $preevaluacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Preevaluacion $preevaluacion)
    {
      $this->authorize('delete', $preevaluacion);

      if($preevaluacion->delete()){
        return redirect()->route('admin.proceso.show', ['proceso' => $preevaluacion->proceso_id])->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Dato de pre-evaluación eliminado exitosamente.'
              ]);
      }

      return redirect()->route('admin.proceso.show', ['proceso' => $preevaluacion->proceso_id])->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
