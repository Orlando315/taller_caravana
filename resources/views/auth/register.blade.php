@extends('layouts.blank')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-sm-8">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Registro</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
              @csrf

              <div class="form-group">
                <label class="control-label" for="nombres">Nombres: *</label>
                <input id="nombres" class="form-control{{ $errors->has('nombres') ? ' is-invalid' : '' }}" type="text" name="nombres" maxlength="50" value="{{ old('nombres') }}" placeholder="Nombres" required autofocus>
              </div>

              <div class="form-group">
                <label class="control-label" for="apellidos">Apellidos:</label>
                <input id="apellidos" class="form-control{{ $errors->has('apellidos') ? ' is-invalid' : '' }}" type="text" name="apellidos" maxlength="50" value="{{ old('apellidos') }}" placeholder="Apellidos">
              </div>

              <div class="form-group">
                <label class="control-label" for="email">Email: *</label>
                <input id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" maxlength="50" value="{{ old('email') }}" placeholder="Email" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="password">Contraseña: *</label>
                <input id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" maxlength="50" placeholder="Contraseña" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="password_confirmation">Confirmación: *</label>
                <input id="password_confirmation" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" type="password" name="password_confirmation" maxlength="50" placeholder="Confirmación" required>
              </div>

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
                <a class="btn btn-default" href="{{ route('login') }}"><i class="fa fa-reply"></i> Atras</a>
                <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
