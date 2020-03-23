@extends('layouts.app')

@section('title', 'Cotización - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proceso.show', ['proceso' => $cotizacion->situacion->proceso_id]) }}"> Cotización </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('admin.proceso.show', ['proceso' => $cotizacion->situacion->proceso_id]) }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
      @if(Auth::user()->isAdmin() && !$cotizacion->situacion->proceso->status)
        <a class="btn btn-success" href="{{ route('admin.cotizacion.edit', ['cotizacion' => $cotizacion->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
        <button class="btn btn-fill btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
      @endif
      <a class="btn btn-danger" href="{{ route('admin.cotizacion.pdf', ['cotizacion' => $cotizacion->id]) }}"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar PDF</a>
    </div>
  </div>
  
  @include('partials.flash')

  <div class="row" style="margin-top: 20px">
    <div class="col-md-3">
      <div class="card card-information">
        <div class="card-header">
          <h4 class="card-title">
            Información
          </h4>
        </div><!-- .card-header -->
        <div class="card-body">
          <strong>Código</strong>
          <p class="text-muted">
            {{ $cotizacion->codigo() }}
          </p>
          <hr>

          <strong>Generada por</strong>
          <p class="text-muted">
            {{ $cotizacion->user->nombre() }} ({{ $cotizacion->user->role() }})
          </p>
          <hr>

          <strong>Cliente</strong>
          <p class="text-muted">
            <a href="{{ route('admin.cliente.show', ['cliente' => $cotizacion->situacion->proceso->cliente_id]) }}">
              {{ $cotizacion->situacion->proceso->cliente->nombre() }}
            </a>
          </p>
          <hr>

          <strong>Vehículo</strong>
          <p class="text-muted">
            {{ $cotizacion->situacion->proceso->vehiculo->vehiculo() }}
          </p>
          <hr>

          <strong>Total</strong>
          <p class="text-muted">
            {{ $cotizacion->total(false) }}
          </p>
          <hr>

          <strong>Pagado</strong>
          <p class="text-muted">
            {{ $cotizacion->pagado(false) }}
          </p>
          <hr>

          <strong>Imprevistos</strong>
          <p class="text-muted">
            {{ $cotizacion->totalImprevistos() }}
          </p>
          <hr>

          <strong>Utilidad</strong>
          <p class="text-muted">
            {{ $cotizacion->utilidad(false) }}
          </p>
          <hr>

          <strong>Estatus</strong>
          <p class="text-muted">
            {!! $cotizacion->status() !!}
          </p>

        </div>
        <div class="card-footer text-center">
          <hr>
          <small class="text-muted">
            {{ $cotizacion->created_at }}
          </small>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div>

    <div class="col-md-9">
      <div class="row">
        <div class="col-md-4">
          <div class="card card-stats">
            @if(Auth::user()->isAdmin() && !$cotizacion->situacion->proceso->status && !$cotizacion->hasPagos())
            <a href="{{ route('admin.pago.create', ['cotizacion' => $cotizacion->id]) }}" title="Agregar pago">
            @else
            <a class="link-pagos" href="#" title="Ver pagos">
            @endif
              <div class="card-body py-1">
                <div class="row">
                  <div class="col-4">
                    <div class="icon-big text-center {{ $cotizacion->hasPagos() ? 'text-danger' : 'text-muted' }}">
                      <i class="fa fa-credit-card"></i>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="numbers">
                      <p class="card-category">Pagos</p>
                      <p class="{{ ($cotizacion->hasPagos() || $cotizacion->situacion->proceso->status) ? 'card-title' : '' }}">
                        {{ ($cotizacion->hasPagos() || $cotizacion->situacion->proceso->status) ? $pagos->count() : 'Agregar' }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card card-information">
            <div class="card-header">
              <h4 class="card-title">Descripción</h4>
            </div><!-- .card-header -->
            <div class="card-body">
              <p class="m-0">{{ $cotizacion->descripcion }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="tab1-tab" href="#tab1" role="tab" data-toggle="tab" aria-controls="tab1" aria-selected="true"><i class="fa fa-list-alt"></i> Items</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="tab2-tab" href="#tab2" role="tab" data-toggle="tab" aria-controls="tab2" aria-selected="false"><i class="fa fa-exclamation"></i> Imprevistos</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="tab3-tab" href="#tab3" role="tab" data-toggle="tab" aria-controls="tab3" aria-selected="false"><i class="fa fa-credit-card"></i> Pagos</a>
                </li>
              </ul>
              <div class="tab-content">
                <div id="tab1" class="tab-pane fade show active pt-2" role="tabpanel" aria-labelledby="tab1-tab">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover table-sm font-small m-0" style="width: 100%">
                      <tbody>
                        <tr>
                          <td colspan="7">REPUESTOS</td>
                        </tr>
                        <tr>
                          <th>DETALLE</th>
                          <th>PRECIO COSTO</th>
                          <th>UTILIDAD</th>
                          <th>DESCUENTO</th>
                          <th>CANT</th>
                          <th>PRECIO</th>
                          <th>TOTAL</th>
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
                          </tr>
                        @endforeach
                        <tr>
                          <td colspan="5"></td>
                          <td class="text-right"><strong>SUB TOTAL</strong></td>
                          <td class="text-right">{{ $cotizacion->sumValue('total', false, 2, 'repuesto') }}</td>
                        </tr>
                        <tr>
                          <td colspan="7">LIBRICANTES E INSUMOS</td>
                        </tr>
                        <tr>
                          <th>DETALLE</th>
                          <th>PRECIO COSTO</th>
                          <th>UTILIDAD</th>
                          <th>DESCUENTO</th>
                          <th>CANT</th>
                          <th>PRECIO</th>
                          <th>TOTAL</th>
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
                          </tr>
                        @endforeach
                        <tr>
                          <td colspan="5"></td>
                          <td class="text-right"><strong>SUB TOTAL</strong></td>
                          <td class="text-right">{{ $cotizacion->sumValue('total', false, 2, 'insumo') }}</td>
                        </tr>
                        <tr>
                          <td colspan="7">MANO DE OBRA</td>
                        </tr>
                        <tr>
                          <th>DETALLE</th>
                          <th>PRECIO COSTO</th>
                          <th>UTILIDAD</th>
                          <th>DESCUENTO</th>
                          <th>CANT</th>
                          <th>PRECIO</th>
                          <th>TOTAL</th>
                        </tr>
                        @foreach($horas as $hora)
                          <tr>
                            <td><a tabindex="0" class="btn btn-simple btn-link p-0" role="button" data-toggle="popover" data-trigger="focus" data-placement="top" title="Descripción" data-content="{{ $hora->descripcion ?? 'N/A' }}">{{ $hora->titulo() }}</a></td>
                            <td class="text-right">{{ $hora->costo() }}</td>
                            <td class="text-right">{{ $hora->utilidad() }}</td>
                            <td class="text-right">{{ $hora->descuentoText() }}</td>
                            <td class="text-center">{{ $hora->cantidad() }}</td>
                            <td class="text-right">{{ $hora->valorVenta() }}</td>
                            <td class="text-right">{{ $hora->total() }}</td>
                          </tr>
                        @endforeach
                        <tr>
                          <td colspan="5"></td>
                          <td class="text-right"><strong>SUB TOTAL</strong></td>
                          <td class="text-right">{{ $cotizacion->sumValue('total', false, 2, 'horas') }}</td>
                        </tr>
                        <tr>
                          <td colspan="7">OTROS</td>
                        </tr>
                        <tr>
                          <th>DETALLE</th>
                          <th>PRECIO COSTO</th>
                          <th>UTILIDAD</th>
                          <th>DESCUENTO</th>
                          <th>CANT</th>
                          <th>PRECIO</th>
                          <th>TOTAL</th>
                        </tr>
                        @foreach($otros as $otro)
                          <tr>
                            <td><a tabindex="0" class="btn btn-simple btn-link p-0" role="button" data-toggle="popover" data-trigger="focus" data-placement="top" title="Descripción" data-content="{{ $otro->descripcion ?? 'N/A' }}">{{ $otro->titulo() }}</a></td>
                            <td class="text-right">{{ $otro->costo() }}</td>
                            <td class="text-right">{{ $otro->utilidad() }}</td>
                            <td class="text-right">{{ $otro->descuentoText() }}</td>
                            <td class="text-center">{{ $otro->cantidad() }}</td>
                            <td class="text-right">{{ $otro->valorVenta() }}</td>
                            <td class="text-right">{{ $otro->total() }}</td>
                          </tr>
                        @endforeach
                        <tr>
                          <td colspan="5"></td>
                          <td class="text-right"><strong>SUB TOTAL</strong></td>
                          <td class="text-right">{{ $cotizacion->sumValue('total', false, 2, 'otros') }}</td>
                        </tr>
                        @if($imprevistosCliente->count() > 0)
                          <tr>
                            <td colspan="7">COSTOS EXTRA</td>
                          </tr>
                          <tr>
                            <th>DETALLE</th>
                            <th>PRECIO COSTO</th>
                            <th>UTILIDAD</th>
                            <th>DESCUENTO</th>
                            <th>CANT</th>
                            <th>PRECIO</th>
                            <th>TOTAL</th>
                          </tr>
                          @foreach($imprevistosCliente as $imprevistoCliente)
                            <tr>
                              <td><a tabindex="0" class="btn btn-simple btn-link p-0" role="button" data-toggle="popover" data-trigger="focus" data-placement="top" title="Descripción" data-content="{{ $imprevistoCliente->descripcion ?? 'N/A' }}">{{ $imprevistoCliente->tipo() }}</a></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td class="text-right">{{ $imprevistoCliente->monto() }}</td>
                              <td class="text-right">{{ $imprevistoCliente->monto() }}</td>
                            </tr>
                          @endforeach
                          <tr>
                            <td colspan="5"></td>
                            <td class="text-right"><strong>SUB TOTAL</strong></td>
                            <td class="text-right">{{ $cotizacion->sumImprevistos('cliente') }}</td>
                          </tr>
                        @endif
                        <tr>
                          <td colspan="5"></td>
                          <td class="text-right"><strong>NETO</strong></td>
                          <td class="text-right">{{ $cotizacion->neto() }}</td>
                        </tr>
                        <tr>
                          <td colspan="5"></td>
                          <td class="text-right"><strong>IVA</strong></td>
                          <td class="text-right">{{ $cotizacion->iva() }}</td>
                        </tr>
                        <tr>
                          <td colspan="5"></td>
                          <td class="text-right"><strong>TOTAL</strong></td>
                          <td class="text-right">{{ $cotizacion->total() }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div><!-- .tab-pane -->

                <div id="tab2" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab2-tab">
                  @if(!$cotizacion->situacion->proceso->status)
                    <a class="btn btn-primary btn-fill btn-xs mb-2" href="{{ route('admin.imprevisto.create', ['cotizacion' => $cotizacion->id]) }}">
                      <i class="fa fa-plus"></i> Agregar imprevisto
                    </a>
                  @endif
                  
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover table-sm font-small m-0" style="width: 100%">
                      <tbody>
                        <tr>
                          <td colspan="{{Auth::user()->isAdmin() ? '3' : 2 }}">REPUESTOS</td>
                        </tr>
                        <tr>
                          <th>DESCRIPCIÓN</th>
                          <th>MONTO</th>
                          @if(Auth::user()->isAdmin())
                            <th>ACCIÓN</th>
                          @endif
                        </tr>
                        @foreach($imprevistosRepuestos as $repuesto)
                          <tr>
                            <td>{{ $repuesto->descripcion }}</td>
                            <td class="text-right">{{ $repuesto->monto() }}</td>
                            @if(Auth::user()->isAdmin())
                              <td class="text-center">
                                @if(!$cotizacion->situacion->proceso->status)
                                  <button class="btn btn-danger btn-sm btn-fill btn-delete" data-id="{{ $repuesto->id }}" data-toggle="modal" data-type="imprevisto" data-target="#delElementoModal">
                                    <i class="fa fa-times"></i>
                                  </button>
                                @endif
                              </td>
                            @endif
                          </tr>
                        @endforeach
                        <tr>
                          <td class="text-right"><strong>SUB TOTAL</strong></td>
                          <td class="text-right">{{ $cotizacion->sumImprevistos('taller', 'repuesto') }}</td>
                          @if(Auth::user()->isAdmin())
                            <td></td>
                          @endif
                        </tr>
                        <tr>
                          <td colspan="{{Auth::user()->isAdmin() ? '3' : 2 }}">INSUMOS</td>
                        </tr>
                        <tr>
                          <th>DESCRIPCIÓN</th>
                          <th>MONTO</th>
                          @if(Auth::user()->isAdmin())
                            <th>ACCIÓN</th>
                          @endif
                        </tr>
                        @foreach($imprevistosInsumos as $insumo)
                          <tr>
                            <td>{{ $insumo->descripcion }}</td>
                            <td class="text-right">{{ $insumo->monto() }}</td>
                            @if(Auth::user()->isAdmin())
                              <td class="text-center">
                                @if(!$cotizacion->situacion->proceso->status)
                                  <button class="btn btn-danger btn-sm btn-fill btn-delete" data-id="{{ $insumo->id }}" data-toggle="modal" data-type="imprevisto" data-target="#delElementoModal">
                                    <i class="fa fa-times"></i>
                                  </button>
                                @endif
                              </td>
                            @endif
                          </tr>
                        @endforeach
                        <tr>
                          <td class="text-right"><strong>SUB TOTAL</strong></td>
                          <td class="text-right">{{ $cotizacion->sumImprevistos('taller', 'insumo') }}</td>
                          @if(Auth::user()->isAdmin())
                            <td></td>
                          @endif
                        </tr>
                        <tr>
                          <td colspan="{{Auth::user()->isAdmin() ? '3' : 2 }}">HORAS HOMBRE</td>
                        </tr>
                        <tr>
                          <th>DESCRIPCIÓN</th>
                          <th>MONTO</th>
                          @if(Auth::user()->isAdmin())
                            <th>ACCIÓN</th>
                          @endif
                        </tr>
                        @foreach($imprevistosHoras as $hora)
                          <tr>
                            <td>{{ $hora->descripcion }}</td>
                            <td class="text-right">{{ $hora->monto() }}</td>
                            @if(Auth::user()->isAdmin())
                              <td class="text-center">
                                @if(!$cotizacion->situacion->proceso->status)
                                  <button class="btn btn-danger btn-sm btn-fill btn-delete" data-id="{{ $hora->id }}" data-toggle="modal" data-type="imprevisto" data-target="#delElementoModal">
                                    <i class="fa fa-times"></i>
                                  </button>
                                @endif
                              </td>
                            @endif
                          </tr>
                        @endforeach
                        <tr>
                          <td class="text-right"><strong>SUB TOTAL</strong></td>
                          <td class="text-right">{{ $cotizacion->sumImprevistos('taller', 'horas') }}</td>
                          @if(Auth::user()->isAdmin())
                            <td></td>
                          @endif
                        </tr>
                        <tr>
                          <td colspan="{{Auth::user()->isAdmin() ? '3' : 2 }}">SERVICIOS DE TERCEROS</td>
                        </tr>
                        <tr>
                          <th>DESCRIPCIÓN</th>
                          <th>MONTO</th>
                          @if(Auth::user()->isAdmin())
                            <th>ACCIÓN</th>
                          @endif
                        </tr>
                        @foreach($imprevistosTerceros as $tercero)
                          <tr>
                            <td>{{ $tercero->descripcion }}</td>
                            <td class="text-right">{{ $tercero->monto() }}</td>
                            @if(Auth::user()->isAdmin())
                              <td class="text-center">
                                @if(!$cotizacion->situacion->proceso->status)
                                  <button class="btn btn-danger btn-sm btn-fill btn-delete" data-id="{{ $tercero->id }}" data-toggle="modal" data-type="imprevisto" data-target="#delElementoModal">
                                    <i class="fa fa-times"></i>
                                  </button>
                                @endif
                              </td>
                            @endif
                          </tr>
                        @endforeach
                        <tr>
                          <td class="text-right"><strong>SUB TOTAL</strong></td>
                          <td class="text-right">{{ $cotizacion->sumImprevistos('taller', 'terceros') }}</td>
                          @if(Auth::user()->isAdmin())
                            <td></td>
                          @endif
                        </tr>
                        <tr>
                          <td colspan="{{Auth::user()->isAdmin() ? '3' : 2 }}">OTROS</td>
                        </tr>
                        <tr>
                          <th>DESCRIPCIÓN</th>
                          <th>MONTO</th>
                          @if(Auth::user()->isAdmin())
                            <th>ACCIÓN</th>
                          @endif
                        </tr>
                        @foreach($imprevistosOtros as $otro)
                          <tr>
                            <td>{{ $otro->descripcion }}</td>
                            <td class="text-right">{{ $otro->monto() }}</td>
                            @if(Auth::user()->isAdmin())
                              <td class="text-center">
                                @if(!$cotizacion->situacion->proceso->status)
                                  <button class="btn btn-danger btn-sm btn-fill btn-delete" data-id="{{ $otro->id }}" data-toggle="modal" data-type="imprevisto" data-target="#delElementoModal">
                                    <i class="fa fa-times"></i>
                                  </button>
                                @endif
                              </td>
                            @endif
                          </tr>
                        @endforeach
                        <tr>
                          <td class="text-right"><strong>SUB TOTAL</strong></td>
                          <td class="text-right">{{ $cotizacion->sumImprevistos('taller', 'otros') }}</td>
                          @if(Auth::user()->isAdmin())
                            <td></td>
                          @endif
                        </tr>
                        <tr>
                          <td class="text-right"><strong>TOTAL</strong></td>
                          <td class="text-right">{{ $cotizacion->sumImprevistos('taller') }}</td>
                          @if(Auth::user()->isAdmin())
                            <td></td>
                          @endif
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div><!-- .tab-pane -->

                <div id="tab3" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab3-tab">
                  @if(!$cotizacion->status && !$cotizacion->situacion->proceso->status)
                    <a class="btn btn-primary btn-fill btn-xs mb-2" href="{{ route('admin.pago.create', ['cotizacion' => $cotizacion->id]) }}">
                      <i class="fa fa-plus"></i> Agregar pago
                    </a>
                  @endif

                  <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                    <thead>
                      <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">Pago</th>
                        <th scope="col" class="text-center">Fecha</th>
                        @if(Auth::user()->isAdmin())
                        <th scope="col" class="text-center">Acción</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($pagos as $pago)
                        <tr>
                          <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                          <td class="text-right">{{ $pago->pago() }}</td>
                          <td class="text-center">{{ $pago->created_at->format('d-m-Y H:i:s')}}</td>
                          @if(Auth::user()->isAdmin())
                          <td class="text-center">
                            @if(!$cotizacion->status && !$cotizacion->situacion->proceso->status)
                              <button class="btn btn-danger btn-sm btn-fill btn-delete" data-id="{{ $pago->id }}" data-toggle="modal" data-type="pago" data-target="#delElementoModal">
                                <i class="fa fa-times"></i>
                              </button>
                            @endif
                          </td>
                          @endif
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div><!-- .tab-pane -->
              </div><!-- .tab-content -->
            </div><!-- .card-body -->
          </div>
        </div>
      </div>
    </div>
  </div>
  
  @if(Auth::user()->isAdmin() && !$cotizacion->situacion->proceso->status)
  <div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="delModalLabel">Eliminar Cotización</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <form class="col-md-10" action="{{ route('admin.cotizacion.destroy', ['cotizacion' => $cotizacion->id]) }}" method="POST">
              @csrf
              @method('DELETE')

              <p class="text-center">¿Esta seguro de eliminar esta Cotización?</p><br>

              <center>
                <button class="btn btn-fill btn-danger" type="submit">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
  
  @if(Auth::user()->isAdmin() && !$cotizacion->situacion->proceso->status)
    <div id="delElementoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delElementoModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="delElementoModalLabel"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row justify-content-md-center">
              <form id="delElemento" class="col-md-12" action="#" method="POST">
                @csrf
                @method('DELETE')

                <p class="text-center">¿Esta seguro de eliminar este <span id="elemento-type"></span>?</p><br>

                <center>
                  <button class="btn btn-fill btn-danger" type="submit">Eliminar</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </center>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      $('.link-pagos').click(function (e) {
        e.preventDefault()
        $('#tab2-tab').click()

        $('.main-panel').animate({
            scrollTop: $('.tab-content').offset().top
        }, 500);
      })

      @if(Auth::user()->isAdmin() && !$cotizacion->situacion->proceso->status)
        $('#delElementoModal').on('show.bs.modal', function (e) {
          let id = $(e.relatedTarget).data('id'),
              type = $(e.relatedTarget).data('type')

          let url = (type == 'pago' ? '{{ route("admin.pago.index") }}/' : '{{ route("admin.imprevisto.index") }}/') + id;
          let title = type.charAt(0).toUpperCase() + type.slice(1)

          $('#elemento-type').text(title)
          $('#delElementoModalLabel').text(`Eliminar ${title}`)
          $('#delElemento').attr('action', url)
        })
      @endif

      // Inicializar popovers
      $('[data-toggle="popover"]').popover()
    })
  </script>
@endsection
