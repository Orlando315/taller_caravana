<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\InsumoFormato;

class InsumosFormatosControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('index', InsumoFormato::class);

      $formatos = InsumoFormato::withCount('insumos')->get();

      return view('admin.formatos.index', compact('formatos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', InsumoFormato::class);

      return view('admin.formatos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create', InsumoFormato::class);

      $this->validate($request, [
        'formato' => 'required|string|max:50',
      ]);

      $formato = new InsumoFormato($request->only('formato'));
      $formato->user_id = Auth::user()->user_id ?? Auth::user()->id;
      $formato->added_by = Auth::id();

      if($formato->save()){
        if($request->ajax()){
          return response()->json(['response' => true, 'option' => ['id' => $formato->id, 'option' => $formato->formato]]);
        }

        return redirect()->route('admin.formatos.show', ['formato' => $formato->id])->with([
                'flash_message' => 'Formato agregado exitosamente.',
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
     * @param  \App\InsumoFormato  $formato
     * @return \Illuminate\Http\Response
     */
    public function show(InsumoFormato $formato)
    {
      $this->authorize('view', $formato);

      $insumos = $formato->insumos;

      return view('admin.formatos.show', compact('formato', 'insumos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InsumoFormato  $formato
     * @return \Illuminate\Http\Response
     */
    public function edit(InsumoFormato $formato)
    {
      $this->authorize('update', $formato);

      return view('admin.formatos.edit', compact('formato'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InsumoFormato  $formato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InsumoFormato $formato)
    {
      $this->authorize('update', $formato);

      $this->validate($request, [
        'formato' => 'required|string|max:50',
      ]);

      $formato->formato = $request->formato;

      if($formato->save()){
        return redirect()->route('admin.formatos.show', ['formato' => $formato->id])->with([
                'flash_message' => 'Formato modificado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.formatos.edit', ['formato' => $formato->id])->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InsumoFormato  $formato
     * @return \Illuminate\Http\Response
     */
    public function destroy(InsumoFormato $formato)
    {
      $this->authorize('delete', $formato);

      if($formato->insumos->count() > 0){
        return redirect()->route('admin.formatos.show', ['formato' => $formato->id])->with([
                'flash_class'     => 'alert-danger',
                'flash_message'   => 'Este Formato ya tiene Insumos agregados.',
                'flash_important' => true
              ]);
      }

      if($formato->delete()){
        return redirect()->route('admin.formatos.index')->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Formato eliminado exitosamente.'
              ]);
      }

      return redirect()->route('admin.formatos.show', ['formato' => $seccion->id])->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
