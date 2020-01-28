@extends('layouts.app')

@section('title', 'Vehiculo Proveedor - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proveedor.index') }}"> Proveedor </a>
@endsection

@section('content')
  <div class="container">

    @include('partials.flash')

    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.proveedor.vehiculo.store') }}" method="POST">
              @csrf
              <input type="hidden" name="taller" value="{{ Auth::user()->id }}">
              <input type="hidden" name="proveedor_id" value="{{ $proveedor->id }}">
              <h4>Agregar Proveedor</h4>

              <div class="form-group">
                <label class="control-label" for="proveedor">Proveedor: *</label>
                <input  class="form-control" readonly="" type="text" value="{{ $proveedor->email }}">
              </div>

              <div class="form-group">
                <label class="control-label" for="marca">Marca: *</label>
                <select name="vehiculo_marca_id" class="form-control select" required id="marca">
                  <option>Selecciona...</option>
                  @foreach($marca as $m)
                    <option value="{{ $m->id }}">{{ $m->marca }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label class="control-label" for="modelos">Modelos:</label>
                <select class="form-control" id="modelos" name="vehiculo_modelo_id">
                  
                </select>
              </div>

              <div class="form-group">
                <label class="control-label" for="vehiculo_anio_id">Año: *</label>
                <select name="vehiculo_anio_id" class="form-control select" required id="vehiculo_anio_id">
                  <option>Selecciona...</option>
                  @foreach($anio as $m)
                    <option value="{{ $m->id }}">{{ $m->anio }}</option>
                  @endforeach
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
                <a class="btn btn-default" href="{{ route('admin.users.index') }}"><i class="fa fa-reply"></i> Atras</a>
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
      $('.select').select2({
        placeholder: 'Seleccione...',
      });
    })

    $("#marca").change(function(event) {
      event.preventDefault();
      $.ajax({
        url: '{{ route("admin.proveedor.vehiculo.search.modelo")}}',
        type: 'POST',
        dataType: 'json',
        data: {_token: '{{ csrf_token() }}' , id: $(this).val()},
      })
      .done(function(data) {
        var modelos = '<option value="">Seleccione...</option>';
        $.each(data.modelos, function(index, val) {
           modelos += '<option value="'+val.id+'">'+val.modelo+'</option>';
        });

        $("#modelos").html(modelos);
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
      
    });
  </script>
@endsection
