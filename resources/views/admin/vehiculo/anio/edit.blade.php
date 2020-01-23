@extends('layouts.app')

@section('title', 'Años - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.vehiculo.index') }}"> Años </a>
@endsection

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <form class="" action="{{ route('admin.vehiculo.anio.update', ['anio' => $anio->id]) }}" method="POST">
              @csrf
              @method('PATCH')

              <h4>Editar Año</h4>

              <div class="form-group">
                <label class="control-label" for="año">Año: *</label>
                <input id="año" class="form-control{{ $errors->has('año') ? ' is-invalid' : '' }}" type="number" name="año" min="1900" max="2100" value="{{ old('año', $anio->anio) }}" placeholder="Año" required>
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
                <a class="btn btn-default" href="{{ route('admin.vehiculo.anio.show', ['anio' => $anio->id]) }}"><i class="fa fa-reply"></i> Atras</a>
                <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
