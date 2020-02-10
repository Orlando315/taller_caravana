@extends('layouts.app')

@section('title', 'Repuestos - '.config('app.name'))

@section('head')
  <!-- fileinput -->
  <link rel="stylesheet" type="text/css" href="{{ asset('js/plugins/fileinput/fileinput.min.css')}}">
@endsection

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.repuesto.index') }}"> Repuestos </a>
@endsection

@section('content')

  @include('partials.flash')
  
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.repuesto.update', ['repuesto' => $repuesto->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <h4>Editar Repuesto</h4>

            <fieldset>
              <legend>Repuesto</legend>

              <div class="form-group">
                <label class="control-label" for="nro_parte">Nro. parte: *</label>
                <input id="nro_parte" class="form-control{{ $errors->has('nro_parte') ? ' is-invalid' : '' }}" type="text" name="nro_parte" maxlength="50" value="{{ old('nro_parte', $repuesto->nro_parte) }}" placeholder="Nro. parte" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="nro_oem">Nro. OEM: *</label>
                <input id="nro_oem" class="form-control{{ $errors->has('nro_oem') ? ' is-invalid' : '' }}" type="text" name="nro_oem" maxlength="50" value="{{ old('nro_oem', $repuesto->nro_oem) }}" placeholder="Nro. OEM" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="marca_oem">Marca OEM: *</label>
                <input id="marca_oem" class="form-control{{ $errors->has('marca_oem') ? ' is-invalid' : '' }}" type="text" name="marca_oem" maxlength="50" value="{{ old('marca_oem', $repuesto->marca_oem) }}" placeholder="Marca OEM" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="año">Año: *</label>
                <input id="año" class="form-control{{ $errors->has('año') ? ' is-invalid' : '' }}" type="number" name="año" min="0" step="1" max="9999" value="{{ old('año', $repuesto->anio) }}" placeholder="Año" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="modelo">Modelo: *</label>
                <select id="modelo" class="form-control" name="modelo" required>
                  <option>Selecciona...</option>
                  @foreach($marcas as $marca)
                    <optgroup label="{{ $marca->marca }}">
                      @foreach($marca->modelos as $modelo)
                        <option value="{{ $modelo->id }}" {{ old('modelo') == $modelo->id ? 'selected' : ($modelo->id == $repuesto->vehiculo_modelo_id ? 'selected' : '') }}>{{ $modelo->modelo }}</option>
                      @endforeach
                    </optgroup>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label class="control-label" for="motor">Motor: *</label>
                <input id="motor" class="form-control{{ $errors->has('motor') ? ' is-invalid' : '' }}" type="text" name="motor" maxlength="50" value="{{ old('motor', $repuesto->motor) }}" placeholder="Motor" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="sistema">Sistema: *</label>
                <input id="sistema" class="form-control{{ $errors->has('sistema') ? ' is-invalid' : '' }}" type="text" name="sistema" maxlength="50" value="{{ old('sistema', $repuesto->sistema) }}" placeholder="Sistema" required>
              </div>

              <div class="form-group">
                <label class="control-label" for="componente">Componente: *</label>
                <input id="componente" class="form-control{{ $errors->has('componente') ? ' is-invalid' : '' }}" type="text" name="componente" maxlength="50" value="{{ old('componente', $repuesto->componente) }}" placeholder="Componente" required>
              </div>

              <div id="foto-group" class="form-group">
                <label for="foto">Foto:</label>
                <div class="file-loading">
                  <input id="foto" type="file" name="foto" data-msg-placeholder="Seleccionar..." accept="image/jpeg,image/png">
                </div>
                <small class="text-muted">Tamaño máximo 12 MB</small>
              </div>

              <div class="form-group">
                <label class="control-label" for="procedencia">Tipo: *</label>
                <select id="procedencia" class="form-control" name="procedencia" required>
                  <option>Selecciona...</option>
                  <option value="local" {{ old('procedencia') == 'local' ? 'selected' : ($repuesto->procedencia == 'local' ? 'selected' : '') }}>Local</option>
                  <option value="nacional" {{ old('procedencia') == 'nacional' ? 'selected' : ($repuesto->procedencia == 'nacional' ? 'selected' : '') }}>Nacional</option>
                  <option value="internacional" {{ old('procedencia') == 'internacional' ? 'selected' : ($repuesto->procedencia == 'internacional' ? 'selected' : '') }}>Internacional</option>
                </select>
              </div>

              <div class="form-group">
                <label class="control-label" for="venta">Venta:</label>
                <input id="venta" class="form-control{{ $errors->has('venta') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="venta" maxlength="50" value="{{ old('venta', $repuesto->venta) }}" placeholder="Precio de venta">
              </div>

              <div class="form-group envio">
                <label class="control-label" for="envio">Envio:</label>
                <input id="envio" class="form-control{{ $errors->has('envio') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="envio" maxlength="50" value="{{ old('envio', $repuesto->envio) }}" placeholder="Envio">
              </div>

              <div class="form-group aduana">
                <label class="control-label" for="aduana">Aduana:</label>
                <input id="aduana" class="form-control{{ $errors->has('aduana') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="aduana" maxlength="50" value="{{ old('aduana', $repuesto->aduana) }}" placeholder="Aduana">
              </div>
            </fieldset>
            
            <fieldset>
              <legend>Extras</legend>
              
              <div class="form-group">
                <label class="control-label" for="costo">Costo:</label>
                <input id="costo" class="form-control{{ $errors->has('costo') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="costo" maxlength="50" value="{{ old('costo', $repuesto->extra->costo) }}" placeholder="Costo">
              </div>

              <div class="form-group">
                <label class="control-label" for="envio1">Envio 1:</label>
                <input id="envio1" class="form-control{{ $errors->has('envio1') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="envio1" maxlength="50" value="{{ old('envio1', $repuesto->extra->envio1) }}" placeholder="Envio 1">
              </div>

              <div class="form-group">
                <label class="control-label" for="envio2">Envio 2:</label>
                <input id="envio2" class="form-control{{ $errors->has('envio2') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="envio2" maxlength="50" value="{{ old('envio2', $repuesto->extra->envio2) }}" placeholder="Envio 2">
              </div>

              <div class="form-group">
                <label class="control-label" for="casilla">Gastos casilla:</label>
                <input id="casilla" class="form-control{{ $errors->has('casilla') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="casilla" maxlength="50" value="{{ old('casilla', $repuesto->extra->casilla) }}" placeholder="Gastos casilla">
              </div>

              <div class="form-group">
                <label class="control-label" for="impuestos">Impuestos:</label>
                <input id="impuestos" class="form-control{{ $errors->has('impuestos') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="impuestos" maxlength="50" value="{{ old('impuestos', $repuesto->extra->impuestos) }}" placeholder="Impuestos">
              </div>

              <div class="form-group">
                <label class="control-label" for="generales">Gastos generales:</label>
                <input id="generales" class="form-control{{ $errors->has('generales') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="generales" maxlength="50" value="{{ old('generales', $repuesto->extra->generales) }}" placeholder="Gastos generales">
              </div>

              <div class="form-group">
                <label class="control-label" for="tramitacion">Costo tramitación:</label>
                <input id="tramitacion" class="form-control{{ $errors->has('tramitacion') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="tramitacion" maxlength="50" value="{{ old('tramitacion', $repuesto->extra->tramitacion) }}" placeholder="Costo tramitación">
              </div>

              <div class="form-group">
                <label class="control-label" for="moneda">Moneda:</label>
                <input id="moneda" class="form-control{{ $errors->has('moneda') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="moneda" maxlength="50" value="{{ old('moneda', $repuesto->extra->moneda) }}" placeholder="Moneda">
              </div>
            </fieldset>

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
              <a class="btn btn-default" href="{{ route('admin.repuesto.show', ['repuesto' => $repuesto->id]) }}"><i class="fa fa-reply"></i> Atras</a>
              <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <!-- fileinput -->
  <script type="text/javascript" src="{{asset('js/plugins/fileinput/fileinput.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/plugins/fileinput/locales/es.js')}}"></script>

  <script type="text/javascript">
    $(document).ready(function () {
      $('#modelo, #procedencia').select2({
        placeholder: 'Seleccione...',
      });

      $('#foto').fileinput({
        initialPreview: @json($repuesto->getPhoto()),
        initialPreviewAsData: true,
        overwriteInitial: true,
        showUpload: false,
        maxFileSize: 12000,
        initialPreviewCount: 1,
        maxFileCount: 1,
        dropZoneEnabled: false,
        browseClass: 'btn btn-success',
        browseLabel: 'Seleccionar',
        browseIcon: '<i class="fa fa-image"></i>',
        allowedFileExtensions: ['jpg', 'png', 'jpeg'],
        language: 'es',
        showCancel: false,
        showRemove: false,
        fileActionSettings: {
          showRemove: false,
          showZoom: false,
        },
        focusCaptionOnBrowse: false,
        focusCaptionOnClear: false,
        layoutTemplates: {
          fileIcon: '<i class="ft-image"></i>',
        }
      });

      $('#foto-group').on('click', '.file-caption-name', function () {
        $('#foto').click()
      })

      $('#procedencia').change(function () {
        let procedencia = $(this).val()

        $('.envio').toggle(procedencia != 'local')
        $('.aduana').toggle(procedencia == 'internacional')
      })

      $('#procedencia').change()
    })
  </script>
@endsection
