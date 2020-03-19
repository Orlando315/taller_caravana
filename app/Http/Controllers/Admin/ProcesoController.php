<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Auth, Storage};
use Illuminate\Http\Request;
use App\{Proceso, Cliente, VehiculosAnio, VehiculosMarca};

class ProcesoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('index', Proceso::class);

      $procesos = Proceso::all();

      return view('admin.proceso.index', compact('procesos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', Proceso::class);

      $clientes = Cliente::all();
      $marcas = VehiculosMarca::has('modelos')->with('modelos')->get();
      $anios = VehiculosAnio::all();

      return view('admin.proceso.create', compact('clientes', 'marcas', 'anios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create', Proceso::class);
      $this->validate($request, [
        'cliente' => 'required',
        'vehiculo' => 'required',
      ]);

      $proceso = new Proceso(
                [
                  'cliente_id' => $request->cliente,
                  'vehiculo_id' => $request->vehiculo,
                ]);

      if(Auth::user()->procesos()->save($proceso)){
        return redirect()->route('admin.agendamiento.create', ['proceso' => $proceso->id])->with([
                'flash_message' => 'Proceso iniciado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.proceso.create')->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
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

      $preevaluaciones = $proceso->preevaluaciones;
      $preevaluacionesFotos = $proceso->preevaluacionFotos;
      $pagos = $proceso->pagos;
      $imprevistos = $proceso->imprevistos()->get();

      return view('admin.proceso.show', compact('proceso', 'preevaluaciones', 'preevaluacionesFotos', 'pagos', 'imprevistos'));
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
      $this->authorize('delete', $proceso);

      if($proceso->delete()){
        $directory = Auth::id().'/procesos/'.$proceso->id;

        if(Storage::exists($directory)){
          Storage::deleteDirectory($directory);
        }

        return redirect()->route('admin.proceso.index')->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Proceso eliminado exitosamente.'
              ]);
      }

      return redirect()->route('admin.proceso.show', ['proceso' => $proceso->id])->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }

    /**
     * Marcar los Procesos como Completados.
     *
     * @param  \App\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function status(Proceso $proceso)
    {
      $this->authorize('update', $proceso);

      $proceso->status = true;

      if($proceso->save()){

        return redirect()->route('admin.proceso.show', ['proceso' => $proceso->id])->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'El Proceso fue marcado como completo.'
              ]);
      }

      return redirect()->route('admin.proceso.show', ['proceso' => $proceso->id])->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
