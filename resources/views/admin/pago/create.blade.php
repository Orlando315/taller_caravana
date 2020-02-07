@extends('layouts.app')

@section('title', 'Pago - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.cotizacion.show', ['cotizacion' => $cotizacion->id]) }}"> Pago</a>
@endsection

@section('content')
  <div class="container">

    @include('partials.flash')

    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.pago.store', ['cotizacion' => $cotizacion->id]) }}" method="POST">
              @csrf
              <h4>Agregar Pago</h4>
              <h5 class="text-center">Monto restante: {{ $cotizacion->porPagar(false) }}</h5>

              <div class="form-group ">
                <label class="control-label" for="pago">Pago: *</label>
                <input id="pago" class="form-control{{ $errors->has('pago') ? ' is-invalid' : '' }}" type="number" step="0.01" min="1" max="{{ $cotizacion->porPagar() }}" name="pago" value="{{ old('pago') }}" placeholder="Pago" required>
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
                <a class="btn btn-default" href="{{ route('admin.cotizacion.show', ['cotizacion' => $cotizacion->id]) }}"><i class="fa fa-reply"></i> Atras</a>
                <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
