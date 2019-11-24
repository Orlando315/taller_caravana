@extends('layouts.app')

@section('title', 'Tipos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('tipos.index') }}"> Tipos </a>
@endsection

@section('content')
  <div class="container">

    @include('partials.flash')

    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('tipos.store') }}" method="POST">
              @csrf

              <h4>Agregar Tipo</h4>

              <div class="form-group">
                <label class="control-label" for="tipo">Tipo: *</label>
                <input id="tipo" class="form-control{{ $errors->has('tipo') ? ' is-invalid' : '' }}" type="text" name="tipo" maxlength="50" value="{{ old('tipo') }}" placeholder="Tipo" required>
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
                <a class="btn btn-default" href="{{ route('tipos.index') }}"><i class="fa fa-reply"></i> Atras</a>
                <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

