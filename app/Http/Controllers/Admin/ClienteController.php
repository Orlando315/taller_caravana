<?php

namespace App\Http\Controllers\Admin;

use Illuminate\support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $clientes = Cliente::all();

      return view('admin.cliente.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.cliente.create');
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
        'nombres' => 'required|string|max:50',
        'apellidos' => 'nullable|string|max:50',
        'rut' => 'required|regex:/^(\d{4,9}-[\dk])$/|unique:clientes,rut',
        'email' => 'nullable|email|unique:clientes,email',
        'telefono' => 'required|string|max:15',
        'direccion' => 'nullable|string|max:150',
      ]);

      $cliente = new Cliente($request->all());

      if(Auth::user()->clientes()->save($cliente)){
        return redirect()->route('admin.cliente.show', ['cliente' => $cliente->id])->with([
                'flash_message' => 'Cliente agregado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.cliente.create')->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
      $vehiculos = $cliente->vehiculos()->with(['marca', 'modelo'])->get();

      return view('admin.cliente.show', compact('cliente', 'vehiculos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
      return view('admin.cliente.edit', compact('cliente')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
      $this->validate($request, [
        'nombres' => 'required|string|max:50',
        'apellidos' => 'nullable|string|max:50',
        'rut' => 'required|regex:/^(\d{4,9}-[\dk])$/|unique:clientes,rut,' . $cliente->id . ',id',
        'email' => 'required|email|unique:clientes,email,' . $cliente->id . ',id',
        'telefono' => 'required|string|max:15',
        'direccion' => 'nullable|string|max:150',
      ]);

      $cliente->fill($request->all());

      if($cliente->save()){
        return redirect()->route('admin.cliente.show', ['cliente' => $cliente->id])->with([
                'flash_message' => 'Cliente modificado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.cliente.edit', ['cliente' => $cliente->id])->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
      if($cliente->vehiculos()->count() > 0){
        return redirect()->route('admin.cliente.show', ['cliente' => $cliente->id])->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Este Cliente tiene Vehiculos agregados.',
              'flash_important' => true
            ]);
      }

      if($cliente->delete()){
        return redirect()->route('admin.cliente.index')->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Cliente eliminado exitosamente.'
              ]);
      }

      return redirect()->route('admin.cliente.show', ['cliente' => $cliente->id])->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
