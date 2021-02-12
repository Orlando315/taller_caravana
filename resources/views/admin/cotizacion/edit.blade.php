@extends('layouts.app')

@section('title', 'Cotización - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.cotizacion.show', ['cotizacion' => $cotizacion->id]) }}"> Cotización </a>
@endsection

@section('head')
  <!-- Datepicker -->
  <link href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet"/>
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
              <textarea id="descripcion" class="form-control" name="descripcion" maxlength="500">{{ old('descripcion', $cotizacion->descripcion) }}</textarea>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="entrega">Fecha de entrega:</label>
                  <input id="entrega" class="form-control" type="text" name="entrega" vavlue="{{ old('entrega', $cotizacion->entrega) }}">
                </div>
              </div>
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

@section('scripts')
  <!-- datepicker -->
  <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') }}" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      $('#entrega').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',
        autoclose: true,
      });
    });
  </script>
@endsection
