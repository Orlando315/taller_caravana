<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Proveedor;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.proveedores.index',['proveedores' => Proveedor::all() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        //dd($request->all());
      $this->validate($request, [
        'tienda' => 'required',
        'vendedor' => 'required',
        'direccion' => 'required',
        'email' => 'required|email|unique:proveedores,email',
        'telefono_local' => 'required|max:15',
        'telefono_celular' => 'required|max:15',
      ]);

      $proveedor = new Proveedor();
      $proveedor->fill($request->all());
      

      if($proveedor->save()){
        return redirect()->route('admin.proveedor.show',['proveedor' => $proveedor->id])->with([
                'flash_message' => 'Proveedor agregado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }else{
        return redirect()->route('admin.proveedor.index')->withInput()->with([
                'flash_message' => 'Ha ocurrido un error.',
                'flash_class' => 'alert-danger',
                'flash_important' => true
              ]);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedor $proveedor)
    {
        return view('admin.proveedores.show',['proveedor' => $proveedor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function edit(Proveedor $proveedor)
    {
        return view('admin.proveedores.edit',['proveedor' => $proveedor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proveedor $proveedor)
    {
      $this->validate($request, [
         'tienda' => 'required',
        'vendedor' => 'required',
        'direccion' => 'required',
        'telefono_local' => 'required|max:15',
        'telefono_celular' => 'required|max:15',
        'email' => 'required|email|unique:proveedores,email,' . $proveedor->id . ',id',
      ]);

      $proveedor->fill($request->all());

      if($proveedor->save()){
        return redirect()->route('admin.proveedor.show', ['proveedor' => $proveedor->id])->with([
                'flash_message' => 'Proveedor modificado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }else{
        return redirect()->route('admin.proveedor.edit', ['proveedor' => $proveedor->id])->withInput()->with([
                'flash_message' => 'Ha ocurrido un error.',
                'flash_class' => 'alert-danger',
                'flash_important' => true
              ]);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proveedor $proveedor)
    {

     if($proveedor->delete()){
        return redirect()->route('admin.proveedor.index')->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Proveedor eliminado exitosamente.'
              ]);
      }else{
        return redirect()->route('admin.proveedor.show', ['proveedor' => $proveedor->id])->with([
                'flash_class'     => 'alert-danger',
                'flash_message'   => 'Ha ocurrido un error.',
                'flash_important' => true
              ]);
      }
    }
}
