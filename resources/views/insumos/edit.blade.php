@extends('layouts.app')

@section('title', 'Insumos - '.config('app.name'))

@section('head')
  <!-- Select2 -->
  <link rel="stylesheet" type="text/css" href="{{ asset('js/plugins/select2/select2.min.css') }}">
@endsection

@section('brand')
  <a class="navbar-brand" href="{{ route('insumos.index') }}"> Insumos </a>
@endsection

@section('content')
  <div class="container">

    @include('partials.flash')
    
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('insumos.update', ['insumo' => $insumo->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PATCH')

              <h4>Editar Insumo</h4>
              <div class="form-group">
                <label class="control-label" for="nombre">Nombre: *</label>
                <input id="nombre" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" type="text" name="nombre" maxlength="50" value="{{ old('nombre', $insumo->nombre) }}" placeholder="Nombre" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="marca">Marca: *</label>
                <input id="marca" class="form-control{{ $errors->has('marca') ? ' is-invalid' : '' }}" type="text" name="marca" maxlength="50" value="{{ old('marca', $insumo->marca) }}" placeholder="Marca" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="grado">Grado: *</label>
                <input id="grado" class="form-control{{ $errors->has('grado') ? ' is-invalid' : '' }}" type="text" name="grado" maxlength="50" value="{{ old('grado', $insumo->grado) }}" placeholder="Grado" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="tipo">Tipo: *</label>
                <select id="tipo" class="form-control" name="tipo" required>
                  <option value="">Seleccione</option>
                  @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ old('tipo', $insumo->tipo_id) == $tipo->id ? 'selected' : '' }}>
                      {{ $tipo->tipo }}
                    </option>
                  @endforeach
                </select>
                <button class="btn btn-simple btn-link btn-sm" type="button" data-toggle="modal" data-target="#optionModal" data-option="tipo"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Tipo</button>
              </div>

              <div class="form-group">
                <label class="control-label" for="formato">Formato: *</label>
                <select id="formato" class="form-control" name="formato" required>
                  <option value="">Seleccione</option>
                  @foreach($formatos as $formato)
                    <option value="{{ $formato->id }}" {{ old('formato', $insumo->formato_id) == $formato->id ? 'selected' : '' }}>
                      {{ $formato->formato }}
                    </option>
                  @endforeach
                </select>
                <button class="btn btn-simple btn-link btn-sm" type="button" data-toggle="modal" data-target="#optionModal" data-option="formato"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Formato</button>
              </div>

              <div class="form-group">
                <label class="control-label" for="foto">Foto:</label>
                <div class="custom-file">
                  <input id="foto" class="custom-file-input{{ $errors->has('foto') ? ' is-invalid' : '' }}" type="file" name="foto" lang="es" data-browse="Elegir" accept="image/jpeg,image/png">
                  <label class="custom-file-label" for="foto">Seleccionar</label>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label" for="decripcion">Descripcion: *</label>
                <textarea id="decripcion" class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }}" type="text" name="descripcion" required>{{ old('descripcion', $insumo->descripcion) }}</textarea>
              </div>

              <div class="form-group">
                <label class="control-label" for="factura"># factura: *</label>
                <input id="factura" class="form-control{{ $errors->has('factura') ? ' is-invalid' : '' }}" type="text" name="factura" pattern="[0-9]+" maxlength="50" value="{{ old('factura', $insumo->factura) }}" placeholder="# Factura" required>
              </div>
              <div class="form-group">
                <label class="control-label" for="foto_factura">Foto de la factura:</label>
                <div class="custom-file">
                  <input id="foto_factura" class="custom-file-input{{ $errors->has('foto_factura') ? ' is-invalid' : '' }}" type="file" name="foto_factura" lang="es" data-browse="Elegir" accept="image/jpeg,image/png">
                  <label class="custom-file-label" for="foto_factura">Seleccionar</label>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label" for="coste">Coste: *</label>
                <input id="coste" class="form-control{{ $errors->has('coste') ? ' is-invalid' : '' }}" type="number" name="coste" min="1" max="9999999999" value="{{ old('coste', $insumo->coste) }}" placeholder="Coste" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="venta">Venta: *</label>
                <input id="venta" class="form-control{{ $errors->has('venta') ? ' is-invalid' : '' }}" type="number" name="venta" min="1" max="9999999999" value="{{ old('venta', $insumo->venta) }}" placeholder="Venta" required>
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
                <a class="btn btn-default" href="{{ route('insumos.show', ['insumo' => $insumo->id]) }}"><i class="fa fa-reply"></i> Atras</a>
                <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="optionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="optionModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="optionModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <div class="col-md-8">
              <div class="alert alert-dismissible alert-danger alert-option" role="alert" style="display: none">
                <strong class="text-center">Ha ocurrido un error</strong> 

                <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>

            <form id="option-form" class="col-md-8" action="#" method="POST">
              @csrf
              @method('DELETE')

              <div class="form-group">
                <label id="option-label" class="control-label" for="option"></label>
                <input id="option" class="form-control" type="text" name="option" maxlength="50" required>
              </div>

              <center>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="option-submit" class="btn btn-fill btn-primary" type="submit">Guardar</button>
              </center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript" src="{{ asset( 'js/plugins/select2/select2.min.js' ) }}"></script>
  <script type="text/javascript">
    const alertOption = $('.alert-option');
    const optionSubmit = $('#option-submit');

    $(document).ready(function () {
      let option = null;

      $('#tipo, #formato').select2({
        placeholder: 'Seleccione...',
      });

      $('#optionModal').on('show.bs.modal', function(e){
        let btn = $(e.relatedTarget)
        option = btn.data('option')

        let label = option.charAt(0).toUpperCase() + option.slice(1)


        $('#option-form').attr('action', option == 'tipo' ? '{{ Route("tipos.index") }}' : '{{ Route("formatos.index") }}')
        $('#option-label').text(`${label}: *`)
        $('#optionModalLabel').text(`Agregar ${label}`)
      })

      $('#option-form').submit(function(e){
        e.preventDefault()

        optionSubmit.prop('disabled', true)

        let form = $(this),
            action = form.attr('action'),
            value = $('#option').val();

        $.ajax({
          type: 'POST',
          data: {
            _token : '{{ @csrf_token() }}',
            [option]: value,
          },
          url: action,
          dataType: 'json'
        })
        .done(function (data) {
          if(data.response == true){
            $(`#${option}`).append(`<option value="${data.option.id}">${data.option.option}</option`)
            $(`#${option}`).val(data.option.id)
            $(`#${option}`).trigger('change')
            $('#option-form')[0].reset()
            $('#optionModal').modal('hide')
          }else{
            alertOption.show().delay(7000).hide('slow');  
          }
        })
        .fail(function () {
          alertOption.show().delay(7000).hide('slow');
        })
        .always(function () {
          optionSubmit.prop('disabled', false)
        })
      })

      $('.custom-file-input').change(function(e){
        let files = e.target.files;
        let id = $(this).attr('id')

        $(this).siblings(`label[for="${id}"]`).text(files[0].name);
      });
    })
  </script>
@endsection
