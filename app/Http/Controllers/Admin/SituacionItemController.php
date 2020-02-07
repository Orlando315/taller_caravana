<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SituacionItem;

class SituacionItemController extends Controller
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Situacion  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(SituacionItem $item)
    {
      if($item->status){
        return redirect()->back()->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Este Item ya se encuentra en una cotización',
              'flash_important' => true
            ]);
      }

      if($item->delete()){
        return redirect()->route('admin.proceso.show', ['proceso' => $item->situacion->proceso_id])->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Item eliminado exitosamente.'
              ]);
      }

      return redirect()->back()->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
