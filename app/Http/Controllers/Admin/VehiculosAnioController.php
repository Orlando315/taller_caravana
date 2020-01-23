<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\VehiculosAnio;

class VehiculosAnioController extends Controller
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
      return view('admin.vehiculo.anio.create');
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
        'año' => 'required|integer|min:1900|max:2100',
      ]);

      $anio = new VehiculosAnio(['anio' => $request->input('año')]);

      if(Auth::user()->anios()->save($anio)){
        return redirect()->route('admin.vehiculo.anio.show', ['anio' => $anio->id])->with([
                'flash_message' => 'Año agregado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.vehiculo.anio.create')->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VehiculosAnio  $anio
     * @return \Illuminate\Http\Response
     */
    public function show(VehiculosAnio $anio)
    {
      $vehiculos = $anio->vehiculos()->with(['cliente', 'marca', 'modelo'])->get();

      return view('admin.vehiculo.anio.show', compact('anio', 'vehiculos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehiculosAnio  $anio
     * @return \Illuminate\Http\Response
     */
    public function edit(VehiculosAnio $anio)
    {
      return view('admin.vehiculo.anio.edit', compact('anio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehiculosAnio  $anio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehiculosAnio $anio)
    {
      $this->validate($request, [
        'anio' => 'required|integer|min:1900|max:2100',
      ]);

      $anio->fill($request->all());

      if($anio->save()){
        return redirect()->route('admin.vehiculo.anio.show', ['anio' => $anio->id])->with([
                'flash_message' => 'Año modificado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.vehiculo.anio.edit', ['anio' => $anio->id])->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VehiculosAnio  $anio
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehiculosAnio $anio)
    {
      if($anio->anios()->count() > 0){
        return redirect()->route('admin.vehiculo.anio.show', ['anio' => $anio->id])->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Este Año tiene Vehículos agregados.',
              'flash_important' => true
            ]);
      }

      if($anio->delete()){
        return redirect()->route('admin.vehiculo.index')->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Año eliminado exitosamente.'
              ]);
      }

      return redirect()->route('admin.vehiculo.anio.show', ['anio' => $anio->id])->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
