<?php

namespace App\Http\Controllers\Admin;

use Illuminate\support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

      $configuration = Configuration::first();

      return view('admin.configurations.edit', compact('configuration'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $this->authorize('update', Configuration::class);

      $this->validate($request, [
        'dolar' => 'nullable|numeric|min:0|max:999999999'
      ]);

      $configuration = Configuration::first();
      $configuration->dollar = $request->dolar;

      if($configuration->save()){
        return redirect()->route('dashboard')->with([
                'flash_message' => 'Configuración modificada exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }else{
        return redirect()->route('configurations.edit')->withInput()->with([
                'flash_message' => 'Ha ocurrido un error.',
                'flash_class' => 'alert-danger',
                'flash_important' => true
              ]);
      }
    }

}
