@extends('layouts.app')

@section('title', 'Situación - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proceso.show', ['proceso' => $proceso->id]) }}"> Situación </a>
@endsection

@section('content')
  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-body">
          <h4>Generar Hoja de situación</h4>
          
          <h5 class="text-center">{{ $proceso->cliente->nombre().' | '.$proceso->vehiculo->vehiculo() }}</h5>
          
          <form id="form-load-item" action="#" method="POST">
            <div class="row justify-content-center">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label" for="tipo">Tipo: *</label>
                  <select id="tipo" class="custom-select" required>
                    <option value="insumo">Insumos</option>
                    <option value="repuesto">Repuestos</option>
                    <option value="horas">Horas hombre</option>
                    <option value="otros">Otros</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-5">
                <div id="set-insumo" class="form-group">
                  <label for="insumo">Insumo:</label>
                  <select id="insumo" class="form-control" name="">
                    <option value="">Seleccione...</option>
                    @foreach($insumos as $insumo)
                      <option value="{{ $insumo->id }}"
                        data-titulo="{{ $insumo->descripcion() }}"
                        data-venta="{{ $insumo->stockEnUso->venta }}"
                        data-stock="{{ $insumo->getStock() }}"
                        data-costo="{{ $insumo->stockEnUso->coste }}">{{ $insumo->descripcion() }}</option>
                    @endforeach
                  </select>
                </div>

                <div id="set-repuesto" class="form-group" style="display: none;">
                  <label for="repuesto">Repusto:</label>
                  <select id="repuesto" class="form-control" style="width: 100%">
                    <option value="">Seleccione...</option>
                    @foreach($repuestos as $repuesto)
                      <option value="{{ $repuesto->id }}"
                        data-titulo="{{ $repuesto->descripcion() }}"
                        data-venta="{{ $repuesto->venta }}"
                        data-stock=""
                        data-costo="{{ $repuesto->extra->costo_total }}">{{ $repuesto->descripcion() }}</option>
                    @endforeach
                  </select>
                </div>

                <div id="set-otros" class="form-group" style="display: none">
                  <label for="venta">Valor de venta:</label>
                  <input id="venta" class="form-control" type="number" min="0" max="9999999">
                </div>
              </div><!-- .col-md-5 -->

              <div class="col-md-3">
                <div class="form-group">
                  <label for="cantidad">Cantidad:</label>
                  <input id="cantidad" class="form-control" type="number" min="1" max="9999" required>
                </div>
              </div><!-- .col-md-3 -->

              <div class="col-md-4">
                <fieldset id="set-descuento">
                  <div class="form-group m-0">
                    <label for="descuento">Descuento:</label>
                    <input id="descuento" class="form-control" type="number" min="0">
                  </div>

                  <div class="form-group m-0">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input id="porcentaje" class="form-check-input" type="checkbox">
                        <span class="form-check-sign"></span>
                        Descuento en procentaje
                      </label>
                    </div>
                  </div>
                </fieldset>
              </div>
            </div><!-- .row -->

            <div id="otros-descripcion" class="row">
              <div class="col-12 pt-0">
                <div class="form-group m-0">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" class="form-control" maxlength="500"></textarea>
                </div>
              </div>
            </div>

            <div id="item-information" class="row" style="display: none">
              <div class="col-12">
                <p class="m-0"><strong>Costo total:</strong> <span class="selected-costo">-</span></p>
                <p class="m-0"><strong>Valor venta:</strong> <span class="selected-venta">-</span></p>
              </div>
            </div>

            <center>
              <button class="btn btn-primary btn-fill btn-sm" type="submit"><i class="fa fa-plus"></i> Agregar item</button>
            </center>
          </form><!-- form -->
          
          <hr>

          <form action="{{ route('admin.situacion.store', ['proceso' => $proceso->id]) }}" method="POST">
            @csrf
            <div class="table-responsive">
              <table class="table table-striped table-sm table-bordered">
                <thead>
                  <tr>
                    <th class="text-center">-</th>
                    <th class="text-center">Items / Descripción</th>
                    <th class="text-center">Valor venta</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Valor final</th>
                    <th class="text-center">Precio costo</th>
                    <th class="text-center">Utilidad</th>
                    <th class="text-center">Decuento</th>
                  </tr>
                </thead>
                <tbody id="tbody">
                  @if(old('datos'))
                    @foreach(old('datos') as $dato)
                      <tr id="tr-{{ $loop->iteration }}" class="tr-dato">
                        <td>
                          <button class="btn btn-danger btn-fill btn-xs btn-delete" type="button" role="button" data-id="{{ $loop->iteration }}"><i class="fa fa-trash"></i></button>
                        </td>
                        <td>
                          {{ old('datos.'.$loop->iteration.'.titulo') }}
                          @if(old('datos.'.$loop->iteration.'.type') == 'horas' || old('datos.'.$loop->iteration.'.type') == 'otros')
                            <p class="m-0"><small>{{ old('datos.'.$loop->iteration.'.descripcion') }}</small></p>
                          @endif
                          <input type="hidden" name="datos[{{ $loop->iteration }}][item]" value="{{ old('datos.'.$loop->iteration.'.item') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][type]" value="{{ old('datos.'.$loop->iteration.'.type') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][titulo]" value="{{ old('datos.'.$loop->iteration.'.titulo') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descripcion]" value="{{ old('datos.'.$loop->iteration.'.descripcion') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.valor_venta') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][valor_venta]" value="{{ old('datos.'.$loop->iteration.'.valor_venta') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.cantidad') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][cantidad]" value="{{ old('datos.'.$loop->iteration.'.cantidad') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.total') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][total]" value="{{ old('datos.'.$loop->iteration.'.total') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.costo') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][costo]" value="{{ old('datos.'.$loop->iteration.'.costo') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.utilidad') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][utilidad]" value="{{ old('datos.'.$loop->iteration.'.utilidad') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.descuento_text') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descuento_text]" value="{{ old('datos.'.$loop->iteration.'.descuento_text') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descuento_type]" value="{{ old('datos.'.$loop->iteration.'.descuento_type') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descuento]" value="{{ old('datos.'.$loop->iteration.'.descuento') }}">
                        </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
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
              <a class="btn btn-default" href="{{ route('admin.proceso.show', ['proceso' => $proceso->id]) }}"><i class="fa fa-reply"></i> Atras</a>
              <button id="btn-cotizacion" class="btn btn-primary" type="submit" disabled><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form><!-- form -->
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function () {
      $('#insumo, #repuesto').select2({
        placeholder: 'Seleccione...',
      });

      $('#tbody').on('click', '.btn-delete', deleteRow)

      $('#porcentaje').change(function (){ 
        let check = $(this).is(':checked')

        $('#descuento').attr('max', check ? 100 : 99999999);
      })

      $('#tipo').change(function () {
        let tipo = $(this).val()

        $('#set-insumo').toggle(tipo == 'insumo')
        $('#set-repuesto').toggle(tipo == 'repuesto')
        $('#set-otros, #otros-descripcion').toggle(tipo == 'horas' || tipo == 'otros')

        $('#insumo').prop('required', tipo == 'insumo')
        $('#repuesto').prop('required', tipo == 'repuesto')
        $('#venta').prop('required', tipo == 'horas' || tipo == 'otros')
        $('#set-descuento').prop('disabled', tipo != 'horas')

        $('#item-information').toggle(tipo == 'insumo' || tipo == 'repuesto')

        if(tipo == 'insumo' || tipo == 'repuesto'){
          $(`#${tipo}`).val(null).trigger('change');
        }

        $('.selected-venta,.selected-costo').text('-')
      })

      $('#tipo').change()

      $('#form-load-item').submit(function (e) {
        e.preventDefault()

        $('#btn-cotizacion').prop('disabled', false)

        let tipo = $('#tipo').val();
        let useSelect  = (tipo == 'insumo' || tipo == 'repuesto')

        // Solo cuando es Insumo o Repuesto
        let value = useSelect ? $(`#${tipo}`).val() : null
        let option = useSelect ? $(`#${tipo} option[value="${value}"]`) : null

        let cantidad = $('#cantidad').val()
        let venta = (useSelect && $(option).data('venta')) ? +$(option).data('venta') : +$('#venta').val()
        let total = (venta * cantidad)
        let costo = (useSelect && $(option).data('costo')) ? (+$(option).data('costo') * cantidad) : 0
        let utilidad = 0
        let item = {
            item: useSelect ? value : '',
            type: tipo,
            descripcion: $('#descripcion').val(),
            titulo: useSelect ? $(option).data('titulo') : ( tipo == 'horas' ? 'Horas hombre' : 'Otros'),
            venta: venta,
            cantidad: cantidad,
            total: total,
            costo: costo,
            utilidad: useSelect ? (total - costo) : (venta * cantidad),
            descuento: {
              text: '',
              tipo: '',
              cantidad: '',
            }
          }

        if(tipo == 'horas'){
          let descuento = $('#descuento').val() ? +$('#descuento').val() : 0
          let tipoPorcentaje = $('#porcentaje').is(':checked')
          let totalDescuento = tipoPorcentaje ? ((total * descuento) / 100) : descuento

          item.descuento.text = tipoPorcentaje ? `${totalDescuento.toLocaleString('de-DE')} (${descuento}%)` : totalDescuento.toLocaleString('de-DE')
          item.descuento.tipo = tipoPorcentaje
          item.descuento.cantidad = descuento
        }

        let index = ($('.tr-dato').length + 1)

        $('#tbody').append(dato(index, item))

        $('#cantidad, #descuento, #venta, #descripcion').val('')
        $('#porcentaje').prop('checked', false)
      })// Send form

      toggleBtn()

      $('#insumo, #repuesto').change(function () {
        let val = $(this).val(),
            option = $(this).find(`option[value="${val}"]`),
            venta = +option.data('venta'),
            costo = +option.data('costo');

        $('.selected-venta').text(venta.toLocaleString('de-DE'))
        $('.selected-costo').text(costo.toLocaleString('de-DE'))
      })
    })

    let dato = function(index, dato) {
      return `<tr id="tr-${index}" class="tr-dato">
                <td>
                  <button class="btn btn-danger btn-fill btn-xs btn-delete" type="button" role="button" data-id="${index}"><i class="fa fa-trash"></i></button>
                </td>
                <td>
                  ${dato.titulo}
                  ${dato.type == 'horas' ? ('<p class="0"><small>'+dato.descripcion+'</small></p>') : ''}
                  <input type="hidden" name="datos[${index}][item]" value="${dato.item}">
                  <input type="hidden" name="datos[${index}][type]" value="${dato.type}">
                  <input type="hidden" name="datos[${index}][titulo]" value="${dato.titulo}">
                  <input type="hidden" name="datos[${index}][descripcion]" value="${dato.descripcion}">
                </td>
                <td class="text-right">
                  ${dato.venta.toLocaleString('de-DE')}
                  <input type="hidden" name="datos[${index}][valor_venta]" value="${dato.venta}">
                </td>
                <td class="text-right">
                  ${dato.cantidad}
                  <input type="hidden" name="datos[${index}][cantidad]" value="${dato.cantidad}">
                </td>
                <td class="text-right">
                  ${dato.total.toLocaleString('de-DE')}
                  <input type="hidden" name="datos[${index}][total]" value="${dato.total}">
                </td>
                <td class="text-right">
                  ${dato.costo.toLocaleString('de-DE')}
                  <input type="hidden" name="datos[${index}][costo]" value="${dato.costo}">
                </td>
                <td class="text-right">
                  ${dato.utilidad.toLocaleString('de-DE')}
                  <input type="hidden" name="datos[${index}][utilidad]" value="${dato.utilidad}">
                </td>
                <td class="text-right">
                  ${dato.descuento.text}
                  <input type="hidden" name="datos[${index}][descuento_text]" value="${dato.descuento.text}">
                  <input type="hidden" name="datos[${index}][descuento_type]" value="${dato.descuento.tipo}">
                  <input type="hidden" name="datos[${index}][descuento]" value="${dato.descuento.cantidad}">
                </td>
              </tr>`
    }

    function deleteRow(){
      let id = $(this).data('id');

      $(`#tr-${id}`).remove();
      toggleBtn()
    }

    function toggleBtn(){
      $('#btn-cotizacion').prop('disabled', $('.tr-dato').length <= 0)
    }
  </script>
@endsection
