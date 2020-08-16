@extends('layouts.app')

@section('title', 'Cotización - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proceso.show', ['proceso' => $situacion->proceso_id]) }}"> Cotización </a>
@endsection

@section('content')
  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-body">
          <h4>Generar cotización</h4>
          
          <h5 class="text-center">{{ $situacion->proceso->cliente->nombre().' | '.$situacion->proceso->vehiculo->vehiculo() }}</h5>

          <form action="{{ route('admin.cotizacion.store', ['situacion' => $situacion->id]) }}" method="POST">
            @csrf
            
            <div class="form-group">
              <label for="descripcion">Descripción:</label>
              <textarea id="descripcion" class="form-control" name="descripcion" maxlength="500">{{ old('descripcion') }}</textarea>
            </div>
            
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="descuento">Descuento:</label>
                  <input id="descuento" class="form-control" type="number" min="0" step="0.01" max="999999999" name="descuento" value="{{ old('descuento') }}">
                  <small class="text-muted">Solo números</small>
                </div>
              </div>
            </div>

            <p class="text-center text-muted">Seleccione los items que deben formar parte de la cotización</p>

            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover table-sm font-small" style="width: 100%">
                <tbody>
                  <tr>
                    <td colspan="8">REPUESTOS</td>
                  </tr>
                  <tr>
                    <th>DETALLE</th>
                    <th>PRECIO COSTO</th>
                    <th>UTILIDAD</th>
                    <th>DESCUENTO</th>
                    <th>CANT</th>
                    <th>PRECIO</th>
                    <th>TOTAL</th>
                    <td class="text-center">
                      <div class="form-group m-0">
                        <div class="form-check only-check">
                          <label class="form-check-label">
                            <input id="todos" class="form-check-input" type="checkbox">
                            <span class="form-check-sign"></span>
                          </label>
                        </div>
                      </div>
                    </td>
                  </tr>
                  @foreach($repuestos as $repuesto)
                    <tr>
                      <td>{{ $repuesto->titulo() }}</td>
                      <td class="text-right">{{ $repuesto->costo() }}</td>
                      <td class="text-right">{{ $repuesto->utilidad() }}</td>
                      <td class="text-right"></td>
                      <td class="text-center">{{ $repuesto->cantidad() }}</td>
                      <td class="text-right">{{ $repuesto->valorVenta() }}</td>
                      <td class="text-right">{{ $repuesto->total() }}</td>
                      <td class="text-center">
                        @if(!$repuesto->status)
                        <div class="form-group m-0">
                          <div class="form-check only-check">
                            <label class="form-check-label">
                              <input class="form-check-input items-check" type="checkbox" name="items[]" value="{{ $repuesto->id }}" data-total="{{ $repuesto->total }}">
                              <span class="form-check-sign"></span>
                            </label>
                          </div>
                        </div>
                        @else
                          -
                        @endif
                      </td>
                    </tr>
                  @endforeach
                  <tr>
                    <td colspan="8">LIBRICANTES E INSUMOS</td>
                  </tr>
                  <tr>
                    <th>DETALLE</th>
                    <th>PRECIO COSTO</th>
                    <th>UTILIDAD</th>
                    <th>DESCUENTO</th>
                    <th>CANT</th>
                    <th>PRECIO</th>
                    <th>TOTAL</th>
                    <th></th>
                  </tr>
                  @foreach($insumos as $insumo)
                    <tr>
                      <td>{{ $insumo->titulo() }}</td>
                      <td class="text-right">{{ $insumo->costo() }}</td>
                      <td class="text-right">{{ $insumo->utilidad() }}</td>
                      <td class="text-right"></td>
                      <td class="text-center">{{ $insumo->cantidad() }}</td>
                      <td class="text-right">{{ $insumo->valorVenta() }}</td>
                      <td class="text-right">{{ $insumo->total() }}</td>
                      <td class="text-center">
                        @if(!$insumo->status)
                        <div class="form-group m-0">
                          <div class="form-check only-check">
                            <label class="form-check-label">
                              <input class="form-check-input items-check" type="checkbox" name="items[]" value="{{ $insumo->id }}" data-total="{{ $insumo->total }}">
                              <span class="form-check-sign"></span>
                            </label>
                          </div>
                        </div>
                        @else
                          -
                        @endif
                      </td>
                    </tr>
                  @endforeach
                  <tr>
                    <td colspan="8">MANO DE OBRA</td>
                  </tr>
                  <tr>
                    <th>DETALLE</th>
                    <th>PRECIO COSTO</th>
                    <th>UTILIDAD</th>
                    <th>DESCUENTO</th>
                    <th>CANT</th>
                    <th>PRECIO</th>
                    <th>TOTAL</th>
                    <th></th>
                  </tr>
                  @foreach($horas as $hora)
                    <tr>
                      <td>{{ $hora->descripcion ?? 'N/A' }}</td>
                      <td class="text-right">{{ $hora->costo() }}</td>
                      <td class="text-right">{{ $hora->utilidad() }}</td>
                      <td class="text-right">{{ $hora->descuentoText() }}</td>
                      <td class="text-center">{{ $hora->cantidad() }}</td>
                      <td class="text-right">{{ $hora->valorVenta() }}</td>
                      <td class="text-right">{{ $hora->total() }}</td>
                      <td class="text-center">
                        @if(!$hora->status)
                        <div class="form-group m-0">
                          <div class="form-check only-check">
                            <label class="form-check-label">
                              <input class="form-check-input items-check" type="checkbox" name="items[]" value="{{ $hora->id }}" data-total="{{ $hora->total }}">
                              <span class="form-check-sign"></span>
                            </label>
                          </div>
                        </div>
                        @else
                          -
                        @endif
                      </td>
                    </tr>
                  @endforeach
                  <tr>
                    <td colspan="8">OTROS</td>
                  </tr>
                  <tr>
                    <th>DETALLE</th>
                    <th>PRECIO COSTO</th>
                    <th>UTILIDAD</th>
                    <th>DESCUENTO</th>
                    <th>CANT</th>
                    <th>PRECIO</th>
                    <th>TOTAL</th>
                    <th></th>
                  </tr>
                  @foreach($otros as $otro)
                    <tr>
                      <td>{{ $otro->descripcion ?? 'N/A' }}</td>
                      <td class="text-right">{{ $otro->costo() }}</td>
                      <td class="text-right">{{ $otro->utilidad() }}</td>
                      <td class="text-right">{{ $otro->descuentoText() }}</td>
                      <td class="text-center">{{ $otro->cantidad() }}</td>
                      <td class="text-right">{{ $otro->valorVenta() }}</td>
                      <td class="text-right">{{ $otro->total() }}</td>
                      <td class="text-center">
                        @if(!$otro->status)
                        <div class="form-group m-0">
                          <div class="form-check only-check">
                            <label class="form-check-label">
                              <input class="form-check-input items-check" type="checkbox" name="items[]" value="{{ $otro->id }}" data-total="{{ $otro->total }}">
                              <span class="form-check-sign"></span>
                            </label>
                          </div>
                        </div>
                        @else
                          -
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="5"></td>
                    <td class="text-right"><strong>SUBTOTAL</strong></td>
                    <td class="text-right table-subtotal"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="5"></td>
                    <td class="text-right"><strong>DESCUENTO</strong></td>
                    <td class="text-right table-descuento"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="5"></td>
                    <td class="text-right"><strong>IVA</strong></td>
                    <td class="text-right table-iva"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="5"></td>
                    <td class="text-right"><strong>TOTAL</strong></td>
                    <td class="text-right table-total"></td>
                    <td></td>
                  </tr>
                </tfoot>
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
              <a class="btn btn-default" href="{{ route('admin.proceso.show', ['proceso' => $situacion->proceso_id]) }}"><i class="fa fa-reply"></i> Atras</a>
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
      toggleBtn()

      $('#todos').click( function() {
        $('.items-check').prop('checked', this.checked)
        toggleBtn()
        calculateTotales()
      })

      $('.items-check').click( function() {
        checkStates()
      })

      $('#descuento').change(function() {
        let descuento = +$(this).val()
        descuento = +descuento.toFixed(2)
        $('.table-descuento').text(descuento.toLocaleString('de-DE'))
        calculateTotales()
      })

      // Inicializar popovers
      $('[data-toggle="popover"]').popover()
    })

    function checkStates(){
      let allcheckCount = $('.items-check').length,
          checkedCount  = $('.items-check:checked').length;

      $('#todos').prop('checked', (allcheckCount == checkedCount))
      toggleBtn()
      calculateTotales()
    }

    function toggleBtn(){
      $('#btn-cotizacion').prop('disabled', !($('.items-check:checked').length > 0))
    }

    function calculateTotales(){
      let descuento = +$('#descuento').val()
      let subtotal  = 0

      $.each($('.items-check:checked'), function(k, item){
        subtotal += +$(item).data('total')
      })

      let subtotalWithDescuento = (subtotal > 0) ? (subtotal - descuento) : 0
      let iva = (subtotal > 0) ? ((subtotalWithDescuento * 19) / 100) : 0
      let total = (subtotal > 0) ? (subtotalWithDescuento + iva) : 0

      descuento = +descuento.toFixed(2)
      subtotal = +subtotal.toFixed(2)
      iva = +iva.toFixed(2)
      total = +total.toFixed(2)

      $('.table-subtotal').text(subtotal.toLocaleString('de-DE'))
      $('.table-descuento').text(descuento.toLocaleString('de-DE'))
      $('.table-iva').text(iva.toLocaleString('de-DE'))
      $('.table-total').text(total.toLocaleString('de-DE'))
    }
  </script>
@endsection
