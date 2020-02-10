@extends('layouts.app')

@section('title', 'Configuración - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('dashboard') }}"> Configuratión </a>
@endsection

@section('content')

  @include('partials.flash')
  
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.configurations.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <h4>Editar Configuración</h4>

            <div class="form-group">
              <label class="control-label" for="dolar">Dolar:</label>
              <input id="dolar" class="form-control{{ $errors->has('dolar') ? ' is-invalid' : '' }}" type="number" name="dolar" step=".1" min="0" max="999999999" value="{{ old('dolar', $configuration->dollar) }}" placeholder="Dolar">
            </div>

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
              <a class="btn btn-default" href="{{ route('dashboard') }}"><i class="fa fa-reply"></i> Atras</a>
              <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
