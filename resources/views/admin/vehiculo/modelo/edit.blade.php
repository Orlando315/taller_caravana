@extends('layouts.app')

@section('title', 'Modelos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.vehiculo.index') }}"> Modelos </a>
@endsection

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <form class="" action="{{ route('admin.vehiculo.modelo.update', ['modelo' => $modelo->id]) }}" method="POST">
              @csrf
              @method('PATCH')

              <h4>Editar Modelo</h4>

              <div class="form-group">
                <label class="control-label" for="modelo">Modelo: *</label>
                <input id="modelo" class="form-control{{ $errors->has('modelo') ? ' is-invalid' : '' }}" type="text" name="modelo" maxlength="50" value="{{ old('modelo', $modelo->modelo) }}" placeholder="Modeo" required>
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
                <a class="btn btn-default" href="{{ route('admin.vehiculo.modelo.show', ['modelo' => $modelo->id]) }}"><i class="fa fa-reply"></i> Atras</a>
                <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
