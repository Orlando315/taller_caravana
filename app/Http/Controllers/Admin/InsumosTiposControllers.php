<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\InsumoTipo;

class InsumosTiposControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('index', InsumoTipo::class);

      $tipos = InsumoTipo::withCount('insumos')->get();

      return view('admin.tipos.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', InsumoTipo::class);

      return view('admin.tipos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create', InsumoTipo::class);

      $this->validate($request, [
        'tipo' => 'required|string|max:50',
      ]);

      $tipo = new InsumoTipo($request->all());
      $tipo->user_id = Auth::user()->user_id ?? Auth::user()->id;
      $tipo->added_by = Auth::id();

      if($tipo->save()){
        if($request->ajax()){
          return response()->json(['response' => true, 'option' => ['id' => $tipo->id, 'option' => $tipo->tipo]]);
        }

        return redirect()->route('admin.tipos.show', ['tipo' => $tipo->id])->with([
                'flash_message' => 'Tipo agregado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      if($request->ajax()){
        return response()->json(['response' => false]);
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
     * @param  \App\InsumoTipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function show(InsumoTipo $tipo)
    {
      $this->authorize('view', $tipo);

      $insumos = $tipo->insumos;

      return view('admin.tipos.show', compact('tipo', 'insumos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InsumoTipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function edit(InsumoTipo $tipo)
    {
      $this->authorize('update', $tipo);

      return view('admin.tipos.edit', compact('tipo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InsumoTipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InsumoTipo $tipo)
    {
      $this->authorize('update', $tipo);

      $this->validate($request, [
        'tipo' => 'required|string|max:50',
      ]);

      $tipo->tipo = $request->tipo;

      if($tipo->save()){
        return redirect()->route('admin.tipos.show', ['tipo' => $tipo->id])->with([
                'flash_message' => 'Tipo modificado exitosamente.',
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
     * @param  \App\InsumoTipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function destroy(InsumoTipo $tipo)
    {
      $this->authorize('delete', $tipo);

      if($tipo->insumos->count() > 0){
        return redirect()->route('admin.tipos.show', ['tipo' => $tipo->id])->with([
                'flash_class'     => 'alert-danger',
                'flash_message'   => 'Este Tipo ya tiene Insumos agregados.',
                'flash_important' => true
              ]);
      }

      if($tipo->delete()){
        return redirect()->route('admin.inusmos.index')->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Tipo eliminado exitosamente.'
              ]);
      }

      return redirect()->back()->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
