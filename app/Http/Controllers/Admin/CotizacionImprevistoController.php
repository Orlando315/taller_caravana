<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{CotizacionImprevisto, Cotizacion};

class CotizacionImprevistoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function create(Cotizacion $cotizacion)
    {
      $this->authorize('create', [CotizacionImprevisto::class, $cotizacion]);

      return view('admin.imprevisto.create', compact('cotizacion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Cotizacion $cotizacion)
    {
      $this->authorize('create', [CotizacionImprevisto::class, $cotizacion]);
      $this->validate($request, [
        'tipo' => 'required|string|in:horas,repuesto,insumo,terceros,otros',
        'descripcion' => 'required|string|max:500',
        'monto' => 'required|numeric|min:1|max:999999999',
      ]);

      $imprevisto = new CotizacionImprevisto($request->only(['tipo', 'descripcion', 'monto']));

      if($cotizacion->imprevistos()->save($imprevisto)){
        return redirect()->route('admin.cotizacion.show', ['cotizacion' => $cotizacion->id])->with([
                'flash_message' => 'Imprevisto agregado exitosamente.',
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
     * @param  \App\CotizacionImprevisto  $imprevisto
     * @return \Illuminate\Http\Response
     */
    public function show(CotizacionImprevisto $imprevisto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CotizacionImprevisto  $imprevisto
     * @return \Illuminate\Http\Response
     */
    public function edit(CotizacionImprevisto $imprevisto)
    {
      $this->authorize('update', $imprevisto);

      return view('admin.imprevisto.edit', compact('imprevisto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CotizacionImprevisto  $imprevisto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CotizacionImprevisto $imprevisto)
    {
      $this->authorize('update', $imprevisto);
      $this->validate($request, [
        'tipo' => 'required|string|in:horas,repuesto,insumo,terceros,otros',
        'descripcion' => 'required|string|max:500',
        'monto' => 'required|numeric|min:1|max:999999999',
      ]);

      $imprevisto->fill($request->only(['tipo', 'descripcion', 'monto']));

      if($imprevisto->save()){
        return redirect()->route('admin.cotizacion.show', ['cotizacion' => $imprevisto->cotizacion_id])->with([
                'flash_message' => 'Imprevisto modificado exitosamente.',
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
     * @param  \App\CotizacionImprevisto  $imprevisto
     * @return \Illuminate\Http\Response
     */
    public function destroy(CotizacionImprevisto $imprevisto)
    {
      $this->authorize('delete', $imprevisto);

      if($imprevisto->delete()){
        return redirect()->route('admin.cotizacion.show', ['cotizacion' => $imprevisto->cotizacion_id])->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Imprevisto eliminado exitosamente.'
              ]);
      }

      return redirect()->back()->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
