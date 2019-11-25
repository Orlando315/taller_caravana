<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Insumo;
use App\InsumoTipo;
use App\InsumoFormato;

class InsumosControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('index', Insumo::class);

      $insumos = Insumo::with(['tipo', 'formato'])->get();

      return view('insumos.index', compact('insumos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', Insumo::class);

      $tipos = InsumoTipo::all();
      $formatos = InsumoFormato::all();

      return view('insumos.create', compact('tipos', 'formatos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create', Insumo::class);

      $this->validate($request, [
        'nombre' => 'required|string|max:50',
        'marca' => 'required|string|max:50',
        'grado' => 'required|alpha_num|max:50',
        'tipo' => 'required',
        'formato' => 'required',
        'foto' => 'required|file|mimes:jpeg,jpg,png',
        'descripcion' => 'required|string|max:255',
        'factura' => 'required|integer',
        'foto_factura' => 'required|file|mimes:jpeg,jpg,png',
        'coste' => 'required|integer|min:1|max:9999999999',
        'venta' => 'required|integer|min:1|max:9999999999',
      ]);

      $tipo = InsumoTipo::findOrFail($request->tipo);
      $formato = InsumoFormato::findOrFail($request->formato);

      $insumo = new Insumo($request->all());
      $insumo->user_id = Auth::user()->user_id ?? Auth::user()->id;
      $insumo->added_by = Auth::id();
      $insumo->tipo_id = $tipo->id;
      $insumo->formato_id = $formato->id;

      if($insumo->save()){
        $insumo->stock()->create([]);

        $directory = $insumo->user_id.'/'.$insumo->id;
        if(!Storage::exists($directory)){
          Storage::makeDirectory($directory);
        }
        $insumo->foto = $request->foto->store($directory);
        $insumo->foto_factura = $request->foto_factura->store($directory);
        $insumo->save();

        return redirect()->route('insumos.show', ['insumo' => $insumo->id])->with([
                'flash_message' => 'Insumo agregado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }else{
        return redirect()->route('insumos.create', ['insumo' => $request->role])->withInput()->with([
                'flash_message' => 'Ha ocurrido un error.',
                'flash_class' => 'alert-danger',
                'flash_important' => true
              ]);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Insumo  $insumo
     * @return \Illuminate\Http\Response
     */
    public function show(Insumo $insumo)
    {
      $this->authorize('view', $insumo);

      $insumos = $insumo->insumos;

      if(!$insumo->stock){
        $insumo->stock()->create([]);
        $insumo->load('stock');
      }

      return view('insumos.show', compact('insumo', 'insumos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Insumo  $insumo
     * @return \Illuminate\Http\Response
     */
    public function edit(Insumo $insumo)
    {
      $this->authorize('update', $insumo);

      $tipos = InsumoTipo::all();
      $formatos = InsumoFormato::all();

      return view('insumos.edit', compact('insumo', 'tipos', 'formatos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Insumo  $insumo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Insumo $insumo)
    {
      $this->authorize('update', $insumo);

      $this->validate($request, [
        'nombre' => 'required|string|max:50',
        'marca' => 'required|string|max:50',
        'grado' => 'required|alpha_num|max:50',
        'tipo' => 'required',
        'formato' => 'required',
        'foto' => 'nullable|file|mimes:jpeg,jpg,png',
        'descripcion' => 'required|string|max:255',
        'factura' => 'required|integer',
        'foto_factura' => 'nullable|file|mimes:jpeg,jpg,png',
        'coste' => 'required|numeric|min:1|max:9999999999',
        'venta' => 'required|numeric|min:1|max:9999999999',
      ]);

      $tipo = InsumoTipo::findOrFail($request->tipo);
      $formato = InsumoFormato::findOrFail($request->formato);

      $insumo = $insumo->fill($request->all());
      $insumo->tipo_id = $tipo->id;
      $insumo->formato_id = $formato->id;

      if($insumo->save()){
        if(!$insumo->stock){
          $insumo->stock()->create([]);
        }

        $directory = $insumo->user_id.'/'.$insumo->id;
        if(!Storage::exists($directory)){
          Storage::makeDirectory($directory);
        }

        if($request->has('foto')){
          Storage::delete($insumo->foto);
          $insumo->foto = $request->foto->store($directory); 
        }

        if($request->has('foto_factura')){
          Storage::delete($insumo->foto_factura);
          $insumo->foto_factura = $request->foto_factura->store($directory);
        }

        if($request->has('foto') || $request->has('foto_factura')){
          $insumo->save(); 
        }

        return redirect()->route('insumos.show', ['insumo' => $insumo->id])->with([
                'flash_message' => 'Insumo modificado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }else{
        return redirect()->route('insumos.edit', ['insumo' => $insumo->id])->withInput()->with([
                'flash_message' => 'Ha ocurrido un error.',
                'flash_class' => 'alert-danger',
                'flash_important' => true
              ]);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Insumo  $insumo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Insumo $insumo)
    {
      $this->authorize('delete', $insumo);

      if($insumo->delete()){
        $directory = $insumo->user_id.'/'.$insumo->id;

        if(Storage::exists($directory)){
          Storage::deleteDirectory($directory);
        }

        return redirect()->route('insumos.index')->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Insumo eliminado exitosamente.'
              ]);
      }else{
        return redirect()->route('insumos.show', ['seccion' => $seccion->id])->with([
                'flash_class'     => 'alert-danger',
                'flash_message'   => 'Ha ocurrido un error.',
                'flash_important' => true
              ]);
      }
    }
}
