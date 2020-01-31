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
      $marcas = VehiculosMarca::all();
      $anios = VehiculosAnio::all();

      return view('admin.proveedores.vehiculos.create', ['proveedor' => $proveedor,'marcas' => $marcas, 'anios' => $anios]);
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
      $this->validate($request, [
        'modelos' => 'required',
        'año' => 'required',
      ]);

      $vehiculos = [];

      foreach ($request->modelos as $id) {
        $modelo = VehiculosModelo::find($id);

        if($modelo){
          $vehiculos[] = [
                        'taller' => Auth::id(),
                        'vehiculo_anio_id' => $request->input('año'),
                        'vehiculo_marca_id' => $modelo->vehiculo_marca_id,
                        'vehiculo_modelo_id' => $modelo->id,
                      ];
        }
      }

      if($proveedor->vehiculos()->createMany($vehiculos)){
        return redirect()->route('admin.proveedor.show', ['proveedor' => $proveedor->id])->with([
                'flash_message' => 'Vehículo agregado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.proveedor.show', ['proveedor' => $proveedor->id])->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
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
      if($vehiculo->delete()){
          return redirect()->back()->with([
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
