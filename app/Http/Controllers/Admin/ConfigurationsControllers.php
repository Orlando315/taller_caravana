<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Storage};
use App\Configuration;

class ConfigurationsControllers extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
      $this->authorize('update', Configuration::class);

      if(!Auth::user()->configuration){
        Auth::user()->configuration()->create([]);
      }

      $configuracion = Configuration::first();

      return view('admin.configurations.edit', compact('configuracion'));
    }

    /**
     * Actualizar el precio del dolar
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dolar(Request $request)
    {
      $this->authorize('update', Configuration::class);

      $this->validate($request, [
        'dolar' => 'nullable|numeric|min:0|max:999999999'
      ]);

      $configuration = Configuration::first();
      $configuration->dollar = $request->dolar;

      if($configuration->save()){
        return redirect()->back()->with([
                'flash_message' => 'Configuración modificada exitosamente.',
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
     * Actualizar el precio del dolar
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ganancia(Request $request)
    {
      $this->authorize('update', Configuration::class);
      $this->validate($request, [
        'ganancia' => 'nullable|numeric|min:0|max:100'
      ]);

      $configuration = Configuration::first();
      $configuration->ganancia = $request->ganancia;

      if($configuration->save()){
        return redirect()->back()->with([
                'flash_message' => 'Configuración modificada exitosamente.',
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
     * Actualizar foto de timbre (Usada en el footer de los pdf's)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function timbre(Request $request)
    {
      $this->authorize('update', Configuration::class);
      $this->validate($request, [
        'imagen' => 'required|image|mimes:jpeg,png,jpg|max:3000',
      ]);

      $configuration = Configuration::first();
      $directory = Auth::id().'/configuracion';
      $oldTimbre = $configuration->timbre;
      $configuration->timbre = $request->file('imagen')->store($directory);

      if(!Storage::exists($directory)){
        Storage::makeDirectory($directory);
      }

      if($configuration->save()){
        if(Storage::exists($oldTimbre)){
          Storage::delete($oldTimbre);
        }

        return redirect()->back()->with([
                'flash_message' => 'Configuración modificada exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }

      return redirect()->back()->with([
              'flash_message' => 'Ha ocurrido un error.',
              'flash_class' => 'alert-danger',
              'flash_important' => true
            ]);
    }
}
