@extends('layouts.app')

@section('title', 'Usuarios - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.users.index') }}"> Usuarios </a>
@endsection

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <form class="" action="{{ route('admin.users.update', ['user' => $user->id]) }}" method="POST">
              @csrf
              @method('PATCH')

              <h4>Editar Usuario</h4>

              <div class="form-group">
                <label class="control-label" for="nombres">Nombres: *</label>
                <input id="nombres" class="form-control{{ $errors->has('nombres') ? ' is-invalid' : '' }}" type="text" name="nombres" maxlength="50" value="{{ old('nombres') ?? $user->nombres }}" placeholder="Nombres" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="apellidos">Apellidos:</label>
                <input id="apellidos" class="form-control{{ $errors->has('apellidos') ? ' is-invalid' : '' }}" type="text" name="apellidos" maxlength="50" value="{{ old('apellidos') ?? $user->apellidos }}" placeholder="Apellidos">
              </div>

              <div class="form-group">
                <label class="control-label" for="email">Email: *</label>
                <input id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" maxlength="50" value="{{ old('email') ?? $user->email }}" placeholder="Email" required>
              </div>
              
              @if($user->role == 'subuser')
                <fieldset id="options">
                  <div class="form-group">
                    <div class="form-check p-0">
                      <label class="form-check-label">
                        <input id="administrar" class="form-check-input" type="checkbox" name="administrar" value="administrar" {{ $user->administrar ? 'checked' : '' }}>
                        <span class="form-check-sign"></span>
                        Administrar usuarios
                      </label>
                    </div>
                  </div>
                </fieldset>
              @endif

              @if(count($errors) > 0)
              <div class="alert alert-danger alert-important">
                <ul>
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif

              <div class="form-group text-right">
                <a class="btn btn-default" href="{{ url()->previous() }}"><i class="fa fa-reply"></i> Atras</a>
                <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
