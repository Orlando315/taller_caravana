<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Vehiculo;
use App\VehiculosMarca;
use App\VehiculosModelo;
use App\VehiculosAnio;

class VehiculoController extends Controller
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

      $vehiculos = Auth::user()->cliente->vehiculos;

      return view('vehiculo.index', compact('vehiculos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if(Auth::user()->isStaff()){
        abort(403);
      }

      $marcas = VehiculosMarca::has('modelos')->with('modelos')->get();
      $anios = VehiculosAnio::all();

      return view('vehiculo.create', compact('marcas', 'anios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if(Auth::user()->isStaff()){
        abort(403);
      }

      $this->validate($request, [
        'año' => 'required',
        'modelo' => 'required',
        'patentes' => 'required|string|max:50',
        'color' => 'nullable|string|max:50',
        'km' => 'nullable|numeric|min:0|max:9999999',
        'vin' => 'required|string|max:50',
        'motor' => 'nullable|integer|min:0|max:9999',
      ]);

      $modelo = VehiculosModelo::findOrFail($request->modelo);

      $vehiculo = new Vehiculo($request->only(['patentes', 'color', 'km', 'vin', 'motor']));
      $vehiculo->vehiculo_marca_id = $modelo->vehiculo_marca_id;
      $vehiculo->vehiculo_modelo_id = $modelo->id;
      $vehiculo->vehiculo_anio_id = $request->input('año');
      $vehiculo->taller = Auth::user()->user_id;

      if(Auth::user()->cliente->vehiculos()->save($vehiculo)){
        return redirect()->route('vehiculo.show', ['vehiculo' => $vehiculo->id])->with([
                'flash_message' => 'Vehículo agregado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('vehiculo.create')->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function show(Vehiculo $vehiculo)
    {
      $this->authorize('view', $vehiculo);
      if(Auth::user()->isStaff()){
        abort(403);
      }

      $procesos = $vehiculo->procesos;

      return view('vehiculo.show', compact('vehiculo', 'procesos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehiculo $vehiculo)
    {
      $this->authorize('update', $vehiculo);
      if(Auth::user()->isStaff()){
        abort(403);
      }

      $marcas = VehiculosMarca::has('modelos')->with('modelos')->get();
      $anios = VehiculosAnio::all();

      return view('vehiculo.edit', compact('vehiculo', 'marcas', 'anios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehiculo $vehiculo)
    {
      $this->authorize('update', $vehiculo);
      if(Auth::user()->isStaff()){
        abort(403);
      }

      $this->validate($request, [
        'año' => 'required',
        'modelo' => 'required',
        'patentes' => 'required|string|max:50',
        'color' => 'nullable|string|max:50',
        'km' => 'nullable|numeric|min:0|max:9999999',
        'vin' => 'required|string|max:50',
        'motor' => 'nullable|integer|min:0|max:9999',
      ]);

      $modelo = VehiculosModelo::findOrFail($request->modelo);

      $vehiculo->fill($request->only(['patentes', 'color', 'km', 'vin', 'motor']));
      $vehiculo->vehiculo_marca_id = $modelo->vehiculo_marca_id;
      $vehiculo->vehiculo_modelo_id = $modelo->id;
      $vehiculo->vehiculo_anio_id = $request->input('año');

      if($vehiculo->save()){
        return redirect()->route('vehiculo.show', ['vehiculo' => $vehiculo->id])->with([
                'flash_message' => 'Vehículo modificado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('vehiculo.edit', ['vehiculo' => $vehiculo->id])->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehiculo $vehiculo)
    {
      $this->authorize('delete', $vehiculo);
      if(Auth::user()->isStaff()){
        abort(403);
      }

      if($vehiculo->procesos()->count() > 0){
        return redirect()->back()->with([
                'flash_class'     => 'alert-danger',
                'flash_message'   => 'Este Vehículo tiene Procesos asociados a el',
                'flash_important' => true
              ]);
      }

      if($vehiculo->delete()){
        return redirect()->route('vehiculo.index')->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Vehículo eliminado exitosamente.'
              ]);
      }

      return redirect()->back()->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
