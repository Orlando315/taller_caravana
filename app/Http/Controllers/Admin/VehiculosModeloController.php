<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\VehiculosMarca;
use App\VehiculosModelo;

class VehiculosModeloController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $marcas = VehiculosMarca::all();

      return view('admin.vehiculo.modelo.create', compact('marcas'));
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
        'modelo' => 'required|string|max:50',
      ]);

      $modelo = new VehiculosModelo($request->all());
      $modelo->vehiculo_marca_id = $request->marca;

      if(Auth::user()->modelos()->save($modelo)){
        return redirect()->route('admin.vehiculo.modelo.show', ['modelo' => $modelo->id])->with([
                'flash_message' => 'Modelo agregado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.vehiculo.modelo.create')->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VehiculosModelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function show(VehiculosModelo $modelo)
    {
      $vehiculos = $modelo->vehiculos()->with(['cliente', 'marca', 'anio'])->get();

      return view('admin.vehiculo.modelo.show', compact('modelo', 'vehiculos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehiculosModelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function edit(VehiculosModelo $modelo)
    {
      return view('admin.vehiculo.modelo.edit', compact('modelo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehiculosModelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehiculosModelo $modelo)
    {
      $this->validate($request, [
        'modelo' => 'required|string|max:50',
      ]);

      $modelo->fill($request->all());

      if($modelo->save()){
        return redirect()->route('admin.vehiculo.modelo.show', ['modelo' => $modelo->id])->with([
                'flash_message' => 'Modelo modificado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.vehiculo.modelo.edit', ['modelo' => $modelo->id])->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VehiculosModelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehiculosModelo $modelo)
    {
      if($modelo->vehiculos()->count() > 0){
        return redirect()->route('admin.vehiculo.modelo.show', ['modelo' => $modelo->id])->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Este Modelo tiene Vehiculos agregados.',
              'flash_important' => true
            ]);
      }

      if($modelo->delete()){
        return redirect()->route('admin.vehiculo.index')->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Modelo eliminado exitosamente.'
              ]);
      }

      return redirect()->route('admin.vehiculo.modelo.show', ['modelo' => $modelo->id])->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
