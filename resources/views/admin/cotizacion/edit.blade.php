@extends('layouts.app')

@section('title', 'Cotización - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.cotizacion.show', ['cotizacion' => $cotizacion->id]) }}"> Cotización </a>
@endsection

@section('content')
  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-body">
          <h4>Editar cotización</h4>
          
          <h5 class="text-center">{{ $cotizacion->situacion->proceso->cliente->nombre().' | '.$cotizacion->situacion->proceso->vehiculo->vehiculo() }}</h5>

          <form action="{{ route('admin.cotizacion.update', ['cotizacion' => $cotizacion->id]) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
              <label for="descripcion">Descripción:</label>
              <textarea id="descripcion" class="form-control" name="descripcion" maxlength="500">{{ $cotizacion->descripcion }}</textarea>
            </div>

            @if(count($errors) > 0)
            <div class="alert alert-danger alert-important">
              <ul clasS="m-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif

            <div class="form-group text-right">
              <a class="btn btn-default" href="{{ route('admin.cotizacion.show', ['cotizacion' => $cotizacion->id]) }}"><i class="fa fa-reply"></i> Atras</a>
              <button id="btn-cotizacion" class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form><!-- form -->
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
@endsection
