<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Storage};
use App\{Repuesto, RepuestoExtra, VehiculosMarca, VehiculosModelo};

class RepuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('index', Repuesto::class);

      $repuestos = Repuesto::with('extra')->get();

      return view('admin.repuesto.index', compact('repuestos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', Repuesto::class);

      $marcas = VehiculosMarca::with('modelos')->get();

      return view('admin.repuesto.create', compact('marcas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create', Repuesto::class);
      $this->validate($request, [
        'nro_parte' => 'required|string|max:50',
        'nro_oem' => 'required|string|max:50',
        'marca_oem' => 'required|string|max:50',
        'año' => 'required|integer',
        'modelo' => 'required',
        'motor' => 'required|string|max:50',
        'sistema' => 'required|string|max:50',
        'componente' => 'required|string|max:50',
        'foto' => 'nullable|image|max:12000|mimes:jpeg,jpg,png',
        'procedencia' => 'required|in:local,nacional,internacional',
        'envio' => 'nullable|numeric|min:0|max:99999999',
        'aduana' => 'nullable|numeric|min:0|max:99999999',
        'costo' => 'nullable|numeric|min:0|max:99999999',
        'envio1' => 'nullable|numeric|min:0|max:99999999',
        'envio2' => 'nullable|numeric|min:0|max:99999999',
        'casilla' => 'nullable|numeric|min:0|max:99999999',
        'impuestos' => 'nullable|numeric|min:0|max:99999999',
        'generales' => 'nullable|numeric|min:0|max:99999999',
        'tramitacion' => 'nullable|numeric|min:0|max:99999999',
        'moneda' => 'nullable|numeric|min:0|max:99999999',
      ]);

      $modelo = VehiculosModelo::findOrFail($request->modelo);

      $repuesto = new Repuesto($request->all());
      $repuesto->anio = $request->input('año');
      $repuesto->vehiculo_modelo_id = $modelo->id;
      $repuesto->vehiculo_marca_id = $modelo->vehiculo_marca_id;
      
      $extra = new RepuestoExtra($request->all());

      if(Auth::user()->repuestos()->save($repuesto)){
        $directory = $repuesto->taller.'/repuestos/'.$repuesto->id;
        if(!Storage::exists($directory)){
          Storage::makeDirectory($directory);
        }

        if($request->hasFile('foto')){
          $repuesto->foto = $request->foto->store($directory);
          $repuesto->save();
        }

        // Guardar extras
        $repuesto->extra()->save($extra);

        return redirect()->route('admin.repuesto.show', ['repuesto' => $repuesto->id])->with([
                'flash_message' => 'Repuesto agregado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->route('admin.repuesto.create')->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Repuesto  $repuesto
     * @return \Illuminate\Http\Response
     */
    public function show(Repuesto $repuesto)
    {
      $this->authorize('view', $repuesto);

      return view('admin.repuesto.show', compact('repuesto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Repuesto  $repuesto
     * @return \Illuminate\Http\Response
     */
    public function edit(Repuesto $repuesto)
    {
      $this->authorize('update', $repuesto);

      $repuesto->load('extra');
      $marcas = VehiculosMarca::with('modelos')->get();

      return view('admin.repuesto.edit', compact('repuesto', 'marcas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Repuesto  $repuesto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Repuesto $repuesto)
    {
      $this->authorize('update', $repuesto);
      $this->validate($request, [
        'nro_parte' => 'required|string|max:50',
        'nro_oem' => 'required|string|max:50',
        'marca_oem' => 'required|string|max:50',
        'año' => 'required|integer',
        'modelo' => 'required',
        'motor' => 'required|string|max:50',
        'sistema' => 'required|string|max:50',
        'componente' => 'required|string|max:50',
        'foto' => 'nullable|image|max:12000|mimes:jpeg,jpg,png',
        'procedencia' => 'required|in:local,nacional,internacional',
        'envio' => 'nullable|numeric|min:0|max:99999999',
        'aduana' => 'nullable|numeric|min:0|max:99999999',
        'costo' => 'nullable|numeric|min:0|max:99999999',
        'envio1' => 'nullable|numeric|min:0|max:99999999',
        'envio2' => 'nullable|numeric|min:0|max:99999999',
        'casilla' => 'nullable|numeric|min:0|max:99999999',
        'impuestos' => 'nullable|numeric|min:0|max:99999999',
        'generales' => 'nullable|numeric|min:0|max:99999999',
        'tramitacion' => 'nullable|numeric|min:0|max:99999999',
        'moneda' => 'nullable|numeric|min:0|max:99999999',
      ]);

      $modelo = VehiculosModelo::findOrFail($request->modelo);

      $repuesto->fill($request->all());
      $repuesto->anio = $request->input('año');
      $repuesto->vehiculo_modelo_id = $modelo->id;
      $repuesto->vehiculo_marca_id = $modelo->vehiculo_marca_id;
      
      $repuesto->extra->fill($request->all());

      if($repuesto->push()){
        $directory = $repuesto->taller.'/repuestos/'.$repuesto->id;
        if(!Storage::exists($directory)){
          Storage::makeDirectory($directory);
        }

        if($request->hasFile('foto')){
          $foto = $repuesto->foto;
          $repuesto->foto = $request->foto->store($directory);
          if($repuesto->save()){
            Storage::delete($foto);
          }
        }

        return redirect()->route('admin.repuesto.show', ['repuesto' => $repuesto->id])->with([
                'flash_message' => 'Repuesto modificado exitosamente.',
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
     * @param  \App\Repuesto  $repuesto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Repuesto $repuesto)
    {
      $this->authorize('delete', $repuesto);
      if($repuesto->delete()){
          if($repuesto->foto){
            Storage::delete($repuesto->foto);
          }

          return redirect()->route('admin.repuesto.index')->with([
                  'flash_class'   => 'alert-success',
                  'flash_message' => 'Repuesto eliminado exitosamente.'
                ]);
      }

      return redirect()->back()->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
