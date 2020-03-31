<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class UsersControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('index', User::class);

      $users = Auth::user()->isAdmin() ? Auth::user()->users : Auth::user()->taller->users;

      return view('admin.users.index', compact('admins', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Sring  $role
     * @return \Illuminate\Http\Response
     */
    public function create($role = null)
    {
      $this->authorize('create', User::class);

      return view('admin.users.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create', User::class);

      $this->validate($request, [
        'role' => 'required|in:jefe,admin',
        'nombres' => 'required|string|max:50',
        'apellidos' => 'nullable|string|max:50',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:6|max:50',
      ]);

      $user = new User($request->only(['nombres', 'apellidos', 'email', 'role']));
      $user->password = bcrypt($request->password);

      if(Auth::user()->users()->save($user)){
        return redirect()->route('admin.users.show', ['user' => $user->id])->with([
                'flash_message' => 'Usuario agregado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }else{
        return redirect()->route('admin.users.create', ['role' => $request->role])->withInput()->with([
                'flash_message' => 'Ha ocurrido un error.',
                'flash_class' => 'alert-danger',
                'flash_important' => true
              ]);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
      $this->authorize('view', $user);

      return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
      $this->authorize('update', $user);

      return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
      $this->authorize('update', $user);

      $this->validate($request, [
        'role' => 'required|in:jefe,admin',
        'nombres' => 'required|string|max:50',
        'apellidos' => 'nullable|string|max:50',
        'email' => 'required|email|unique:users,email,' . $user->id . ',id',
      ]);

      $user->fill($request->only(['nombres', 'apellidos', 'email', 'role']));

      if($user->save()){
        return redirect()->route('admin.users.show', ['user' => $user->id])->with([
                'flash_message' => 'Usuario modificado exitosamente.',
                'flash_class' => 'alert-success'
              ]);
      }else{
        return redirect()->route('admin.users.edit', ['user' => $user->id])->withInput()->with([
                'flash_message' => 'Ha ocurrido un error.',
                'flash_class' => 'alert-danger',
                'flash_important' => true
              ]);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
      $this->authorize('delete', $user);

      if($user->delete()){
        return redirect()->route('admin.users.index')->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Usuario eliminado exitosamente.'
              ]);
      }else{
        return redirect()->route('admin.users.show', ['user' => $user->id])->with([
                'flash_class'     => 'alert-danger',
                'flash_message'   => 'Ha ocurrido un error.',
                'flash_important' => true
              ]);
      }
    }

    /**
     * Modificar contraseña de un usuario
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
    */
    public function password(Request $request, User $user)
    {
      $this->authorize('password', $user);

      $this->validate($request, [
        'password' => 'required|min:6|confirmed'
      ]);

      $user->password = bcrypt($request->password);

      if($user->save()){
        return redirect()->route('admin.users.show', ['user' => $user->id])->with([
                'flash_class'   => 'alert-success',
                'flash_message' => 'Contraseña modificada exitosamente.'
              ]);
      }else{
        return redirect()->back()->withInput()->with([
                'flash_message' => 'Ha ocurrido un error.',
                'flash_class' => 'alert-danger',
                'flash_important' => true
              ]);
      }
    }
}
