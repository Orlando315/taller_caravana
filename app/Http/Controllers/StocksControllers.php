<?php

namespace App\Http\Controllers;

use App\Stock;
use Illuminate\Http\Request;

class StocksControllers extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
      $this->authorize('update', $stock->insumo);

      return view('stocks.edit', compact('stock'));
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
        'stock' => 'required|integer|min:0|max:99999999',
        'minimo' => 'nullable|integer|min:0|max:99999999',
      ]);

      $stock->stock = $request->stock;
      $stock->minimo = $request->minimo;

      if($stock->save()){
        return redirect()->route('insumos.show', ['insumo' => $stock->insumo->id])->with([
                'flash_message' => 'Stock modificado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }else{
        return redirect()->route('stocks.edit', ['stock' => $stock->id])->withInput()->with([
                'flash_message' => 'Ha ocurrido un error.',
                'flash_class' => 'alert-danger',
                'flash_important' => true
              ]);
      }
    }
}
