<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\{Insumo, Cliente, Vehiculo, Proceso, Agendamiento};


class HomeController extends Controller
{
    /**
     * Pagina principal del sistema
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
      $insumos = Auth::user()->isStaff() ? Insumo::count() : [];
      $clientes = Auth::user()->isStaff() ? Cliente::count() : [];
      $vehiculos = Auth::user()->isStaff() ? Vehiculo::count() : Auth::user()->cliente->vehiculos()->count();
      $procesosCount = Auth::user()->isStaff() ? Proceso::count() : Auth::user()->cliente->procesos()->count();
      $efectividad = Auth::user()->isStaff() ? Proceso::efectividad() : null;
      $procesosCompletados = Auth::user()->isStaff() ? Proceso::where('status', true)->count() : null;
      $finanzas = Auth::user()->isStaff() ? Proceso::finanzas() : null;
      $agendamientosCalendar = Auth::user()->isStaff() ? Agendamiento::toCalendar() : [];

      $procesosActivos = Auth::user()->isCliente() ? Auth::user()->cliente->procesosActivos : Proceso::where('status', null)->get();

      return view('dashboard', compact('insumos', 'clientes', 'vehiculos', 'procesosCount', 'procesosActivos', 'procesosCompletados', 'efectividad', 'finanzas', 'agendamientosCalendar'));
    }

    /**
     * Mostrar el perfil del usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function perfil()
    {
      return view('perfil');
    }

    /**
     * Actualizar la informacion del User en sesion
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $this->validate($request, [
        'nombres' => 'required|string|max:50',
        'apellidos' => 'nullable|string|max:50',
        'email' => 'required|email|unique:users,email,' . Auth::user()->id . ',id',
      ]);

      Auth::user()->fill($request->only(['nombres', 'apellidos', 'email']));

      if(Auth::user()->save()){
        return redirect()->route('perfil')->with([
          'flash_message' => 'Perfil modificado exitosamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect()->route('perfil')->with([
          'flash_message' => 'Ha ocurrido un error.',
          'flash_class' => 'alert-danger',
          'flash_important' => true
          ]);
      }
    }

    /**
     * Cambiar la contraseña del User en sesion
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function password(Request $request)
    {
      $this->validate($request, [
        'password' => 'required|min:6|confirmed',
      ]);

      if(!password_verify($request->actual, Auth::user()->password)){
        return redirect()->route('perfil')->with([
          'flash_class'     => 'alert-danger',
          'flash_message'   => 'Contraseña actual incorrecta.',
          'flash_important' => true
        ]);
      }

      Auth::user()->password = bcrypt($request->password);

      if(Auth::user()->save()){
        return redirect()->route('perfil')->with([
          'flash_class'   => 'alert-success',
          'flash_message' => 'Contraseña cambiada exitosamente.'
        ]);
      }else{
        return redirect()->route('perfil')->with([
          'flash_class'     => 'alert-danger',
          'flash_message'   => 'Ha ocurrido un error.',
          'flash_important' => true
        ]);
      }
    }
}
