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
      $this->authorize('index', Proveedor::class);

      $proveedores = Proveedor::all();

      return view('admin.proveedores.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', Proveedor::class);

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
      $this->authorize('create', Proveedor::class);
      $this->validate($request, [
        'proveedor' => 'required',
        'vendedor' => 'required',
        'direccion' => 'required',
        'email' => 'required|email|unique:proveedores,email',
        'telefono_local' => 'nullable|max:15',
        'telefono_celular' => 'nullable|max:15',
        'descuento' => 'nullable|numeric|min:0',
      ]);

      $proveedor = new Proveedor($request->except('proveedor'));
      $proveedor->tienda = $request->proveedor;

      if(Auth::user()->proveedores()->save($proveedor)){
        return redirect()->route('admin.proveedor.show', ['proveedor' => $proveedor->id])->with([
                'flash_message' => 'Proveedor agregado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.proveedor.index')->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedor $proveedor)
    {
      $this->authorize('view', $proveedor);

      return view('admin.proveedores.show', compact('proveedor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function edit(Proveedor $proveedor)
    {
      $this->authorize('update', $proveedor);

      return view('admin.proveedores.edit', compact('proveedor'));
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
      $this->authorize('update', $proveedor);
      $this->validate($request, [
        'proveedor' => 'required',
        'vendedor' => 'required',
        'direccion' => 'required',
        'telefono_local' => 'nullable|max:15',
        'telefono_celular' => 'nullable|max:15',
        'email' => 'required|email|unique:proveedores,email,' . $proveedor->id . ',id',
        'descuento' => 'nullable|numeric|min:0',
      ]);

      $proveedor->fill($request->except('proveedor'));
      $proveedor->tienda = $request->proveedor;

      if($proveedor->save()){
        return redirect()->route('admin.proveedor.show', ['proveedor' => $proveedor->id])->with([
                'flash_message' => 'Proveedor modificado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.proveedor.edit', ['proveedor' => $proveedor->id])->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proveedor $proveedor)
    {
      $this->authorize('delete', $proveedor);

      if($proveedor->delete()){
        return redirect()->route('admin.proveedor.index')->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Proveedor eliminado exitosamente.'
              ]);
      }

      return redirect()->route('admin.proveedor.show', ['proveedor' => $proveedor->id])->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
