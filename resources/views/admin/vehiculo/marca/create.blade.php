@extends('layouts.app')

@section('title', 'Marcas - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.vehiculo.index') }}"> Marcas </a>
@endsection

@section('content')
  <div class="container">

    @include('partials.flash')

    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.vehiculo.marca.store') }}" method="POST">
              @csrf

              <h4>Agregar Marca</h4>

              <div class="form-group">
                <label class="control-label" for="marca">Marca: *</label>
                <input id="marca" class="form-control{{ $errors->has('marca') ? ' is-invalid' : '' }}" type="text" name="marca" maxlength="50" value="{{ old('marca') }}" placeholder="Marca" required>
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
                <a class="btn btn-default" href="{{ route('admin.vehiculo.index') }}"><i class="fa fa-reply"></i> Atras</a>
                <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
