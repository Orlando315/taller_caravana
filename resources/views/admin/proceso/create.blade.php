@extends('layouts.app')

@section('title', 'Iniciar Proceso - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proveedor.index') }}"> Proceso de cotización </a>
@endsection

@section('content')
  <div class="container">

    @include('partials.flash')

    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.proceso.store') }}" method="POST">
              @csrf
              <h4>Iniciar proceso de Cotización</h4>

              <div class="form-group">
                <label class="control-label" for="cliente">Cliente: *</label>
                <select id="cliente" class="form-control" name="cliente" required>
                  <option value="">Seleccione...</option>
                  @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old('cliente') == $cliente->id ? 'selected' : '' }}>{{ $cliente->nombre() }}</option>
                  @endforeach
                </select>
                <small><a class="text-muted" href="{{ route('admin.cliente.create') }}">Agregar cliente</a></small>
              </div>

              <div class="form-group">
                <label class="control-label" for="vehiculo">Vehículo: *</label>
                <select id="vehiculo" class="form-control" name="vehiculo"  required disabled>
                </select>
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
                <a class="btn btn-default" href="{{ route('admin.proceso.index') }}"><i class="fa fa-reply"></i> Atras</a>
                <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function(){
      $('#cliente, #vehiculo').select2({
        placeholder: 'Seleccione...',
      });

      $('#cliente').on('change',function () {
        let cliente = $(this).val()

        if(!cliente){ return false }

        $.ajax({
          type: 'POST',
          url: `{{ route("admin.cliente.index") }}/${cliente}/vehiculos`,
          data: {
            _token: '{{ csrf_token() }}'
          },
          cache: false,
          dataType: 'json',
        })
        .done(function (vehiculos) {
          $('#vehiculo').html('<option value="">Seleccione...</option>');
          $.each(vehiculos, function(k, vehiculo){
            let selected = (@json(old('vehiculo')) == vehiculo.id) ? 'selected' : ''
            $('#vehiculo').append(`<option value="${vehiculo.id}" ${selected}>${vehiculo.marca.marca} - ${vehiculo.modelo.modelo } (${vehiculo.anio.anio })</option>`)
          })

          $('#vehiculo').prop('disabled', false)
        })
        .fail(function () {
          $('#vehiculo').prop('disabled', true)
        })
      })

      $('#cliente').change()
    })
  </script>
@endsection
