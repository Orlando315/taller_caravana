<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Auth, Storage};
use Illuminate\Http\Request;
use App\{Insumo, InsumoTipo, InsumoFormato};

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
      $formatos = InsumoFormato::withCount('insumos')->get();
      $tipos = InsumoTipo::withCount('insumos')->get();

      return view('admin.insumos.index', compact('insumos', 'formatos', 'tipos'));
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

      return view('admin.insumos.create', compact('tipos', 'formatos'));
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
        'grado' => 'nullable|string|max:50',
        'tipo' => 'required',
        'formato' => 'required',
        'foto' => 'nullable|file|mimes:jpeg,jpg,png',
        'descripcion' => 'nullable|string|max:255',
        'minimo' => 'nullable|numeric|min:0|max:99999999',
      ]);

      $tipo = InsumoTipo::findOrFail($request->tipo);
      $formato = InsumoFormato::findOrFail($request->formato);

      $insumo = new Insumo($request->all());
      $insumo->user_id = Auth::user()->user_id ?? Auth::user()->id;
      $insumo->added_by = Auth::id();
      $insumo->tipo_id = $tipo->id;
      $insumo->formato_id = $formato->id;

      if($insumo->save()){
        $directory = $insumo->user_id.'/'.$insumo->id;
        if($request->hasFile('foto') && !Storage::exists($directory)){
          Storage::makeDirectory($directory);
        }

        if($request->hasFile('foto')){
          $insumo->foto = $request->foto->store($directory);
          $insumo->save();
        }

        return redirect()->route('admin.insumos.show', ['insumo' => $insumo->id])->with([
                'flash_message' => 'Insumo agregado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }else{
        return redirect()->route('admin.insumos.create', ['insumo' => $request->role])->withInput()->with([
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

      $stocks = $insumo->stocks()->with('proveedor')->get();
      $proveedores = $insumo->proveedores;

      return view('admin.insumos.show', compact('insumo', 'stocks', 'proveedores'));
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

      return view('admin.insumos.edit', compact('insumo', 'tipos', 'formatos'));
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
        'grado' => 'nullable|string|max:50',
        'tipo' => 'required',
        'formato' => 'required',
        'foto' => 'nullable|file|mimes:jpeg,jpg,png',
        'descripcion' => 'nullable|string|max:255',
        'minimo' => 'nullable|numeric|min:0|max:99999999',
      ]);

      $tipo = InsumoTipo::findOrFail($request->tipo);
      $formato = InsumoFormato::findOrFail($request->formato);

      $insumo = $insumo->fill($request->all());
      $insumo->tipo_id = $tipo->id;
      $insumo->formato_id = $formato->id;

      if($insumo->save()){
        $directory = $insumo->user_id.'/'.$insumo->id;
        if($request->hasFile('foto') && !Storage::exists($directory)){
          Storage::makeDirectory($directory);
        }

        if($request->has('foto')){
          Storage::delete($insumo->foto);
          $insumo->foto = $request->foto->store($directory);
          $insumo->save();
        }

        return redirect()->route('admin.insumos.show', ['insumo' => $insumo->id])->with([
                'flash_message' => 'Insumo modificado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.insumos.edit', ['insumo' => $insumo->id])->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
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

        return redirect()->route('admin.insumos.index')->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Insumo eliminado exitosamente.'
              ]);
      }else{
        return redirect()->route('admin.insumos.show', ['seccion' => $seccion->id])->with([
                'flash_class'     => 'alert-danger',
                'flash_message'   => 'Ha ocurrido un error.',
                'flash_important' => true
              ]);
      }
    }
}
