<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\{Agendamiento, Proceso};

class AgendamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $agendamientos = Agendamiento::all();

      return view('admin.agendamiento.index', compact('agendamientos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function create(Proceso $proceso)
    {
      $this->authorize('create', [Agendamiento::class, $proceso]);

      return view('admin.agendamiento.create', compact('proceso'));
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
      $this->authorize('create', [Agendamiento::class, $proceso]);
      if(!$request->atender){
        $this->validate($request, [
        'fecha' => 'required|date',
        ]);
      }

      if(!$request->atender && !$request->fecha){
        return redirect()->route('admin.agendamiento.create', ['proceso' => $proceso->id])->withInput()->with([
              'flash_message' => 'Debe seleccionar una fecha, o "Atender inmediatamente".',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
      }

      $agendamiento = new Agendamiento([
                        'taller' => Auth::id(),
                        'atender' => isset($request->atender),
                        'fecha' => $request->atender ? date('Y-m-d H:i:s') : $request->fecha,
                      ]);

      if($proceso->agendamiento()->save($agendamiento)){
        $proceso->etapa = 2;
        $proceso->save();

        return redirect()->route('admin.preevaluacion.create', ['proceso' => $proceso->id])->with([
                'flash_message' => 'Agendamiento agregado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.agendamiento.create', ['proceso' => $proceso->id])->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agendamiento  $agendamiento
     * @return \Illuminate\Http\Response
     */
    public function show(Agendamiento $agendamiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agendamiento  $agendamiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Agendamiento $agendamiento)
    {
      $this->authorize('update', [Agendamiento::class, $proceso]);
      return view('admin.agendamiento.edit', compact('agendamiento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agendamiento  $agendamiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agendamiento $agendamiento)
    {
      $this->authorize('update', [Agendamiento::class, $proceso]);
      $this->validate($request, [
        'fecha' => 'nullable|date',
      ]);

      $agendamiento->fecha = $request->fecha ?? $agendamiento->fecha;

      if($agendamiento->save()){
        return redirect()->route('admin.proceso.show', ['proceso' => $agendamiento->proceso_id])->with([
                'flash_message' => 'Agendamiento modificado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.agendamiento.edit', ['agendamiento' => $agendamiento->id])->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agendamiento  $agendamiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agendamiento $agendamiento)
    {
      if($agendamiento->delete()){
        return redirect()->route('admin.proceso.show', ['proceso' => $agendamiento->proceso_id])->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Agendamiento eliminado exitosamente.'
              ]);
      }

      return redirect()->route('admin.agendamiento.show', ['agendamiento' => $agendamiento->id])->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
