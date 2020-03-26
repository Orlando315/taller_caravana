<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Inspeccion;
use PDF;

class InspeccionController extends Controller
{

    /**
     * Cambiar el status de la Inspeccion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inspeccion  $inspeccion
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, Inspeccion $inspeccion)
    {
      $this->authorize('status', $inspeccion);
      $this->validate($request, [
        'estatus' => 'sometimes|in:aprobado,rechazado',
        'comentarios' => 'nullable|string|max:500',
      ]);

      if($inspeccion->isPending()){
        $inspeccion->aprobado = $request->estatus == 'aprobado'; 
      }
      $inspeccion->comentarios = $request->comentarios;

      if($inspeccion->save()){
        return redirect()->route('proceso.show', ['proceso' => $inspeccion->proceso_id])->with([
                'flash_message' => 'Estatus modificado exitosamente.',
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
     * Descargar PDF
     *
     * @param  \App\Inspeccion  $inspeccion
     * @return \Illuminate\Http\Response
     */
    public function pdf(Inspeccion $inspeccion)
    {
      $this->authorize('pdf', $inspeccion);
      $pdf = PDF::loadView('inspeccion.pdf', compact('inspeccion'));

      return $pdf->download('Hoja de inspección.pdf');
    }
}
