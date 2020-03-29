<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Proveedor, ProveedorVehiculo, VehiculosMarca, VehiculosModelo, VehiculosAnio};

class ProveedorVehiculoController extends Controller
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
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function create(Proveedor $proveedor)
    {
      $this->authorize('update', $proveedor);
      $ids = $proveedor->vehiculos()->pluck('vehiculo_marca_id')->toArray();
      $marcas = VehiculosMarca::whereNotIn('id', $ids)->get();

      return view('admin.proveedores.vehiculos.create', compact('proveedor', 'marcas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Proveedor  $proveedor
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Proveedor $proveedor)
    {
      $this->authorize('update', $proveedor);
      $this->validate($request, [
        'marcas' => 'required',
      ]);

      $proveedor->marcas()->attach($request->marcas, ['taller' => Auth::id()]);

      return redirect()->route('admin.proveedor.show', ['proveedor' => $proveedor->id])->with([
              'flash_message' => 'Marcas agregadas exitosamente.',
              'flash_class' => 'alert-success'
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProveedorVehiculo  $proveedorVehiculo
     * @return \Illuminate\Http\Response
     */
    public function show(ProveedorVehiculo $proveedorVehiculo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProveedorVehiculo  $proveedorVehiculo
     * @return \Illuminate\Http\Response
     */
    public function edit(ProveedorVehiculo $proveedorVehiculo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProveedorVehiculo  $proveedorVehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProveedorVehiculo $proveedorVehiculo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProveedorVehiculo  $proveedorVehiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProveedorVehiculo $vehiculo)
    {
      $this->authorize('update', $vehiculo->proveedor);
      if($vehiculo->delete()){
          return redirect()->back()->with([
                  'flash_class'   => 'alert-success',
                  'flash_message' => 'Marca eliminada exitosamente.'
                ]);
      }

      return redirect()->back()->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
