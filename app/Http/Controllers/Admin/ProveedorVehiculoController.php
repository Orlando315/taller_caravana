<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Proveedor, ProveedorVehiculo, VehiculosMarca, VehiculosAnio};

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
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $proveedor = Proveedor::findOrfail($id);
        $marca = VehiculosMarca::all();
        $anio = VehiculosAnio::all();

        return view('admin.proveedores.vehiculos.create',['proveedor' => $proveedor,'marca' => $marca,'anio' => $anio]);
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
        'proveedor_id' => 'required|integer',
        'vehiculo_marca_id' => 'required|integer',
        'vehiculo_modelo_id' => 'required|integer',
        'vehiculo_anio_id' => 'required|integer',
        
      ]);

      $proveedor_vehiculo = new ProveedorVehiculo();
      $proveedor_vehiculo->fill($request->all());
      

      if($proveedor_vehiculo->save()){
        return redirect()->route('admin.proveedor.show',['proveedor' => $request->proveedor_id])->with([
                'flash_message' => 'Vehiculo agregado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }else{
        return redirect()->route('admin.proveedor.show',['proveedor' => $request->proveedor_id])->withInput()->with([
                'flash_message' => 'Ha ocurrido un error.',
                'flash_class' => 'alert-danger',
                'flash_important' => true
              ]);
      }
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
    public function destroy($id)
    {

        $vehiculo = ProveedorVehiculo::findOrfail($id);
        if($vehiculo->delete()){
            return redirect()->back()->with([
                    'flash_class'   => 'alert-success',
                    'flash_message' => 'Vehiculo eliminado exitosamente.'
                  ]);
        }else{
            return redirect()->back()->with([
                    'flash_class'     => 'alert-danger',
                    'flash_message'   => 'Ha ocurrido un error.',
                    'flash_important' => true
                  ]);
        }
    }

    public function search_modelo(Request $request)
    {
        $modelos = VehiculosMarca::findOrfail($request->id)->modelos;

        return response()->json(['modelos' => $modelos]);
    }
}
