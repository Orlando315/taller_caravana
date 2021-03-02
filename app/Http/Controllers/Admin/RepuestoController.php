<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Storage};
use App\{Repuesto, RepuestoExtra, VehiculosMarca, VehiculosModelo};
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RepuestoImport;

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
      
      $clone = Repuesto::find(request()->clone);
      if($clone){
        $this->authorize('view', $clone); 
      }

      $marcas = VehiculosMarca::marcasToArray();

      return view('admin.repuesto.create', compact('marcas', 'clone'));
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

      if(!is_array($request->producto)){
        $request->replace($request->only('_token', '_method') + ['repuesto' => [$request->all()]]); 
      }

      $this->validate($request, [
        'repuesto' => 'required|min:1|max:10',
        'repuesto.*.modelo' => 'required',
        'repuesto.*.año' => 'required|integer',
        'repuesto.*.motor' => 'required|integer|min:0|max:9999',
        'repuesto.*.sistema' => 'required|string|max:50',
        'repuesto.*.componente' => 'required|string|max:50',
        'repuesto.*.nro_parte' => 'nullable|string|max:50',
        'repuesto.*.nro_oem' => 'nullable|string|max:50',
        'repuesto.*.marca_oem' => 'required|string|max:50',
        'repuesto.*.foto' => 'nullable|image|max:3000|mimes:jpeg,jpg,png',
        'repuesto.*.stock' => 'nullable|integer|min:0|max:9999',
        'repuesto.*.procedencia' => 'required|in:local,nacional,internacional',
        'repuesto.*.moneda' => 'nullable|in:peso,dolar,euro',
        'repuesto.*.moneda_valor' => 'nullable|numeric|min:0|max:99999999',
        'repuesto.*.costo' => 'nullable|numeric|min:0|max:99999999',
        'repuesto.*.generales' => 'nullable|numeric|min:0|max:99999999',
        'repuesto.*.generales_total' => 'nullable|numeric|min:0|max:99999999',
        'repuesto.*.venta' => 'required|numeric|min:0|max:99999999',
        'repuesto.*.envio' => 'nullable|numeric|min:0|max:99999999',
        'repuesto.*.envio1' => 'nullable|numeric|min:0|max:99999999',
        'repuesto.*.envio2' => 'nullable|numeric|min:0|max:99999999',
        'repuesto.*.casilla' => 'nullable|numeric|min:0|max:99999999',
        'repuesto.*.impuestos' => 'nullable|numeric|min:0|max:99999999',
        'repuesto.*.impuestos_total' => 'nullable|numeric|min:0|max:99999999',
        'repuesto.*.tramitacion' => 'nullable|numeric|min:0|max:99999999',
        'repuesto.*.comentarios' => 'nullable|string|max:250',
      ]);

      $total = count($request->repuesto);
      $lastRepueto = null;

      foreach ($request->repuesto as $key => $requestRepuesto){
        $repuesto = new Repuesto([
          'vehiculo_marca_id' => $requestRepuesto['marca'],
          'vehiculo_modelo_id' => $requestRepuesto['modelo'],
          'stock' => $requestRepuesto['stock'] ?? 0,
          'nro_parte' => $requestRepuesto['nro_parte'],
          'nro_oem' => $requestRepuesto['nro_oem'],
          'marca_oem' => $requestRepuesto['marca_oem'],
          'anio' => $requestRepuesto['año'],
          'motor' => $requestRepuesto['motor'],
          'sistema' => $requestRepuesto['sistema'],
          'componente' => $requestRepuesto['componente'],
          'procedencia' => $requestRepuesto['procedencia'],
          'venta' => $requestRepuesto['venta'],
          'envio' => $requestRepuesto['envio'] ?? null,
          'comentarios' => $requestRepuesto['comentarios'],
        ]);
        
        $extra = new RepuestoExtra([
          'costo' => $requestRepuesto['costo'],
          'envio1' => $requestRepuesto['envio1'] ?? null,
          'envio2' => $requestRepuesto['envio2'] ?? null,
          'casilla' => $requestRepuesto['casilla'] ?? null,
          'impuestos' => $requestRepuesto['impuestos'] ?? null,
          'impuestos_total' => $requestRepuesto['impuestos_total'] ?? null,
          'generales' => $requestRepuesto['generales'],
          'generales_total' => $requestRepuesto['generales_total'] ?? null,
          'tramitacion' => $requestRepuesto['tramitacion'] ?? null,
          'moneda' => $requestRepuesto['moneda'],
          'moneda_valor' => $requestRepuesto['moneda_valor'] ?? null,
        ]);

        if($lastRepuesto = Auth::user()->repuestos()->save($repuesto)){
          $directory = $repuesto->taller.'/repuestos/'.$repuesto->id;
          if(!Storage::exists($directory)){
            Storage::makeDirectory($directory);
          }

          if($request->hasFile('repuesto.'.$key.'.foto')){
            $repuesto->foto = $requestRepuesto['foto']->store($directory);
            $repuesto->save();
          }

          // Guardar extras
          $repuesto->extra()->save($extra);
          $repuesto->calculateCostoTotal();
          $repuesto->push();
        }
      }

      if($request->ajax() && $total == 1){
        return response()
                ->json([
                  'response' =>  true,
                  'repuesto' => [
                    'id' => $lastRepuesto->id,
                    'descripcion' => $lastRepuesto->descripcion(),
                    'venta' => $lastRepuesto->venta,
                    'costo' => $lastRepuesto->extra->costo_total,
                    'stock' => $lastRepuesto->stock,
                    'anio' => $lastRepuesto->anio,
                    'sistema' => $lastRepuesto->sistema,
                    'componente' => $lastRepuesto->componente,
                  ]
                ]);
      }

      $route = $total == 1 ? route('admin.repuesto.show', ['repuesto' => $lastRepuesto->id]) : route('admin.repuesto.index');
      $message = $total == 1 ? 'Repuesto agregado exitosamente.' : 'Repuestos agregados exitosamente.';

      return redirect($route)->with([
              'flash_message' => $message,
              'flash_class' => 'alert-success'
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
        'modelo' => 'required',
        'año' => 'required|integer',
        'motor' => 'required|integer|min:0|max:9999',
        'sistema' => 'required|string|max:50',
        'componente' => 'required|string|max:50',
        'nro_parte' => 'nullable|string|max:50',
        'nro_oem' => 'nullable|string|max:50',
        'marca_oem' => 'required|string|max:50',
        'foto' => 'nullable|image|max:3000|mimes:jpeg,jpg,png',
        'stock' => 'nullable|integer|min:0|max:9999',
        'procedencia' => 'required|in:local,nacional,internacional',
        'moneda' => 'nullable|in:peso,dolar,euro',
        'moneda_valor' => 'nullable|numeric|min:0|max:99999999',
        'costo' => 'nullable|numeric|min:0|max:99999999',
        'generales' => 'nullable|numeric|min:0|max:99999999',
        'generales_total' => 'nullable|numeric|min:0|max:99999999',
        'venta' => 'required|numeric|min:0|max:99999999',
        'envio' => 'nullable|numeric|min:0|max:99999999',
        'envio1' => 'nullable|numeric|min:0|max:99999999',
        'envio2' => 'nullable|numeric|min:0|max:99999999',
        'casilla' => 'nullable|numeric|min:0|max:99999999',
        'impuestos' => 'nullable|numeric|min:0|max:99999999',
        'impuestos_total' => 'nullable|numeric|min:0|max:99999999',
        'tramitacion' => 'nullable|numeric|min:0|max:99999999',
        'comentarios' => 'nullable|string|max:250',
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

        $repuesto->calculateCostoTotal();
        $repuesto->push();

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

    /**
     * Buscar repuestos con los parametros especificados
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
      $repuestos = Repuesto::where('vehiculo_modelo_id', $request->modelo)
      ->when($request->sistema, function ($query, $sistema){
        return $query->where('sistema', $sistema);
      })
      ->when($request->componente, function ($query, $componente){
        return $query->where('componente', $componente);
      })
      ->when($request->anio, function ($query, $anio){
        return $query->where('anio', $anio);
      })
      ->when($request->motor, function ($query, $motor){
        return $query->where('motor', $motor);
      })
      ->with('extra')
      ->get()
      ->map(function ($repuesto, $key) {
        return [
                'id' => $repuesto->id,
                'descripcion' => $repuesto->descripcion(),
                'venta' => $repuesto->venta,
                'costo' => $repuesto->extra->costo_total,
                'stock' => $repuesto->stock,
                'anio' => $repuesto->anio,
                'sistema' => $repuesto->sistema,
                'componente' => $repuesto->componente,
              ];
      });

      return response()->json($repuestos);
    }

    /**
     * Formulario para cargar los Repuestos por excel
     *
     * @return \Illuminate\Http\Response
     */
    public function masivo()
    {
      $this->authorize('create', Repuesto::class);
      $marcas = VehiculosMarca::marcasToArray();

      return view('admin.repuesto.masivo', compact('marcas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMasivo(Request $request)
    {
      $this->authorize('create', Repuesto::class);
      $this->validate($request, [
        'archivo' => 'required|file|mimes:xlsx,xls',
      ]);

      $import = new RepuestoImport;
      try{
        Excel::import($import, $request->archivo);
        $importRepuestos = $import->getData();
        $importConst = $import->getConst();
      }catch(\Exception $e){
        return redirect()->back()->with([
                'flash_message' => 'Ha ocurrido un error al cargar el archivo. Revise el formato utilizado.',
                'flash_class' => 'alert-danger',
                'flash_important' => true
              ]);
      }

      foreach($importRepuestos as $key => $dataRepuesto){
        $repuesto = new Repuesto([
          'taller',
          'vehiculo_marca_id' => $request->repuesto['marca'][$key],
          'vehiculo_modelo_id' => $request->repuesto['modelo'][$key],
          'stock' => $dataRepuesto['cantidad'],
          'componente' => $dataRepuesto['descripcion'],
          'procedencia' => 'internacional',
          'venta' => $dataRepuesto['venta'],
        ]);
        
        $extra = new RepuestoExtra([
          'costo' => $dataRepuesto['precio'],
          'costo_total' => $dataRepuesto['costo_total'],
          'envio1' => $dataRepuesto['envio1'],
          'envio2' => $dataRepuesto['envio2'],
          'casilla' => 0,
          'impuestos' => 0,
          'impuestos_total' => $dataRepuesto['impuestos'],
          'generales' => 0,
          'generales_total' => $dataRepuesto['gasto_general'],
          'tramitacion' => 0,
          'moneda' => 'dolar',
          'moneda_valor' => $importConst['dolar'],
        ]);

        if(Auth::user()->repuestos()->save($repuesto)){
          $repuesto->extra()->save($extra);
        }
      }

      return redirect()->route('admin.repuesto.index')->with([
              'flash_message' => 'Repuestos agregados exitosamente.',
              'flash_class' => 'alert-success'
            ]);
    }

    /**
     * Formulario para cargar los Repuestos por excel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
      $import = new RepuestoImport;

      try{
        Excel::import($import, $request->archivo);

        return response()->json(['response' => !$import->hasError(), 'repuestos' => $import->getData()]);
      }catch(\Exception $e){
        $response = false;
        return response()->json(['response' => false]);
      }
    }


    /**
     * Actualizar stock al Repuesto especificado
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Repuesto  $repuesto
     * @return \Illuminate\Http\Response
     */
    public function stock(Request $request, Repuesto $repuesto)
    {
      $this->authorize('update', $repuesto);

      $this->validate($request, [
        'stock' => 'required|integer|min:0|max:9999',
      ]);

      $repuesto->stock = $request->type == '1' ? ($repuesto->stock + $request->stock) : $request->stock;

      if($repuesto->save()){
        return redirect()->back()->with([
                'flash_message' => 'Stock modificado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->back()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }
}
