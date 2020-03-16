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
      $this->authorize('index', Vehiculo::class);

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
      $this->authorize('create', Vehiculo::class);

      $clientes = Cliente::all();
      $marcas = VehiculosMarca::has('modelos')->with('modelos')->get();
      $anios = VehiculosAnio::all();

      return view('admin.vehiculo.create', compact('cliente', 'clientes', 'marcas', 'anios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Cliente $cliente = null)
    {
      $this->authorize('create', Vehiculo::class);
      $this->validate($request, [
        'cliente' => 'required',
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
      $vehiculo->cliente_id = $request->cliente;
      $vehiculo->vehiculo_marca_id = $modelo->vehiculo_marca_id;
      $vehiculo->vehiculo_modelo_id = $modelo->id;
      $vehiculo->vehiculo_anio_id = $request->input('año');

      if(Auth::user()->vehiculos()->save($vehiculo)){
        if($request->ajax()){
          return response()->json(['response' => true]);
        }

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
      $this->authorize('view', $vehiculo);

      $procesos = $vehiculo->procesos;

      return view('admin.vehiculo.show', compact('vehiculo', 'procesos'));
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
      $this->authorize('update', $vehiculo);
      $this->validate($request, [
        'cliente' => 'required',
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
      $vehiculo->cliente_id = $request->cliente;
      $vehiculo->vehiculo_marca_id = $modelo->vehiculo_marca_id;
      $vehiculo->vehiculo_modelo_id = $modelo->id;
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
      $this->authorize('delete', $vehiculo);

      if($vehiculo->procesos()->count() > 0){
        return redirect()->back()->with([
                'flash_class'     => 'alert-danger',
                'flash_message'   => 'Este Vehículo tiene Procesos asociados a el',
                'flash_important' => true
              ]);
      }

      if($vehiculo->delete()){
        return redirect()->route('admin.vehiculo.index')->with([
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
