<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\{Auth, Storage};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Inspeccion, Proceso};
use PDF;

class InspeccionController extends Controller
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
     * @param  \App\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function create(Proceso $proceso)
    {
      $this->authorize('create', [Inspeccion::class, $proceso]);

      return view('admin.inspeccion.create', compact('proceso'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Proceso $proceso)
    {
      $this->authorize('create', [Inspeccion::class, $proceso]);
      $this->validate($request, [
        'fotos' => 'nullable|max:6',
        'fotos.*' => 'nullable|image|max:12000|mimes:jpeg,jpg,png',
        'combustible' => 'string',
      ]);

      $inspeccion = new Inspeccion([
                    'taller' => AUth::id(),
                    'combustible' => $request->combustible,
                    'observacion' => $request->observacion,
                    ]);

      foreach($inspeccion->getFillable() as $attribute) {
        if(!in_array($attribute, ['taller', 'combustible', 'observacion'])){
          $inspeccion->{$attribute} = $request->has($attribute) ? ($request->{$attribute} == 'on') : false;
        }
      }

      if($proceso->inspeccion()->save($inspeccion)){
        if($request->hasFile('fotos')){
          $directory = Auth::id().'/procesos/'.$proceso->id.'/inspeccion';
          if(!Storage::exists($directory)){
            Storage::makeDirectory($directory);
          }

          $fotos = [];

          foreach ($request->file('fotos') as $foto) {
            $fotos[] = [
              'taller' => Auth::id(),
              'foto' => $foto->store($directory),
            ];
          }

          $inspeccion->fotos()->createMany($fotos);
        }

        // Enviar email al Cliente para que evalue la Inspeccion
        $inspeccion->sendEmailStatusRequest();

        return redirect()->route('admin.proceso.show', ['proceso' => $proceso->id])->with([
                'flash_message' => 'Inspección de recepción agregada exitosamente. Se ha enviado una notificación al Cliente para su aprobación.',
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
     * @param  \App\Inspeccion  $inspeccion
     * @return \Illuminate\Http\Response
     */
    public function show(Inspeccion $inspeccion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inspeccion  $inspeccion
     * @return \Illuminate\Http\Response
     */
    public function edit(Inspeccion $inspeccion)
    {
      $this->authorize('update', $inspeccion);

      return view('admin.inspeccion.edit', compact('inspeccion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inspeccion  $inspeccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inspeccion $inspeccion)
    {
      $this->authorize('update', $inspeccion);
      $this->validate($request, [
        'fotos' => 'nullable|max:'.(6 - $inspeccion->fotos->count()),
        'fotos.*' => 'nullable|image|max:12000|mimes:jpeg,jpg,png',
        'combustible' => 'string',
      ]);

      $inspeccion->fill($request->only(['combustible', 'observacion']));

      if(!$inspeccion->isPending()){
        $inspeccion->aprobado = null;
      }

      foreach($inspeccion->getFillable() as $attribute) {
        if(!in_array($attribute, ['taller', 'combustible', 'observacion'])){
          $inspeccion->{$attribute} = $request->has($attribute) ? ($request->{$attribute} == 'on') : false;
        }
      }

      if($inspeccion->save()){
        if($request->hasFile('fotos')){
          $directory = Auth::id().'/procesos/'.$inspeccion->proceso_id.'/inspeccion/';
          if(!Storage::exists($directory)){
            Storage::makeDirectory($directory);
          }

          $fotos = [];

          foreach ($request->file('fotos') as $foto) {
            $fotos[] = [
              'taller' => Auth::id(),
              'foto' => $foto->store($directory),
            ];
          }

          $inspeccion->fotos()->createMany($fotos);
        }

        // Enviar email al Cliente para que evalue la Inspeccion
        $inspeccion->sendEmailStatusRequest();

        return redirect()->route('admin.proceso.show', ['proceso' => $inspeccion->proceso_id])->with([
                'flash_message' => 'Inspección de recepción modificada exitosamente. Se ha enviado una notificación al Cliente para su aprobación.',
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
     * @param  \App\Inspeccion  $inspeccion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inspeccion $inspeccion)
    {
        //
    }

    /**
     * Descargar PDF
     *
     * @param  \App\Inspeccion  $inspeccion
     * @return \Illuminate\Http\Response
     */
    public function pdf(Inspeccion $inspeccion)
    {
      $pdf = PDF::loadView('admin.inspeccion.pdf', compact('inspeccion'));

      return $pdf->download('Hoja de inspección.pdf');
    }
}
