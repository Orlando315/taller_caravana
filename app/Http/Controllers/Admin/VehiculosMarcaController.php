<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\VehiculosMarca;

class VehiculosMarcaController extends Controller
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
      return view('admin.vehiculo.marca.create');
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
        'marca' => 'required|string|max:50',
      ]);

      $marca = new VehiculosMarca($request->all());

      if(Auth::user()->marcas()->save($marca)){
        return redirect()->route('admin.vehiculo.marca.show', ['marca' => $marca->id])->with([
                'flash_message' => 'Marca agregada exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.vehiculo.marca.create')->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VehiculosMarca  $marca
     * @return \Illuminate\Http\Response
     */
    public function show(VehiculosMarca $marca)
    {
      $vehiculos = $marca->vehiculos()->with(['cliente', 'modelo', 'anio'])->get();

      return view('admin.vehiculo.marca.show', compact('marca', 'vehiculos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehiculosMarca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(VehiculosMarca $marca)
    {
      return view('admin.vehiculo.marca.edit', compact('marca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehiculosMarca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehiculosMarca $marca)
    {
      $this->validate($request, [
        'marca' => 'required|string|max:50',
      ]);

      $marca->fill($request->all());

      if($marca->save()){
        return redirect()->route('admin.vehiculo.marca.show', ['marca' => $marca->id])->with([
                'flash_message' => 'Marca modificada exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.vehiculo.marca.edit', ['marca' => $marca->id])->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VehiculosMarca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehiculosMarca $marca)
    {
      if($marca->modelos()->count() > 0){
        return redirect()->route('admin.vehiculo.marca.show', ['marca' => $marca->id])->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Esta Maraca tiene Modelos agregados.',
              'flash_important' => true
            ]);
      }

      if($marca->delete()){
        return redirect()->route('admin.vehiculo.index')->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Marca eliminada exitosamente.'
              ]);
      }

      return redirect()->route('admin.vehiculo.marca.show', ['marca' => $marca->id])->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }

    /**
     * Obtener los Modelos de la Marca especificada
     *
     * @param  \App\VehiculosMarca  $marca
     * @return \Illuminate\Http\Response
     */
    public function modelos(VehiculosMarca $marca)
    {
      return response()->json($marca->modelos()->select(['id', 'modelo', 'vehiculo_marca_id'])->get());
    }
}
