<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\PreevaluacionFoto;

class PreevaluacionFotoController extends Controller
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
     * @param  \App\PreevaluacionFoto  $preevaluacionFoto
     * @return \Illuminate\Http\Response
     */
    public function show(PreevaluacionFoto $preevaluacionFoto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PreevaluacionFoto  $preevaluacionFoto
     * @return \Illuminate\Http\Response
     */
    public function edit(PreevaluacionFoto $preevaluacionFoto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PreevaluacionFoto  $preevaluacionFoto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PreevaluacionFoto $preevaluacionFoto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PreevaluacionFoto  $foto
     * @return \Illuminate\Http\Response
     */
    public function destroy(PreevaluacionFoto $foto)
    {
      if($foto->delete()){
        Storage::delete($foto->foto);

        return redirect()->route('admin.proceso.show', ['proceso' => $foto->proceso_id])->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Foto eliminada exitosamente.'
              ]);
      }

      return redirect()->route('admin.proceso.show', ['proceso' => $foto->proceso_id])->with([
              'flash_class'     => 'alert-danger',
              'flash_message'   => 'Ha ocurrido un error.',
              'flash_important' => true
            ]);
    }
}
