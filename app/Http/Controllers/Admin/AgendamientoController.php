<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\{Agendamiento, Vehiculo, Cliente};

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
     * @return \Illuminate\Http\Response
     */
    public function create(Cliente $cliente = null, Vehiculo $vehiculo = null)
    {
      $clientes = Cliente::all();
      $vehiculos = Vehiculo::all();

      return view('admin.agendamiento.create', compact('clientes', 'vehiculos', 'cliente', 'vehiculo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'vehiculo' => 'required',
      ]);

      if(!$request->atender){
        $this->validate($request, [
        'fecha' => 'required|date',
        ]);
      }

      $agendamiento = new Agendamiento([
                        'vehiculo_id' => $request->vehiculo,
                        'atender' => isset($request->atender),
                        'fecha' => $request->atender ? date('Y-m-d H:i:s') : $request->fecha,
                      ]);

      if(Auth::user()->agendamientos()->save($agendamiento)){
        return redirect()->route('admin.agendamiento.index')->with([
                'flash_message' => 'Agendamiento agregado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.agendamiento.create')->withInput()->with([
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
      return view('admin.agendamiento.show', compact('agendamiento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agendamiento  $agendamiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Agendamiento $agendamiento)
    {
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
      $this->validate($request, [
        'fecha' => 'nullable|date',
      ]);

      $agendamiento->fecha = $request->fecha ?? $agendamiento->fecha;

      if($agendamiento->save()){
        return redirect()->route('admin.agendamiento.show', ['agendamiento' => $agendamiento->id])->with([
                'flash_message' => 'Agendamiento modificado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.agendamiento.create')->withInput()->with([
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
        return redirect()->route('admin.agendamiento.index')->with([
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
