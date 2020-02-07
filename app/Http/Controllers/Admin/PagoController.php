<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Pago, Cotizacion};

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $pagos = Pago::all();

      return view('admin.pago.index', compact('pagos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function create(Cotizacion $cotizacion)
    {
      $this->authorize('create', [Pago::class, $cotizacion]);

      return view('admin.pago.create', compact('cotizacion'));
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
      $this->authorize('create', [Pago::class, $cotizacion]);
      $this->validate($request, [
        'pago' => 'required|numeric|min:1|max:'.$cotizacion->porPagar(),
      ]);

      $pago = new Pago([
        'taller' => Auth::id(),
        'proceso_id' => $cotizacion->situacion->proceso_id,
        'pago' => $request->pago,
      ]);

      if($cotizacion->pagos()->save($pago)){
        $cotizacion->refresh();
        if($cotizacion->porPagar() <= 0){
          $cotizacion->status = true;
          $cotizacion->save();
        }

        if($cotizacion->situacion->proceso->pagado() >= $cotizacion->situacion->proceso->total()){
          $cotizacion->situacion->proceso->status = true;
          $cotizacion->push();
        }

        return redirect()->route('admin.cotizacion.show',['cotizacion' => $cotizacion->id])->with([
                'flash_message' => 'Pago agregado exitosamente.',
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
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function show(Pago $pago)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function edit(Pago $pago)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pago $pago)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pago $pago)
    {
      if($pago->delete()){
        return redirect()->route('admin.cotizacion.show', ['cotizacion' => $pago->cotizacion_id])->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Pago eliminado exitosamente.'
              ]);
      }

      return redirect()->back()->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
