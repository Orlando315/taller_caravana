@extends('layouts.app')

@section('title', 'Usuarios - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.users.index') }}"> Usuarios </a>
@endsection

@section('content')
  <div class="container">

    @include('partials.flash')

    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.users.user.store', ['user' => $user->id]) }}" method="POST">
              @csrf

              <h4>Agregar Usuario</h4>

              <div class="form-group">
                <label class="control-label" for="role">Role: *</label>
                <select id="role" class="form-control" name="role" required>
                  @if($user->nivel < 3)
                    <option value="user" {{ old('role') == 'user' ? 'selected' : $role == 'user' ? 'selected' : '' }}> Usuario - Nivel {{ $user->nivel + 1 }}</option>
                  @endif
                  <option value="subuser" {{ old('role') == 'subuser' ? 'selected' : $role == 'subuser' ? 'selected' : '' }}> Subusuario</option>
                </select>
              </div>

              <div class="form-group">
                <label class="control-label" for="nombres">Nombres: *</label>
                <input id="nombres" class="form-control{{ $errors->has('nombres') ? ' is-invalid' : '' }}" type="text" name="nombres" maxlength="50" value="{{ old('nombres') }}" placeholder="Nombres" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="apellidos">Apellidos:</label>
                <input id="apellidos" class="form-control{{ $errors->has('apellidos') ? ' is-invalid' : '' }}" type="text" name="apellidos" maxlength="50" value="{{ old('apellidos') }}" placeholder="Apellidos">
              </div>

              <div class="form-group">
                <label class="control-label" for="email">Email: *</label>
                <input id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" maxlength="50" value="{{ old('email') }}" placeholder="Email" required>
              </div>

              <fieldset id="options">
                <div class="form-group">
                  <div class="form-check p-0">
                    <label class="form-check-label">
                      <input id="administrar" class="form-check-input" type="checkbox" name="administrar" value="administrar">
                      <span class="form-check-sign"></span>
                      Administrar usuarios
                    </label>
                  </div>
                </div>
              </fieldset>

              <div class="form-group">
                <label class="control-label" for="password">Contraseña: *</label>
                <input id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" minlength="6" maxlength="50" placeholder="Contraseña" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="password_confirmation">Confirmación: *</label>
                <input id="password_confirmation" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" type="password" name="password_confirmation" minlength="6" maxlength="50" placeholder="Confirmación" required>
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

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function () {
      $('#role').change(function () {
        let role = $(this).val(),
            shouldDisable = role == 'user'

        $('#options').prop('disabled', shouldDisable).toggle(!shouldDisable)
      });

      $('#role').change()
    })
  </script>
@endsection
