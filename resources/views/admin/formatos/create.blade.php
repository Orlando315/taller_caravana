@extends('layouts.app')

@section('title', 'Formatos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.insumos.index') }}"> Formatos </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.formatos.store') }}" method="POST">
            @csrf

            <h4>Agregar Formato</h4>

            <div class="form-group">
              <label class="control-label" for="formato">Formato: *</label>
              <input id="formato" class="form-control{{ $errors->has('formato') ? ' is-invalid' : '' }}" type="text" name="formato" maxlength="50" value="{{ old('formato') }}" placeholder="Formato" required>
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
              <a class="btn btn-default" href="{{ route('admin.insumos.index') }}"><i class="fa fa-reply"></i> Atras</a>
              <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

