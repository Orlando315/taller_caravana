<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Vehiculo;
use App\VehiculosMarca;
use App\VehiculosModelo;
use App\VehiculosAnio;
use App\Cliente;

class VehiculosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $vehiculos = Vehiculo::all();
      $marcas = VehiculosMarca::withCount('vehiculos')->get();
      $modelos = VehiculosModelo::withCount('vehiculos')->get();
      $anios = VehiculosAnio::withCount('vehiculos')->get();

      return view('admin.vehiculo.index', compact('vehiculos', 'marcas', 'modelos', 'anios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function create(Cliente $cliente = null)
    {
      $clientes = Cliente::all();
      $marcas = VehiculosMarca::has('modelos')->with('modelos')->get();
      $anios = VehiculosAnio::all();

      return view('admin.vehiculo.create', compact('cliente', 'clientes', 'marcas', 'anios'));
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
        'cliente' => 'required',
        'año' => 'required',
        'modelo' => 'required',
        'patentes' => 'nullable|string|max:50',
        'color' => 'nullable|string|max:50',
        'km' => 'nullable|numeric|min:0|max:9999999',
        'vin' => 'nullable|string|max:50'
      ]);

      $modelo = VehiculosModelo::findOrFail($request->modelo);

      $vehiculo = new Vehiculo($request->only(['patentes', 'km', 'vin']));
      $vehiculo->cliente_id = $request->cliente;
      $vehiculo->vehiculo_marca_id = $modelo->vehiculo_marca_id;
      $vehiculo->vehiculo_modelo_id = $modelo->id;
      $vehiculo->vehiculo_anio_id = $request->input('año');

      if(Auth::user()->vehiculos()->save($vehiculo)){
        return redirect()->route('admin.vehiculo.show', ['vehiculo' => $vehiculo->id])->with([
                'flash_message' => 'Vehículo agregado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.vehiculo.create')->withInput()->with([
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
      return view('admin.vehiculo.show', compact('vehiculo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehiculo $vehiculo)
    {
      $clientes = Cliente::all();
      $marcas = VehiculosMarca::has('modelos')->with('modelos')->get();
      $anios = VehiculosAnio::all();

      return view('admin.vehiculo.edit', compact('vehiculo', 'clientes', 'marcas', 'anios'));
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
      $this->validate($request, [
        'cliente' => 'required',
        'año' => 'required',
        'marca' => 'required',
        'modelo' => 'required',
        'patentes' => 'nullable|string|max:50',
        'color' => 'nullable|string|max:50',
        'km' => 'nullable|numeric|min:0|max:9999999',
        'vin' => 'nullable|string|max:50'
      ]);

      $vehiculo->fill($request->all());
      $vehiculo->cliente_id = $request->cliente;
      $vehiculo->vehiculo_marca_id = $request->marca;
      $vehiculo->vehiculo_modelo_id = $request->modelo;
      $vehiculo->vehiculo_anio_id = $request->input('año');

      if($vehiculo->save()){
        return redirect()->route('admin.vehiculo.show', ['vehiculo' => $vehiculo->id])->with([
                'flash_message' => 'Vehículo modificado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.vehiculo.edit', ['vehiculo' => $vehiculo->id])->withInput()->with([
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
      if($vehiculo->delete()){
        return redirect()->route('admin.vehiculo.index')->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Vehículo eliminado exitosamente.'
              ]);
      }

      return redirect()->route('admin.vehiculo.show', ['vehiculo' => $vehiculo->id])->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
