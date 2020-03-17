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
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.repuesto.update', ['repuesto' => $repuesto->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <h4>Editar Repuesto</h4>
            <fieldset>
              <legend>Datos del Repuesto</legend>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="marca">Marca: *</label>
                    <select id="marca" class="form-control" name="marca" required>
                      <option value="">Seleccione...</option>
                      @foreach($marcas as $marca)
                        <option value="{{ $marca->id }}" {{ old('marca', $repuesto->vehiculo_marca_id) == $marca->id ? 'selected' : '' }}>{{ $marca->marca }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="modelo">Modelo: *</label>
                    <select id="modelo" class="form-control" name="modelo" required disabled>
                      <option value="">Seleccione...</option>
                      @foreach($marca->modelos as $modelo)
                        <option value="{{ $modelo->id }}" {{ old('modelo', $repuesto->vehiculo_modelo_id) == $modelo->id ? 'selected' : '' }}>{{ $modelo->modelo }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="año">Año: *</label>
                    <input id="año" class="form-control{{ $errors->has('año') ? ' is-invalid' : '' }}" type="number" name="año" min="0" step="1" max="9999" value="{{ old('año', $repuesto->anio) }}" placeholder="Año" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="motor">Motor (cc): *</label>
                    <input id="motor" class="form-control{{ $errors->has('motor') ? ' is-invalid' : '' }}" type="number" min="0" max="9999" name="motor" value="{{ old('motor', $repuesto->motor) }}" placeholder="Motor" required>
                    <small class="text-muted">Solo números</small>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="sistema">Sistema: *</label>
                    <input id="sistema" class="form-control{{ $errors->has('sistema') ? ' is-invalid' : '' }}" type="text" name="sistema" maxlength="50" value="{{ old('sistema', $repuesto->sistema) }}" placeholder="Sistema" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="componente">Componente: *</label>
                    <input id="componente" class="form-control{{ $errors->has('componente') ? ' is-invalid' : '' }}" type="text" name="componente" maxlength="50" value="{{ old('componente', $repuesto->componente) }}" placeholder="Componente" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="nro_parte">Nro. parte: *</label>
                    <input id="nro_parte" class="form-control{{ $errors->has('nro_parte') ? ' is-invalid' : '' }}" type="text" name="nro_parte" maxlength="50" value="{{ old('nro_parte', $repuesto->nro_parte) }}" placeholder="Nro. parte" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="nro_oem">Nro. OEM: *</label>
                    <input id="nro_oem" class="form-control{{ $errors->has('nro_oem') ? ' is-invalid' : '' }}" type="text" name="nro_oem" maxlength="50" value="{{ old('nro_oem', $repuesto->nro_oem) }}" placeholder="Nro. OEM" required>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="marca_oem">Marca OEM: *</label>
                    <input id="marca_oem" class="form-control{{ $errors->has('marca_oem') ? ' is-invalid' : '' }}" type="text" name="marca_oem" maxlength="50" value="{{ old('marca_oem', $repuesto->marca_oem) }}" placeholder="Marca OEM" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="foto">Foto:</label>
                    <div class="custom-file">
                      <input id="foto" class="custom-file-input" type="file" name="foto" lang="es" accept="image/jpeg,image/png">
                      <label class="custom-file-label" for="foto">Selecionar...</label>
                    </div>
                    <small class="text-muted">Tamaño máximo 12 MB</small>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="procedencia">Procedencia: *</label>
                    <select id="procedencia" class="form-control" name="procedencia" required>
                      <option>Seleccione...</option>
                      <option value="local" {{ old('procedencia', $repuesto->procedencia) == 'local' ? 'selected' : '' }}>Local</option>
                      <option value="nacional" {{ old('procedencia', $repuesto->procedencia) == 'nacional' ? 'selected' : '' }}>Nacional</option>
                      <option value="internacional" {{ old('procedencia', $repuesto->procedencia) == 'internacional' ? 'selected' : '' }}>Internacional</option>
                    </select>
                  </div>
                </div>
              </div>
            </fieldset>

            <fieldset id="field-local" style="display: none">
              <legend>Local</legend>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="moneda-local">Moneda: *</label>
                    <select id="moneda-local" class="custom-select" name="moneda" required>
                      <option value="">Seleccione...</option>
                      <option value="peso" {{ old('moneda', $repuesto->extra->moneda) == 'peso' ? 'selected' : '' }}>Peso chileno</option>
                      <option value="dolar" {{ old('moneda', $repuesto->extra->moneda) == 'dolar' ? 'selected' : '' }}>Dólar</option>
                      <option value="euro" {{ old('moneda', $repuesto->extra->moneda) == 'euro' ? 'selected' : '' }}>Euro</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="costo">Costo:</label>
                    <input id="costo" class="form-control{{ $errors->has('costo') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="costo" value="{{ old('costo', $repuesto->extra->costo) }}" placeholder="Costo">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="generales">Gastos generales:</label>
                    <input id="generales" class="form-control{{ $errors->has('generales') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="generales" value="{{ old('generales', $repuesto->extra->generales) }}" placeholder="Gastos generales">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="venta">Precio de venta: *</label>
                    <input id="venta" class="form-control{{ $errors->has('venta') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="venta" value="{{ old('venta', $repuesto->venta) }}" placeholder="Venta" required>
                  </div>
                </div>
              </div>
            </fieldset>

            <fieldset id="field-nacional" style="display: none">
              <legend>Nacional</legend>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="moneda-nacional">Moneda: *</label>
                    <select id="moneda-nacional" class="custom-select" name="moneda" required>
                      <option value="">Seleccione...</option>
                      <option value="peso" {{ old('moneda', $repuesto->extra->moneda) == 'peso' ? 'selected' : '' }}>Peso chileno</option>
                      <option value="dolar" {{ old('moneda', $repuesto->extra->moneda) == 'dolar' ? 'selected' : '' }}>Dólar</option>
                      <option value="euro" {{ old('moneda', $repuesto->extra->moneda) == 'euro' ? 'selected' : '' }}>Euro</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="costo">Costo:</label>
                    <input id="costo" class="form-control{{ $errors->has('costo') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="costo" value="{{ old('costo', $repuesto->extra->costo) }}" placeholder="Costo">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="generales">Gastos generales:</label>
                    <input id="generales" class="form-control{{ $errors->has('generales') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="generales" value="{{ old('generales', $repuesto->extra->generales) }}" placeholder="Gastos generales">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="envio">Envio:</label>
                    <input id="envio" class="form-control{{ $errors->has('envio') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="envio" value="{{ old('envio', $repuesto->envio) }}" placeholder="Envio">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="venta">Precio de venta: *</label>
                    <input id="venta" class="form-control{{ $errors->has('venta') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="venta" value="{{ old('venta', $repuesto->venta) }}" placeholder="Venta" required>
                  </div>
                </div>
              </div>
            </fieldset>

            <fieldset id="field-internacional" style="display: none">
              <legend>Internacional</legend>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="moneda-internacional">Moneda: *</label>
                    <select id="moneda-internacional" class="custom-select" name="moneda" required>
                      <option value="">Seleccione...</option>
                      <option value="peso" {{ old('moneda', $repuesto->extra->moneda) == 'peso' ? 'selected' : '' }}>Peso chileno</option>
                      <option value="dolar" {{ old('moneda', $repuesto->extra->moneda) == 'dolar' ? 'selected' : '' }}>Dólar</option>
                      <option value="euro" {{ old('moneda', $repuesto->extra->moneda) == 'euro' ? 'selected' : '' }}>Euro</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="costo">Costo:</label>
                    <input id="costo" class="form-control{{ $errors->has('costo') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="costo" value="{{ old('costo', $repuesto->extra->costo) }}" placeholder="Costo">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="envio1">Envio 1:</label>
                    <input id="envio1" class="form-control{{ $errors->has('envio1') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="envio1" value="{{ old('envio1', $repuesto->extra->envio1) }}" placeholder="Envio 1">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="envio2">Envio 2:</label>
                    <input id="envio2" class="form-control{{ $errors->has('envio2') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="envio2" value="{{ old('envio2', $repuesto->extra->envio2) }}" placeholder="Envio 2">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="casilla">Gastos casilla:</label>
                    <input id="casilla" class="form-control{{ $errors->has('casilla') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="casilla" value="{{ old('casilla', $repuesto->extra->casilla) }}" placeholder="Gastos casilla">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Impuestos:</label>
                    <div class="custom-control custom-radio">
                      <input type="radio" id="impuestos-25" name="impuestos" class="custom-control-input" value="25"{{ $repuesto->extra->impuestos == '25' ? ' checked' : '' }}>
                      <label class="custom-control-label" for="impuestos-25">25% del FOB</label>
                    </div>
                    <div class="custom-control custom-radio">
                      <input type="radio" id="impuestos-19" name="impuestos" class="custom-control-input" value="19"{{ $repuesto->extra->impuestos == '19' ? ' checked' : '' }}>
                      <label class="custom-control-label" for="impuestos-19">19% del FOB</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="gasto-general-internacional">Gastos generales:</label>
                    <select id="gasto-general-internacional" class="custom-select" name="generales">
                      <option value="">Seleccione...</option>
                      <option value="0" {{ old('generales', $repuesto->extra->generales) == '0' ? 'selected' : '' }}>0%</option>
                      <option value="15" {{ old('generales', $repuesto->extra->generales) == '15' ? 'selected' : '' }}>15%</option>
                      <option value="20" {{ old('generales', $repuesto->extra->generales) == '20' ? 'selected' : '' }}>20%</option>
                      <option value="25" {{ old('generales', $repuesto->extra->generales) == '25' ? 'selected' : '' }}>25%</option>
                      <option value="30" {{ old('generales', $repuesto->extra->generales) == '30' ? 'selected' : '' }}>30%</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="tramitacion">Costo tramitación:</label>
                    <input id="tramitacion" class="form-control{{ $errors->has('tramitacion') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="tramitacion" value="{{ old('tramitacion', $repuesto->extra->tramitacion) }}" placeholder="Costo tramitación">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="venta">Precio de venta: *</label>
                    <input id="venta" class="form-control{{ $errors->has('venta') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="venta" value="{{ old('venta', $repuesto->venta) }}" placeholder="Venta" required>
                  </div>
                </div>                
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
  <script type="text/javascript">
    $(document).ready(function () {
      $('#marca, #modelo, #procedencia').select2({
        placeholder: 'Seleccione...',
      });

      $('#marca').on('change',function () {
        let marca = $(this).val()

        if(!marca){ return false }

        $.ajax({
          type: 'POST',
          url: `{{ route("vehiculo.marca.modelos") }}/${marca}/modelos`,
          data: {
            _token: '{{ csrf_token() }}'
          },
          cache: false,
          dataType: 'json',
        })
        .done(function (modelos) {
          $('#modelo').html('<option value="">Seleccione...</option>');
          $.each(modelos, function(k, modelo){
            let selected = modelo.id == @json(old('modelo', $repuesto->vehiculo_modelo_id)) ? 'selected' : ''
            $('#modelo').append(`<option value="${modelo.id}" ${selected}>${modelo.modelo}</option>`)
          })

          $('#modelo').prop('disabled', false)
        })
        .fail(function () {
          $('#modelo').prop('disabled', true)
        })
      })

      $('#marca').change()

      $('#procedencia').change(function () {
        let procedencia = $(this).val()

        $('#field-local').toggle(procedencia == 'local').prop('disabled', !(procedencia == 'local'))
        $('#field-nacional').toggle(procedencia == 'nacional').prop('disabled', !(procedencia == 'nacional'))
        $('#field-internacional').toggle(procedencia == 'internacional').prop('disabled', !(procedencia == 'internacional'))
      })

      $('#procedencia').change()
      
      $('.custom-file-input').change(function(e){
        let files = e.target.files;
        let id = $(this).attr('id')

        $(this).siblings(`label[for="${id}"]`).text(files[0].name);
      });
    })
  </script>
@endsection
