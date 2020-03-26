@extends('layouts.app')

@section('title', 'Clientes - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.cliente.index') }}"> Clientes </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.cliente.store') }}" method="POST">
            @csrf

            <h4>Agregar Cliente</h4>

            <div class="form-group">
              <label class="control-label" for="nombres">Nombres: *</label>
              <input id="nombres" class="form-control{{ $errors->has('nombres') ? ' is-invalid' : '' }}" type="text" name="nombres" maxlength="50" value="{{ old('nombres') }}" placeholder="Nombres" required>
            </div>

            <div class="form-group">
              <label class="control-label" for="apellidos">Apellidos:</label>
              <input id="apellidos" class="form-control{{ $errors->has('apellidos') ? ' is-invalid' : '' }}" type="text" name="apellidos" maxlength="50" value="{{ old('apellidos') }}" placeholder="Apellidos">
            </div>

            <div class="form-group">
              <label class="control-label" for="rut">RUT: *</label>
              <input id="rut" class="form-control" type="text" name="rut" maxlength="11" pattern="^(\d{4,9}-[\dk])$" value="{{ old('rut') }}" placeholder="RUT" required>
              <small class="text-muted">Ejemplo: 00000000-0</small>
            </div>

            <div class="form-group">
              <label class="control-label" for="telefono">Teléfono: *</label>
              <input id="telefono" class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}" type="text" name="telefono" maxlength="15" value="{{ old('telefono') }}" placeholder="Teléfono" required>
            </div>

            <div class="form-group">
              <label class="control-label" for="email">Email: *</label>
              <input id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" maxlength="50" value="{{ old('email') }}" placeholder="Email" required>
            </div>

            <div class="form-group">
              <label class="control-label" for="direccion">Dirección:</label>
              <input id="direccion" class="form-control{{ $errors->has('direccion') ? ' is-invalid' : '' }}" type="text" name="direccion" maxlength="150" value="{{ old('direccion') }}" placeholder="Dirección">
            </div>

            <p class="text-muted text-center">La contraseña del cliente será el RUT, sin contar el último dígito.</p>

            @if(count($errors) > 0)
            <div class="alert alert-danger alert-important">
              <ul class="m-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif

            <div class="form-group text-right">
              <a class="btn btn-default" href="{{ route('admin.cliente.index') }}"><i class="fa fa-reply"></i> Atras</a>
              <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
