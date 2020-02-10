<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{Stock, Insumo, Proveedor};

class StocksControllers extends Controller
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
     * @param  \App\Insumo  $insumo
     * @return \Illuminate\Http\Response
     */
    public function create(Insumo $insumo)
    {
      $this->authorize('create', Insumo::class);

      $proveedores = Proveedor::all();

      return view('admin.insumos.stock.create', compact('insumo', 'proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Insumo  $insumo
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Insumo $insumo)
    {
      $this->authorize('create', Insumo::class);

      $this->validate($request, [
        'proveedor' => 'required|',
        'coste' => 'required|numeric|min:0||max:99999999',
        'venta' => 'required|numeric|min:0||max:99999999|gt:coste',
        'stock' => 'nullable|integer|min:0|max:99999999',
      ]);

      $stock = new Stock($request->only(['coste', 'venta', 'stock']));
      $stock->proveedor_id = $request->proveedor;

      if($insumo->stocks()->save($stock)){
        return redirect()->route('admin.insumos.show', ['insumo' => $insumo->id])->with([
                'flash_message' => 'Stock agregado exitosamente.',
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
      $this->authorize('update', $stock->insumo);

      return view('admin.insumos.stock.edit', compact('stock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
      $this->authorize('update', $stock->insumo);

      $this->validate($request, [
        'coste' => 'required|numeric|min:0||max:99999999',
        'venta' => 'required|numeric|min:0||max:99999999|gt:coste',
        'stock' => 'nullable|integer|min:0|max:99999999',
      ]);

      $stock->fill($request->only(['coste', 'venta', 'stock']));

      if($stock->save()){
        return redirect()->route('admin.insumos.show', ['insumo' => $stock->insumo_id])->with([
                'flash_message' => 'Stock modificado exitosamente.',
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
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
      $this->authorize('update', $stock->insumo);

      if($stock->delete()){
          return redirect()->back()->with([
                  'flash_class'   => 'alert-success',
                  'flash_message' => 'Stock eliminado exitosamente.'
                ]);
      }

      return redirect()->back()->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
