<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\InspeccionFoto;

class InspeccionFotoController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InspeccionFoto  $inspeccionFoto
     * @return \Illuminate\Http\Response
     */
    public function show(InspeccionFoto $inspeccionFoto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InspeccionFoto  $inspeccionFoto
     * @return \Illuminate\Http\Response
     */
    public function edit(InspeccionFoto $inspeccionFoto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InspeccionFoto  $inspeccionFoto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InspeccionFoto $inspeccionFoto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InspeccionFoto  $inspeccionFoto
     * @return \Illuminate\Http\Response
     */
    public function destroy(InspeccionFoto $foto)
    {
      $this->authorize('delete_photo', $foto->inspeccion);

      if($foto->delete()){
        Storage::delete($foto->foto);

        return redirect()->route('admin.proceso.show', ['proceso' => $foto->inspeccion->proceso_id])->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Foto eliminada exitosamente.'
              ]);
      }

      return redirect()->back()->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
