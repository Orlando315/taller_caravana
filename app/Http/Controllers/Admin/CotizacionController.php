<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\{Cotizacion, Situacion, SituacionItem};
use PDF;

class CotizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Situacion  $situacion
     * @return \Illuminate\Http\Response
     */
    public function create(Situacion $situacion)
    {
      $this->authorize('create', [Cotizacion::class, $situacion]);
      $items = $situacion->items;

      return view('admin.cotizacion.create', compact('situacion', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Situacion  $situacion
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Situacion $situacion)
    {
      $this->authorize('create', [Cotizacion::class, $situacion]);
      $this->validate($request, [
        'items.*' => 'min:1',
        'descripcion' => 'nullable|string|max:500',
      ]);

      $ids = [];

      foreach ($request->items as $item) {
        $ids[] = ['item_id' => $item];
      }

      $cotizacion = new Cotizacion([
                      'user_id' => Auth::id(),
                      'descripcion' => $request->descripcion,
                    ]);

      if($situacion->cotizaciones()->save($cotizacion)){
        if($cotizacion->items()->createMany($ids)){
          SituacionItem::whereIn('id', $request->items)
                      ->update([
                        'status' => true,
                      ]);
          $situacion->proceso->etapa = 5;
          $situacion->proceso->save();

          return redirect()->route('admin.cotizacion.show', ['cotizacion' => $cotizacion->id])->with([
                  'flash_message' => 'Cotización generada exitosamente.',
                  'flash_class' => 'alert-success'
                ]);
        }else{
          $cotizacion->delete();
        }
      }

      return redirect()->route('admin.cotizacion.create', ['situacion' => $situacion->id])->withInput()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function show(Cotizacion $cotizacion)
    {
      $this->authorize('view', $cotizacion);

      $pagos = $cotizacion->pagos;

      return view('admin.cotizacion.show', compact('cotizacion', 'pagos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Cotizacion $cotizacion)
    {
      $this->authorize('update', $cotizacion);

      return view('admin.cotizacion.edit', compact('cotizacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cotizacion $cotizacion)
    {
      $this->authorize('update', $cotizacion);
      $this->validate($request, [
        'descripcion' => 'nullable|string|max:500',
      ]);

      $cotizacion->descripcion = $request->descripcion;

      if($cotizacion->save()){
        return redirect()->route('admin.cotizacion.show', ['cotizacion' => $cotizacion->id])->with([
                'flash_message' => 'Cotización modificada exitosamente.',
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
     * @param  \App\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cotizacion $cotizacion)
    {
      $this->authorize('delete', $cotizacion);

      $ids = $cotizacion->items->pluck('item_id')->toArray();
      if($cotizacion->delete()){
        SituacionItem::whereIn('id', $ids)
                    ->update([
                      'status' => false,
                    ]);

        return redirect()->route('admin.proceso.show', ['proceso' => $cotizacion->situacion->proceso_id])->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Cotización eliminada exitosamente.'
              ]);
      }

      return redirect()->back()->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }

    /**
     * Descargar PDF
     *
     * @param  \App\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function pdf(Cotizacion $cotizacion)
    {
      $repuestos = $cotizacion->getItemsByType('repuesto')->get();
      $insumos = $cotizacion->getItemsByType('insumo')->get();
      $horas = $cotizacion->getItemsByType()->get();
      
      $pdf = PDF::loadView('admin.cotizacion.pdf', compact('cotizacion', 'repuestos', 'insumos', 'horas'));
      return $pdf->download('Cotización.pdf');
    }
}
