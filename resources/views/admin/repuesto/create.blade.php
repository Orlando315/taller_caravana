@extends('layouts.app')

@section('title', 'Repuestos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.repuesto.index') }}"> Repuestos </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.repuesto.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="box-repuestos">
              @foreach(old('repuesto', ['1' => 1]) as $index => $null)
                <div class="repuesto-container" data-index="{{ $index }}">
                  <h4>Agregar Repuesto: <span class="repuesto-title-count">{{ $loop->iteration }}</span></h4>

                  <fieldset>
                    <legend class="title-legend">Datos del repuesto:</legend>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="marca-{{ $index }}">Marca: *</label>
                          <select id="marca-{{ $index }}" class="form-control{{ $errors->has('repuesto.'.$index.'.marca') ? ' is-invalid' : '' }}" name="repuesto[{{ $index }}][marca]" required>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="modelo-{{ $index }}">Modelo: *</label>
                          <select id="modelo-{{ $index }}" class="form-control{{ $errors->has('repuesto.'.$index.'.modelo') ? ' is-invalid' : '' }}" name="repuesto[{{ $index }}][modelo]" required disabled>
                            <option value="">Seleccione...</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="año-{{ $index }}">Año: *</label>
                          <input id="año-{{ $index }}" class="form-control{{ $errors->has('repuesto.'.$index.'.año') ? ' is-invalid' : '' }}" type="number" name="repuesto[{{ $index }}][año]" min="0" step="1" max="9999" value="{{ old('repuesto.'.$index.'.año', optional($clone)->anio) }}" placeholder="Año" required>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group m-0">
                          <label class="control-label" for="motor-{{ $index }}">Motor (cc): *</label>
                          <input id="motor-{{ $index }}" class="form-control{{ $errors->has('repuesto.'.$index.'.motor') ? ' is-invalid' : '' }}" type="number" min="0" max="9999" name="repuesto[{{ $index }}][motor]" value="{{ old('repuesto.'.$index.'.motor', optional($clone)->motor) }}" placeholder="Motor" required>
                          <small class="text-muted">Solo números</small>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="sistema-{{ $index }}">Sistema: *</label>
                          <input id="sistema-{{ $index }}" class="form-control{{ $errors->has('repuesto.'.$index.'.sistema') ? ' is-invalid' : '' }}" type="text" name="repuesto[{{ $index }}][sistema]" maxlength="50" value="{{ old('repuesto.'.$index.'.sistema', optional($clone)->sistema) }}" placeholder="Sistema" required>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="componente-{{ $index }}">Componente: *</label>
                          <input id="componente-{{ $index }}" class="form-control{{ $errors->has('repuesto.'.$index.'.componente') ? ' is-invalid' : '' }}" type="text" name="repuesto[{{ $index }}][componente]" maxlength="50" value="{{ old('repuesto.'.$index.'.componente', optional($clone)->componente) }}" placeholder="Componente" required>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="nro_parte-{{ $index }}">N° parte:</label>
                          <input id="nro_parte-{{ $index }}" class="form-control{{ $errors->has('repuesto.'.$index.'.nro_parte') ? ' is-invalid' : '' }}" type="text" name="repuesto[{{ $index }}][nro_parte]" maxlength="50" value="{{ old('repuesto.'.$index.'.nro_parte', optional($clone)->nro_parte) }}" placeholder="N° parte">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="nro_oem-{{ $index }}">N° OEM:</label>
                          <input id="nro_oem-{{ $index }}" class="form-control{{ $errors->has('repuesto.'.$index.'.nro_oem') ? ' is-invalid' : '' }}" type="text" name="repuesto[{{ $index }}][nro_oem]" maxlength="50" value="{{ old('repuesto.'.$index.'.nro_oem', optional($clone)->nro_oem) }}" placeholder="N° OEM">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="marca_oem-{{ $index }}">Marca OEM: *</label>
                          <input id="marca_oem-{{ $index }}" class="form-control{{ $errors->has('repuesto.'.$index.'.marca_oem') ? ' is-invalid' : '' }}" type="text" name="repuesto[{{ $index }}][marca_oem]" maxlength="50" value="{{ old('repuesto.'.$index.'.marca_oem', optional($clone)->marca_oem) }}" placeholder="Marca OEM" required>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group m-0">
                          <label for="foto">Foto:</label>
                          <div class="custom-file">
                            <input id="foto-{{ $index }}" class="custom-file-input" type="file" name="repuesto[{{ $index }}][foto]" lang="es" accept="image/jpeg,image/png">
                            <label class="custom-file-label" for="foto-{{ $index }}">Selecionar...</label>
                          </div>
                          <small class="text-muted">Tamaño máximo 3 MB</small>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="stock-{{ $index }}">Stock:</label>
                          <input id="stock-{{ $index }}" class="form-control{{ $errors->has('repuesto.'.$index.'.stock') ? ' is-invalid' : '' }}" type="number" name="repuesto[{{ $index }}][stock]" min="0" max="9999" value="{{ old('repuesto.'.$index.'.stock', 0) }}" placeholder="Stock">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="procedencia-{{ $index }}">Procedencia: *</label>
                          <select id="procedencia-{{ $index }}" class="custom-select" name="repuesto[{{ $index }}][procedencia]" required>
                            <option value="">Seleccione...</option>
                            <option value="local" {{ old('repuesto.'.$index.'.procedencia', optional($clone)->procedencia ?? 'local') == 'local' ? 'selected' : '' }}>Local</option>
                            <option value="nacional" {{ old('repuesto.'.$index.'.procedencia', optional($clone)->procedencia) == 'nacional' ? 'selected' : '' }}>Nacional</option>
                            <option value="internacional" {{ old('repuesto.'.$index.'.procedencia', optional($clone)->procedencia) == 'internacional' ? 'selected' : '' }}>Internacional</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </fieldset>

                  <fieldset>
                    <legend class="title-legend">Procedencia: <span id="procedencia-title-{{ $index }}"></span></legend>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="moneda-{{ $index }}">Moneda: *</label>
                          <select id="moneda-{{ $index }}" class="custom-select" name="repuesto[{{ $index }}][moneda]" required>
                            <option value="">Seleccione...</option>
                            <option value="peso"{{ old('repuesto.'.$index.'.moneda', ($clone ? $clone->extra->moneda : 'peso')) == 'peso' ? ' selected' : '' }}>Peso chileno</option>
                            <option value="dolar"{{ old('repuesto.'.$index.'.moneda', ($clone ? $clone->extra->moneda : 'peso')) == 'dolar' ? ' selected' : '' }}>Dólar</option>
                            <option value="euro"{{ old('repuesto.'.$index.'.moneda', ($clone ? $clone->extra->moneda : 'peso')) == 'euro' ? ' selected' : '' }}>Euro</option>
                          </select>
                        </div>
                        <div class="form-group m-0" style="display: none">
                          <label class="control-label" for="moneda-valor-{{ $index }}">Especificar valor: *</label>
                          <input id="moneda-valor-{{ $index }}" class="form-control{{ $errors->has('repuesto.'.$index.'.moneda_valor') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="repuesto[{{ $index }}][moneda_valor]" value="{{ old('repuesto.'.$index.'.moneda_valor', ($clone ? $clone->extra->moneda_valor : '')) }}" placeholder="Especificar valor">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="costo-{{ $index }}">Costo:</label>
                          <input id="costo-{{ $index }}" class="form-control{{ $errors->has('repuesto.'.$index.'.costo') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="repuesto[{{ $index }}][costo]" maxlength="50" value="{{ old('repuesto.'.$index.'.costo', ($clone ? $clone->extra->costo : '')) }}" placeholder="Costo">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="generales-{{ $index }}">Gastos generales:</label>
                          <input id="generales-{{ $index }}" class="form-control{{ $errors->has('repuesto.'.$index.'.generales') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="repuesto[{{ $index }}][generales]" maxlength="50" value="{{ old('repuesto.'.$index.'.generales', ($clone ? $clone->extra->generales : '')) }}" placeholder="Gastos generales">
                        </div>
                        <div class="form-group" style="display: none">
                          <label class="control-label" for="generales-internacional-{{ $index }}">Gastos generales:</label>
                          <select id="generales-internacional-{{ $index }}" class="custom-select field-internacional-{{ $index }}" name="repuesto[{{ $index }}][generales]" disabled>
                            <option value="">Seleccione...</option>
                            <option value="0"{{ old('repuesto.'.$index.'.generales', ($clone ? $clone->extra->generales : '')) == '0' ? ' selected' : '' }}>Monto específico</option>
                            <option value="15"{{ old('repuesto.'.$index.'.generales', ($clone ? $clone->extra->generales : '')) == '15' ? ' selected' : '' }}>15%</option>
                            <option value="20"{{ old('repuesto.'.$index.'.generales', ($clone ? $clone->extra->generales : '')) == '20' ? ' selected' : '' }}>20%</option>
                            <option value="25"{{ old('repuesto.'.$index.'.generales', ($clone ? $clone->extra->generales : '')) == '25' ? ' selected' : '' }}>25%</option>
                            <option value="30"{{ old('repuesto.'.$index.'.generales', ($clone ? $clone->extra->generales : '')) == '30' ? ' selected' : '' }}>30%</option>
                          </select>
                        </div>
                        <div class="form-group m-0" style="display: none">
                          <label class="control-label" for="generales_total-internacional-{{ $index }}">Especificar gastos generales:</label>
                          <input id="generales_total-internacional-{{ $index }}" class="form-control{{ $errors->has('repuesto.'.$index.'.generales_total') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="repuesto[{{ $index }}][generales_total]" value="{{ old('repuesto.'.$index.'.generales_total', ($clone ? $clone->extra->generales_total : '')) }}" placeholder="Especificar">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group" style="display: none">
                          <label class="control-label" for="envio-{{ $index }}">Envio:</label>
                          <input id="envio-{{ $index }}" class="form-control field-nacional-{{ $index }}{{ $errors->has('repuesto.'.$index.'.envio') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="repuesto[{{ $index }}][envio]" value="{{ old('repuesto.'.$index.'.envio', optional($clone)->envio) }}" placeholder="Envio">
                        </div>
                        <div class="form-group" style="display: none">
                          <label class="control-label" for="impuestos-internacional-{{ $index }}">Impuestos:</label>
                          <select id="impuestos-internacional-{{ $index }}" class="custom-select field-internacional-{{ $index }}" name="repuesto[{{ $index }}][impuestos]">
                            <option value="">Seleccione...</option>
                            <option value="0"{{ old('repuesto.'.$index.'.impuestos', ($clone ? $clone->extra->impuestos : '')) == '0' ? ' selected' : '' }}>Monto específico</option>
                            <option value="19"{{ old('repuesto.'.$index.'.impuestos', ($clone ? $clone->extra->impuestos : '')) == '19' ? ' selected' : '' }}>19% del FOB</option>
                            <option value="25"{{ old('repuesto.'.$index.'.impuestos', ($clone ? $clone->extra->impuestos : '')) == '25' ? ' selected' : '' }}>25% del FOB</option>
                          </select>
                        </div>
                        <div class="form-group m-0" style="display: none">
                          <label class="control-label" for="impuestos_total-internacional-{{ $index }}">Especificar impuestos:</label>
                          <input id="impuestos_total-internacional-{{ $index }}" class="form-control{{ $errors->has('repuesto.'.$index.'.impuestos_total') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="repuesto[{{ $index }}][impuestos_total]" value="{{ old('repuesto.'.$index.'.impuestos_total', ($clone ? $clone->extra->impuestos_total : '')) }}" placeholder="Especificar">
                        </div>
                      </div>
                    </div>

                    <div class="row group-field-internacional-{{ $index }}" style="display:none">
                      <div class="col-md-3">
                        <div class="form-group" style="display: none">
                          <label class="control-label" for="envio1-internacional-{{ $index }}">Envio 1:</label>
                          <input id="envio1-internacional-{{ $index }}" class="form-control field-internacional-{{ $index }}{{ $errors->has('repuesto.'.$index.'.envio1') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="repuesto[{{ $index }}][envio1]" value="{{ old('repuesto.'.$index.'.envio1', ($clone ? $clone->extra->envio1 : '')) }}" placeholder="Envio 1">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group" style="display: none">
                          <label class="control-label" for="envio2-internacional-{{ $index }}">Envio 2:</label>
                          <input id="envio2-internacional-{{ $index }}" class="form-control field-internacional-{{ $index }}{{ $errors->has('repuesto.'.$index.'.envio2') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="repuesto[{{ $index }}][envio2]" value="{{ old('repuesto.'.$index.'.envio2', ($clone ? $clone->extra->envio2 : '')) }}" placeholder="Envio 2">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group" style="display: none">
                          <label class="control-label" for="casilla-internacional-{{ $index }}">Gastos casilla:</label>
                          <input id="casilla-internacional-{{ $index }}" class="form-control field-internacional-{{ $index }}{{ $errors->has('repuesto.'.$index.'.casilla') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="repuesto[{{ $index }}][casilla]" value="{{ old('repuesto.'.$index.'.casilla', ($clone ? $clone->extra->casilla : '')) }}" placeholder="Gastos casilla">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group" style="display: none">
                          <label class="control-label" for="tramitacion-internacional-{{ $index }}">Costo tramitación:</label>
                          <input id="tramitacion-internacional-{{ $index }}" class="form-control field-internacional-{{ $index }}{{ $errors->has('repuesto.'.$index.'.tramitacion') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="repuesto[{{ $index }}][tramitacion]" maxlength="50" value="{{ old('repuesto.'.$index.'.tramitacion', ($clone ? $clone->extra->tramitacion : '')) }}" placeholder="Costo tramitación">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="venta-{{ $index }}">Precio de venta: *</label>
                          <input id="venta-{{ $index }}" class="form-control{{ $errors->has('repuesto.'.$index.'.venta') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="repuesto[{{ $index }}][venta]" maxlength="50" value="{{ old('repuesto.'.$index.'.venta', optional($clone)->venta) }}" placeholder="Venta" required>
                          <button class="btn btn-simple btn-link btn-sm btn-sugerir" type="button" role="button" data-index="{{ $index }}">
                            <i class="fa fa-calculator" aria-hidden="true"></i> Sugerir precio
                          </button>
                        </div>
                      </div>
                    </div>
                  </fieldset>

                  <fieldset>
                    <legend class="title-legend">Otros: <span id="otros-title-{{ $index }}"></span></legend>

                    <div class="form-group">
                      <label for="comentarios-{{ $index }}">Comentarios:</label>
                      <textarea id="comentarios-{{ $index }}" class="form-control{{ $errors->has('repuesto.'.$index.'.comentarios') ? ' is-invalid' : '' }}" name="repuesto[{{ $index }}][comentarios]" maxlength="250">{{ old('repuesto.'.$index.'.comentarios') }}</textarea>
                    </div>
                  </fieldset>
                </div>
              @endforeach
            </div>

            <div class="alert alert-danger alert-important"{!! (count($errors) > 0) ? '' : 'style="display:none"' !!}>
              <ul id="alert-repuesto" class="m-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="text-center">
              <button class="btn btn-sm btn-fill btn-primary mb-3 btn-add-repuesto" type="button"><i class="fa fa-plus"></i> Agregar otro repuesto</button>
            </div>

            <div class="form-group text-right">
              <a class="btn btn-default" href="{{ route('admin.repuesto.index') }}"><i class="fa fa-reply"></i> Atras</a>
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
    const BTN_REPUESTO = $('.btn-add-repuesto');
    const MARCAS = @json($marcas);
    const OLD_VALUES = @json(old('repuesto', []));
    const PORCENTAJE_GANANCIA = @json(Auth::user()->getGlobalGanancia());
    const CLONE = @json(!is_null($clone));
    let GLOBAL_MARCAS_OPTIONS;

    $(document).ready(function () {
      $('select[id^="marca-"], select[id^="modelo-"]').select2({
        placeholder: 'Seleccione...',
      });

      $('.box-repuestos').on('change', 'select[id^="marca-"]', function () {
        let index = getIndex(this);
        let marca = $(this).val();

        if(!marca || !index){ return false }

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
          $(`#modelo-${index}`).html('<option value="">Seleccione...</option>');
          let oldSelected = index ? getOldValue(index, 'modelo') : '';

          if(index == 1 && CLONE){
            oldSelected = @json($clone->vehiculo_modelo_id);
          }

          $.each(modelos, function(k, modelo){
            let selected = modelo.id == oldSelected ? ' selected' : '';
            $(`#modelo-${index}`).append(`<option value="${modelo.id}"${selected}>${modelo.modelo}</option>`)
          })

          $(`#modelo-${index}`).prop('disabled', false)
        })
        .fail(function () {
          $(`#modelo-${index}`).prop('disabled', true)
        })
      })

      $('.box-repuestos').on('change', 'select[id^="procedencia-"]', function () {
        let index = getIndex(this);
        let procedencia = $(this).val();

        $(`#procedencia-title-${index}`).text(procedencia.charAt(0).toUpperCase() + procedencia.slice(1))

        $(`#generales-${index}`).prop('disabled', (procedencia == 'internacional')).closest('.form-group').toggle(!(procedencia == 'internacional'))
        $(`.field-local-${index}`).prop('disabled', !(procedencia == 'local')).closest('.form-group').toggle(procedencia == 'local')
        $(`.field-nacional-${index}`).prop('disabled', !(procedencia == 'nacional')).closest('.form-group').toggle(procedencia == 'nacional')
        $(`.field-internacional-${index}`).prop('disabled', !(procedencia == 'internacional')).closest('.form-group').toggle(procedencia == 'internacional')
        $(`.group-field-internacional-${index}`).toggle(procedencia == 'internacional')

        if(procedencia != 'internacional'){
          $(`#generales_total-internacional-${index}, #impuestos_total-internacional-${index}`).prop('disabled', true).closest('.form-group').toggle(false);
        }else{
          $(`#impuestos-internacional-${index}, #generales-internacional-${index}`).change();
        }
      })
      $('select[id^="procedencia-"]').change()
      
      $('.box-repuestos').on('change', '.custom-file-input', function(e){
        let files = e.target.files;
        let id = $(this).attr('id');

        $(this).siblings(`label[for="${id}"]`).text(files[0].name);
      });

      $('.box-repuestos').on('change', 'select[id^="impuestos-internacional-"]', function () {
        let index = getIndex(this);
        let isZero = $(this).val() == '0';
        $(`#impuestos_total-internacional-${index}`).prop('disabled', !isZero).closest('.form-group').toggle(isZero);
      })
      $('select[id^="impuestos-internacional-"]').change();

      $('.box-repuestos').on('change', 'select[id^="generales-internacional-"]', function () {
        let index = getIndex(this);
        let isZero = $(this).val() == '0';
        $(`#generales_total-internacional-${index}`).prop('disabled', !isZero).closest('.form-group').toggle(isZero);
      })
      $('select[id^="generales-internacional-"]').change();

      $('.box-repuestos').on('change', 'select[id^="moneda-"]', function () {
        let index = getIndex(this);
        let isPeso = $(this).val() == 'peso';

        $(`#moneda-valor-${index}`).prop({'disabled': isPeso, 'required': !isPeso}).closest('.form-group').toggle(!isPeso);
      })
      $('select[id^="moneda-"]').change();

      /* evento para agregar repuestos */
      BTN_REPUESTO.click(addRepuesto);

      /* evento para eliminar repuestos */
      $('.box-repuestos').on('click', '.btn-delete-repuesto', deleteRepuesto);

      /* Sugerir precio de venta*/
      $('.box-repuestos').on('click', '.btn-sugerir', precioSugerido);

      /* inicializar los select de Marca */
      (function () {
        $.each($('select[id^="marca-"]'), function () {
          let index = getIndex(this);
          let options = buildMarcaOptions(index);

          $(`#marca-${index}`).append(options);
          $(`#marca-${index}`).change();
        });
      })();

      /* crear el select globrl de Marca para los repuetos nuevos */
      (function () {
        GLOBAL_MARCAS_OPTIONS = buildMarcaOptions();
      })();
    }); /* DOM Ready */

    /* Construir los options del select de marcas */
    function buildMarcaOptions(index = null){
      let marcasOptions = '<option value="">Seleccione...</option>';
      let oldSelected = index ? getOldValue(index, 'marca') : '';

      if(index == 1 && CLONE){
        oldSelected = @json($clone->vehiculo_marca_id);
      }

      $.each(MARCAS, function (value, marca){
        let selected = oldSelected == value ? ' selected' : '';
        marcasOptions += `<option value="${value}"${selected}>${marca}</option>`;
      })

      return marcasOptions;
    }

    /* Obtenr el valor anterior del campo expecificado, perteneciente al index */
    function getOldValue(index, field){
      return OLD_VALUES.hasOwnProperty(index) ? (OLD_VALUES[index][field] || null) : null;
    }

    /* Obtener el index del container del elemento especificado */
    function getIndex(element){
      return $(element).closest('.repuesto-container').data('index');
    }

    /* Agregar repuesto */
    function addRepuesto(){
      BTN_REPUESTO.prop('disabled', true);

      let count = $('.repuesto-container').length;

      if(count <= 9){
        let index = Date.now();
        let template = repuestoTemplate(index, count + 1);
        $('.box-repuestos').append(template);

        $(`#procedencia-${index}`);
        $(`#marca-${index}, #modelo-${index}`).select2({
          placeholder: 'Seleccione...',
        });
        count++;
      }

      BTN_REPUESTO.prop('disabled', count >= 10);
    }

    /* Eliminar repuesto */
    function deleteRepuesto(){
      let index = $(this).data('index');
      $(`#repuesto-${index}`).remove();
      fixCount();

      BTN_REPUESTO.prop('disabled', $('.repuesto-container').length >= 10);
    }

    /* Arreglar la numeracion de los repuestos */
    function fixCount(){
      $.each($('.repuesto-title-count'), function (k, v) {
        $(this).text(k+1);
      })
    }

    /* Sugerir precio de venta */
    function precioSugerido() {
      let index = $(this).data('index');
      let moneda = $(`#moneda-${index}`).val();
      let valorMoneda = moneda == 'peso' ? 1 : +$(`#moneda-valor-${index}`).val();

      if(moneda != 'peso' && !valorMoneda){
        showAlert('Debe completar el valor de la moneda seleccionada');
        return;
      }

      let type = $(`#procedencia-${index}`).val();
      let field = $(`#venta-${index}`);
      let costo = (+$(`#costo-${index}`).val() * valorMoneda);
      let generales = +$(`#generales-${index}`).val();
      let subtotal = 0;

      if(type == 'local'){
        subtotal = (costo + (generales * valorMoneda));
      }else if(type == 'nacional'){
        let envio = +$(`#envio-${index}`).val();
        subtotal += costo + (generales * valorMoneda) + (envio * valorMoneda);
      }else{
        let envio1 = (+$(`#envio1-internacional-${index}`).val() * valorMoneda);
        let envio2 = (+$(`#envio2-internacional-${index}`).val() * valorMoneda);
        let casilla = +$(`#casilla-internacional-${index}`).val();
        let impuestos = +$(`#impuestos-internacional-${index}`).val();
        let impuestosTotal = (+$(`#impuestos_total-internacional-${index}`).val() * valorMoneda);
        let generalesTotal = (+$(`#generales_total-internacional-${index}`).val() * valorMoneda);
        let tramitacion = +$(`#tramitacion-internacional-${index}`).val();
        let generalesInternacional = +$(`#generales-internacional-${index}`).val();

        subtotal += costo + envio1 + envio2;
        impuestosTotal = (impuestos > 0) ? calculateImpuestosTotal(subtotal, impuestos) : impuestosTotal;
        subtotal += impuestosTotal + casilla;
        generalesTotal = (generalesInternacional > 0) ? calculateGeneralesTotal(subtotal, generalesInternacional) : generalesTotal;
        subtotal += generalesTotal + tramitacion;
      }

      let total = subtotal + ((subtotal * PORCENTAJE_GANANCIA) / 100);
      field.val(total.toFixed(2));
    }

    // Solo internacional
    function calculateImpuestosTotal(costoBase, impuestos) {
      return (costoBase * impuestos) / 100;
    }

    // Solo internacional
    function calculateGeneralesTotal(costoBase, generales) {
      return (costoBase * generales) / 100;
    }

    // Mostrar mensaje de error
    function showAlert(error = 'Ha ocurrido un error.'){
      $('#alert-repuesto').empty().append(`<li>${error}</li>`);
      $('#alert-repuesto').closest('.alert').show().delay(5000).hide('slow');
      scrollToError();
    }

    function scrollToError(){
      $('.main-panel').animate({
        scrollTop: $('#alert-repuesto').offset().top
      }, 500);
    }

    /* Plantilla de los campos para agregar un Repuesto */
    let repuestoTemplate = function (index, count){
      return `<div id="repuesto-${index}" class="repuesto-container" data-index="${index}">
                <h4><button class="btn btn-xs btn-danger btn-delete-repuesto" type="button" data-index="${index}"><i class="fa fa-times"></i></button> | Agregar Repuesto: <span class="repuesto-title-count">${count}</span></h4>
                <fieldset>
                  <legend class="title-legend">Datos del repuesto:</legend>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="marca-${index}">Marca: *</label>
                        <select id="marca-${index}" class="form-control" name="repuesto[${index}][marca]" required>
                          ${GLOBAL_MARCAS_OPTIONS}
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="modelo-${index}">Modelo: *</label>
                        <select id="modelo-${index}" class="form-control" name="repuesto[${index}][modelo]" required disabled>
                          <option value="">Seleccione...</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="año-${index}">Año: *</label>
                        <input id="año-${index}" class="form-control" type="number" name="repuesto[${index}][año]" min="0" step="1" max="9999" value="" placeholder="Año" required>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group m-0">
                        <label class="control-label" for="motor-${index}">Motor (cc): *</label>
                        <input id="motor-${index}" class="form-control" type="number" min="0" max="9999" name="repuesto[${index}][motor]" value="" placeholder="Motor" required>
                        <small class="text-muted">Solo números</small>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="sistema-${index}">Sistema: *</label>
                        <input id="sistema-${index}" class="form-control" type="text" name="repuesto[${index}][sistema]" maxlength="50" value="" placeholder="Sistema" required>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="componente-${index}">Componente: *</label>
                        <input id="componente-${index}" class="form-control" type="text" name="repuesto[${index}][componente]" maxlength="50" value="" placeholder="Componente" required>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="nro_parte-${index}">N° parte:</label>
                        <input id="nro_parte-${index}" class="form-control" type="text" name="repuesto[${index}][nro_parte]" maxlength="50" value="" placeholder="N° parte">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="nro_oem-${index}">N° OEM:</label>
                        <input id="nro_oem-${index}" class="form-control" type="text" name="repuesto[${index}][nro_oem]" maxlength="50" value="" placeholder="N° OEM">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="marca_oem-${index}">Marca OEM: *</label>
                        <input id="marca_oem-${index}" class="form-control" type="text" name="repuesto[${index}][marca_oem]" maxlength="50" value="" placeholder="Marca OEM" required>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group m-0">
                        <label for="foto">Foto:</label>
                        <div class="custom-file">
                          <input id="foto-${index}" class="custom-file-input" type="file" name="repuesto[${index}][foto]" lang="es" accept="image/jpeg,image/png">
                          <label class="custom-file-label" for="foto-${index}">Selecionar...</label>
                        </div>
                        <small class="text-muted">Tamaño máximo 12 MB</small>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="stock-${index}">Stock:</label>
                        <input id="stock-${index}" class="form-control" type="number" name="repuesto[${index}][stock]" min="0" max="9999" value="0" placeholder="Stock">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="procedencia-${index}">Procedencia: *</label>
                        <select id="procedencia-${index}" class="custom-select" name="repuesto[${index}][procedencia]" required>
                          <option value="">Seleccione...</option>
                          <option value="local">Local</option>
                          <option value="nacional">Nacional</option>
                          <option value="internacional">Internacional</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </fieldset>
                <fieldset>
                  <legend class="title-legend">Procedencia: <span id="procedencia-title-${index}"></span></legend>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="moneda-${index}">Moneda: *</label>
                        <select id="moneda-${index}" class="custom-select" name="repuesto[${index}][moneda]" required>
                          <option value="">Seleccione...</option>
                          <option value="peso">Peso chileno</option>
                          <option value="dolar">Dólar</option>
                          <option value="euro">Euro</option>
                        </select>
                      </div>
                      <div class="form-group m-0" style="display: none">
                        <label class="control-label" for="moneda-valor-${index}">Especificar valor: *</label>
                        <input id="moneda-valor-${index}" class="form-control" type="number" step="0.01" min="0" max="99999999" name="repuesto[${index}][moneda_valor]" value="" placeholder="Especificar valor">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="costo-${index}">Costo:</label>
                        <input id="costo-${index}" class="form-control" type="number" step="0.01" min="0" max="99999999" name="repuesto[${index}][costo]" maxlength="50" value="" placeholder="Costo">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="generales-${index}">Gastos generales:</label>
                        <input id="generales-${index}" class="form-control" type="number" step="0.01" min="0" max="99999999" name="repuesto[${index}][generales]" maxlength="50" value="" placeholder="Gastos generales">
                      </div>
                      <div class="form-group" style="display: none">
                        <label class="control-label" for="generales-internacional-${index}">Gastos generales:</label>
                        <select id="generales-internacional-${index}" class="custom-select field-internacional-${index}" name="repuesto[${index}][generales]" disabled>
                          <option value="">Seleccione...</option>
                          <option value="0">Monto específico</option>
                          <option value="15">15%</option>
                          <option value="20">20%</option>
                          <option value="25">25%</option>
                          <option value="30">30%</option>
                        </select>
                      </div>
                      <div class="form-group m-0" style="display: none">
                        <label class="control-label" for="generales_total-internacional-${index}">Especificar gastos generales:</label>
                        <input id="generales_total-internacional-${index}" class="form-control" type="number" step="0.01" min="0" max="99999999" name="repuesto[${index}][generales_total]" value="" placeholder="Especificar">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group" style="display: none">
                        <label class="control-label" for="envio-${index}">Envio:</label>
                        <input id="envio-${index}" class="form-control field-nacional-${index}" type="number" step="0.01" min="0" max="99999999" name="repuesto[${index}][envio]" value="" placeholder="Envio">
                      </div>
                      <div class="form-group" style="display: none">
                        <label class="control-label" for="impuestos-internacional-${index}">Impuestos:</label>
                        <select id="impuestos-internacional-${index}" class="custom-select field-internacional-${index}" name="repuesto[${index}][impuestos]">
                          <option value="">Seleccione...</option>
                          <option value="0">Monto específico</option>
                          <option value="19">19% del FOB</option>
                          <option value="25">25% del FOB</option>
                        </select>
                      </div>
                      <div class="form-group m-0" style="display: none">
                        <label class="control-label" for="impuestos_total-internacional-${index}">Especificar impuestos:</label>
                        <input id="impuestos_total-internacional-${index}" class="form-control" type="number" step="0.01" min="0" max="99999999" name="repuesto[${index}][impuestos_total]" value="" placeholder="Especificar">
                      </div>
                    </div>
                  </div>
                  <div class="row group-field-internacional-${index}" style="display:none">
                    <div class="col-md-3">
                      <div class="form-group" style="display: none">
                        <label class="control-label" for="envio1-internacional-${index}">Envio 1:</label>
                        <input id="envio1-internacional-${index}" class="form-control field-internacional-${index}" type="number" step="0.01" min="0" max="99999999" name="repuesto[${index}][envio1]" value="" placeholder="Envio 1">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group" style="display: none">
                        <label class="control-label" for="envio2-internacional-${index}">Envio 2:</label>
                        <input id="envio2-internacional-${index}" class="form-control field-internacional-${index}" type="number" step="0.01" min="0" max="99999999" name="repuesto[${index}][envio2]" value="" placeholder="Envio 2">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group" style="display: none">
                        <label class="control-label" for="casilla-internacional-${index}">Gastos casilla:</label>
                        <input id="casilla-internacional-${index}" class="form-control field-internacional-${index}" type="number" step="0.01" min="0" max="99999999" name="repuesto[${index}][casilla]" value="" placeholder="Gastos casilla">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group" style="display: none">
                        <label class="control-label" for="tramitacion-internacional-${index}">Costo tramitación:</label>
                        <input id="tramitacion-internacional-${index}" class="form-control field-internacional-${index}" type="number" step="0.01" min="0" max="99999999" name="repuesto[${index}][tramitacion]" maxlength="50" value="" placeholder="Costo tramitación">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label" for="venta-${index}">Precio de venta: *</label>
                        <input id="venta-${index}" class="form-control" type="number" step="0.01" min="0" max="99999999" name="repuesto[${index}][venta]" maxlength="50" value="" placeholder="Venta" required>
                        <button class="btn btn-simple btn-link btn-sm btn-sugerir" type="button" role="button" data-index="${index}">
                          <i class="fa fa-calculator" aria-hidden="true"></i> Sugerir precio
                        </button>
                      </div>
                    </div>
                  </div>
                </fieldset>
                <fieldset>
                  <legend class="title-legend">Otros: <span id="otros-title-${index}"></span></legend>
                  <div class="form-group">
                    <label for="comentarios-${index}">Comentarios:</label>
                    <textarea id="comentarios-${index}" class="form-control" name="repuesto[${index}][comentarios]" maxlength="250"></textarea>
                  </div>
                </fieldset>
              </div>`;
    }
  </script>
@endsection
