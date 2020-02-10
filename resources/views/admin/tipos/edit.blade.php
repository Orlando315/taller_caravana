@extends('layouts.app')

@section('title', 'Tipos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.tipos.index') }}"> Tipos </a>
@endsection

@section('content')

  @include('partials.flash')
  
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.tipos.update', ['tipo' => $tipo->id]) }}" method="POST">
            @csrf
            @method('PATCH')

            <h4>Editar Tipo</h4>

            <div class="form-group">
              <label class="control-label" for="tipo">Tipo: *</label>
              <input id="tipo" class="form-control{{ $errors->has('tipo') ? ' is-invalid' : '' }}" type="text" name="tipo" maxlength="50" value="{{ old('tipo', $tipo->tipo) }}" placeholder="Tipo" required>
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
              <a class="btn btn-default" href="{{ route('admin.tipos.show', ['tipo' => $tipo->id]) }}"><i class="fa fa-reply"></i> Atras</a>
              <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
