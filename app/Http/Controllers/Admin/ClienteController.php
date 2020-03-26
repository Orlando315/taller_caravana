<?php

namespace App\Http\Controllers\Admin;

use Illuminate\support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\{Cliente, User};

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('index', Cliente::class);

      $clientes = Cliente::with('user')->get();

      return view('admin.cliente.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', Cliente::class);

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
      $this->authorize('create', Cliente::class);
      $this->validate($request, [
        'nombres' => 'required|string|max:50',
        'apellidos' => 'nullable|string|max:50',
        'rut' => 'required|regex:/^(\d{4,9}-[\dk])$/|unique:clientes,rut',
        'email' => 'required|email|unique:users,email',
        'telefono' => 'required|string|max:15',
        'direccion' => 'nullable|string|max:150',
      ]);

      $user = new User($request->only(['nombres', 'apellidos', 'email']));
      $user->user_id = Auth::id();
      $user->password = bcrypt(Str::before($request->rut, '-'));
      $cliente = new Cliente($request->only(['rut', 'direccion', 'telefono']));
      $cliente->taller = Auth::id();

      if($user->save()){
        $user->cliente()->save($cliente);
        
        if($request->ajax()){
          return response()->json(['response' => true, 'cliente' => ['id' => $cliente->id, 'nombre' => $cliente->nombre()]]);
        }

        return redirect()->route('admin.cliente.show', ['cliente' => $cliente->id])->with([
                'flash_message' => 'Cliente agregado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->back()->withInput()->with([
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
      $this->authorize('view', $cliente);
      $vehiculos = $cliente->vehiculos()->with(['marca', 'modelo'])->get();
      $procesos = $cliente->procesos;

      return view('admin.cliente.show', compact('cliente', 'vehiculos', 'procesos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
      $this->authorize('update', $cliente);
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
      $this->authorize('update', $cliente);
      $this->validate($request, [
        'nombres' => 'required|string|max:50',
        'apellidos' => 'nullable|string|max:50',
        'rut' => 'required|regex:/^(\d{4,9}-[\dk])$/|unique:clientes,rut,' . $cliente->id . ',id',
        'email' => 'required|email|unique:users,email,' . $cliente->user_id . ',id',
        'telefono' => 'required|string|max:15',
        'direccion' => 'nullable|string|max:150',
      ]);

      $cliente->fill($request->only(['rut', 'telefono', 'direccion']));
      $cliente->user->fill($request->only(['nombres', 'apellidos', 'email']));

      if($cliente->push()){
        return redirect()->route('admin.cliente.show', ['cliente' => $cliente->id])->with([
                'flash_message' => 'Cliente modificado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->back()->withInput()->with([
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
      $this->authorize('delete', $cliente);

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

    /**
     * Obtener los Vehiculos del Cliente especificado
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function vehiculos(Cliente $cliente)
    {
      $this->authorize('view', $cliente);
      return response()->json($cliente->vehiculos()->with(['marca', 'modelo', 'anio'])->get());
    }
}
