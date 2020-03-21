@extends('layouts.app')

@section('title', 'Servicio - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proceso.index') }}"> Servicios </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('admin.proceso.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
      @if(Auth::user()->isAdmin())
        @if(!$proceso->status)
          <button class="btn btn-fill btn-warning" data-toggle="modal" data-target="#statusModal"><i class="fa fa-check" aria-hidden="true"></i> Completado</button>
        @endif
        <button class="btn btn-fill btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
      @endif
    </div>
  </div>
  
  @include('partials.flash')

  <div class="row" style="margin-top: 20px">
    <div class="col-md-4">
      <div class="card card-information">
        <div class="card-header">
          <h4 class="card-title">
            Información
          </h4>
        </div><!-- .card-header -->
        <div class="card-body">
          <strong>Cliente</strong>
          <p class="text-muted">
            <a href="{{ route('admin.cliente.show', ['cliente' => $proceso->cliente_id]) }}">
              {{ $proceso->cliente->nombre() }}
            </a>
          </p>
          <hr>

          <strong>Vehículo</strong>
          <p class="text-muted">
            {{ $proceso->vehiculo->vehiculo() }}
          </p>
          <hr>
          
          @if($proceso->situacion)
          <strong>Total</strong>
          <p class="text-muted">
            {{ $proceso->total(false) }}
          </p>
          <hr>
          @endif

          <strong>Estatus</strong>
          <p class="text-muted">
            {!! $proceso->status() !!}
          </p>

        </div>
        <div class="card-footer text-center">
          <hr>
          <small class="text-muted">
            {{ $proceso->created_at }}
          </small>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div>

    <div class="col-md-8">
      <div class="row">
        <div class="col-sm-6 col-md-4">
          @if(!$proceso->status && Auth::user()->isAdmin())
            @if($proceso->agendamiento)
            <a href="{{ route('admin.agendamiento.edit', ['agendamiento' => $proceso->agendamiento->id]) }}" title="Editar agendamiento">
            @else
            <a href="{{ route('admin.agendamiento.create', ['proceso' => $proceso->id]) }}" title="Agregar agendamiento">
            @endif
          @endif
            <div class="card card-stats">
              <div class="card-body py-1">
                <div class="row">
                  <div class="col-4">
                    <div class="icon-big text-center {{ $proceso->agendamiento ? 'text-danger' : 'text-muted' }}">
                      <i class="fa fa-calendar"></i>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="numbers">
                      <p class="card-category">Agendamiento</p>
                      <p class="{{ $proceso->agendamiento ? 'card-title' : '' }}">
                        {{ $proceso->agendamiento ? $proceso->agendamiento->fecha() : 'Agregar' }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @if(!$proceso->status && Auth::user()->isAdmin())
          </a>
          @endif
        </div>

        <div class="col-sm-6 col-md-4">
          @if(!$proceso->status && Auth::user()->isAdmin())
            @if($proceso->hasPreevaluaciones())
            <a href="{{ ($preevaluaciones->count() < 12 || $preevaluacionesFotos->count() < 6) ? route('admin.preevaluacion.edit', ['proceso' => $proceso->id]) : '#preevaluaciones' }}" title="{{ ($preevaluaciones->count() < 12 || $preevaluacionesFotos->count() < 6) ? 'Editar pre-evaluación' : '' }}">
            @else
            <a href="{{ ($proceso->etapa == 2) ? route('admin.preevaluacion.create', ['proceso' => $proceso->id]) : '#' }}" title="{{ ($proceso->etapa == 2) ? 'Agregar pre-evaluación' : '' }}">
            @endif
          @endif
            <div class="card card-stats">
              <div class="card-body py-1">
                <div class="row">
                  <div class="col-4">
                    <div class="icon-big text-center {{ $proceso->hasPreevaluaciones() ? 'text-danger' : 'text-muted' }}">
                      <i class="fa fa-check-square-o"></i>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="numbers">
                      <p class="card-category">Pre-evaluación</p>
                      <p class="{{ $proceso->hasPreevaluaciones() ? 'card-title' : '' }}">
                        {!! $proceso->etapa == 2 ? 'Agregar' : $proceso->preevaluacionesStatus() !!}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @if(!$proceso->status && Auth::user()->isAdmin())
          </a>
          @endif
        </div>

        <div class="col-sm-6 col-md-4">
          @if(!$proceso->status && Auth::user()->isAdmin())
            @if($proceso->situacion)
              <a href="{{ route('admin.situacion.edit', ['situacion' => $proceso->situacion->id]) }}" title="Editar Hoja de situación">
            @else
              <a href="{{ ($proceso->etapa == 3) ? route('admin.situacion.create', ['proceso' => $proceso->id]) : '#' }}" title="{{ ($proceso->etapa == 3) ? 'Agregar' : '' }}">
            @endif
          @endif
            <div class="card card-stats">
              <div class="card-body py-1">
                <div class="row">
                  <div class="col-4">
                    <div class="icon-big text-center {{ $proceso->situacion ? 'text-danger' : 'text-muted' }}">
                      <i class="fa fa-list-alt"></i>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="numbers">
                      <p class="card-category">Hoja de situación</p>
                      <p class="{{  $proceso->situacion ? 'card-title' : '' }}">
                        {!! $proceso->etapa == 3 ? 'Agregar' : $proceso->situacionStatus() !!}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @if(!$proceso->status && Auth::user()->isAdmin())
          </a>
          @endif
        </div>

        <div class="col-sm-6 col-md-4">
          @if(!$proceso->hasCotizaciones() && !$proceso->status && ($proceso->etapa == 4 || $proceso->etapa == 5) && Auth::user()->isAdmin())
            <a href="{{ route('admin.cotizacion.create', ['situcion' => $proceso->situacion->id]) }}" title="Generar cotización">
          @else
            <a class="link-scroll" href="#" data-tab="#tab3">
          @endif
            <div class="card card-stats">
              <div class="card-body py-1">
                <div class="row">
                  <div class="col-4">
                    <div class="icon-big text-center {{ $proceso->hasCotizaciones() ? 'text-danger' : 'text-muted' }}">
                      <i class="fa fa-calculator"></i>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="numbers">
                      <p class="card-category">Cotizaciones</p>
                      <p class="{{ $proceso->hasCotizaciones() ? 'card-title' : '' }}">
                        {!! (($proceso->etapa == 4 || $proceso->etapa == 5) && !$proceso->hasCotizaciones()) ? 'Generar' : $proceso->cotizacionesStatus() !!}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>

        <div class="col-sm-6 col-md-4">
          <a class="link-scroll" href="#" title="Ver pagos" data-tab="#tab4">
            <div class="card card-stats">
              <div class="card-body py-1">
                <div class="row">
                  <div class="col-4">
                    <div class="icon-big text-center {{ $proceso->hasPagos() ? 'text-danger' : 'text-muted' }}">
                      <i class="fa fa-credit-card"></i>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="numbers">
                      <p class="card-category">Pagos</p>
                      <p class="card-title">
                        {{ $proceso->hasPagos() ? $pagos->count() : '' }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>

        <div class="col-sm-6 col-md-4">
        @if(Auth::user()->isAdmin() && !$proceso->status)
          @if($proceso->inspeccion)
            <a href="{{ route('admin.inspeccion.edit', ['inspeccion' => $proceso->inspeccion->id]) }}">
          @else
            <a href="{{ ($proceso->etapa >= 5) ? route('admin.inspeccion.create', ['proceso' => $proceso->id]) : '#' }}">
          @endif
        @endif
            <div class="card card-stats">
              <div class="card-body py-1">
                <div class="row">
                  <div class="col-4">
                    <div class="icon-big text-center {{ $proceso->inspeccion ? 'text-danger' : 'text-muted' }}">
                      <i class="fa fa-list"></i>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="numbers">
                      <p class="card-category">Inspección de recepción</p>
                      <p class="{{ $proceso->inspeccion ? 'card-title' : '' }}">
                        {!! ($proceso->etapa >= 5 && !$proceso->inspeccion && !$proceso->status) ? 'Agregar' : $proceso->inspeccionStatus() !!}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @if(Auth::user()->isAdmin() && !$proceso->status)
          </a>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <ul class="nav nav-tabs proceso-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="tab1-tab" href="#tab1" role="tab" data-toggle="tab" aria-controls="tab1" aria-selected="true"><i class="fa fa-check-square-o"></i> Pre-evaluación</a>
            </li>
            @if($proceso->situacion)
            <li class="nav-item">
              <a class="nav-link" id="tab2-tab" href="#tab2" role="tab" data-toggle="tab" aria-controls="tab2" aria-selected="false"><i class="fa fa-list-alt"></i> Hoja de situación</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab3-tab" href="#tab3" role="tab" data-toggle="tab" aria-controls="tab3" aria-selected="false"><i class="fa fa-calculator"></i> Cotizaciones</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab5-tab" href="#tab5" role="tab" data-toggle="tab" aria-controls="tab5" aria-selected="false"><i class="fa fa-credit-card"></i> Pagos</a>
            </li>
            @endif
            @if($proceso->inspeccion)
            <li class="nav-item">
              <a class="nav-link" id="tab6-tab" href="#tab6" role="tab" data-toggle="tab" aria-controls="tab6" aria-selected="false"><i class="fa fa-list"></i> Inspección</a>
            </li>
            @endif
          </ul>
          <div class="tab-content">
            <div id="tab1" class="tab-pane fade show active pt-2" role="tabpanel" aria-labelledby="tab1-tab">
              @if( !$proceso->status && ($preevaluaciones->count() < 12 || $preevaluacionesFotos->count() < 6) && Auth::user()->isAdmin())
                <a class="btn btn-success btn-fill btn-xs mb-2" href="{{ route('admin.preevaluacion.edit', ['proceso' => $proceso->id]) }}">
                  <i class="fa fa-pencil"></i> Modificar pre-evaluación
                </a>
              @endif
              <div class="row">
                @foreach($preevaluacionesFotos as $foto)
                  <div class="col-sm-4 col-md-2 mb-2">
                    <div class="media-thumbs p-1 rounded">
                      @if(!$proceso->status && Auth::user()->isAdmin())
                      <div class="media-thumbs-options mb-1">
                        <button class="btn btn-danger btn-xs btn-fill btn-delete" data-id="{{ $foto->id }}" data-type="foto" data-toggle="modal"  data-target="#delElementModal">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                      @endif
                      <div class="media-thumbs-content">
                        <a href="#imageModal" data-toggle="modal" data-url="{{ asset('storage/'.$foto->foto) }}">
                          <img src="{{ asset('storage/'.$foto->foto) }}" class="img-fluid">
                        </a>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
              <div class="mt-2">
                <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                  <thead>
                    <tr>
                      <th scope="col" class="text-center">#</th>
                      <th scope="col" class="text-center">Descripción</th>
                      <th scope="col" class="text-center">Observación</th>
                      <th scope="col" class="text-center">Valor referencial</th>
                      @if(Auth::user()->isAdmin())
                      <th scope="col" class="text-center">Acción</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($preevaluaciones as $preevaluacion)
                      <tr>
                        <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $preevaluacion->descripcion }}</td>
                        <td>{{ $preevaluacion->observacion ?? 'N/A' }}</td>
                        <td class="text-right">{{ $preevaluacion->referencia() ?? 'N/A'  }}</td>
                        @if(Auth::user()->isAdmin())
                        <td class="text-center">
                          @if(!$proceso->status)
                          <button class="btn btn-danger btn-sm btn-fill btn-delete" data-id="{{ $preevaluacion->id }}" data-type="preevaluacion" data-toggle="modal"  data-target="#delElementModal">
                            <i class="fa fa-times"></i>
                          </button>
                          @endif
                        </td>
                        @endif
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div><!-- .tab-pane -->
            @if($proceso->situacion)
            <div id="tab2" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab2-tab">
              @if(!$proceso->status && Auth::user()->isAdmin())
              <a class="btn btn-success btn-fill btn-xs mb-2" href="{{ route('admin.situacion.edit', ['proceso' => $proceso->situacion->id]) }}">
                <i class="fa fa-pencil"></i> Modificar Hoja de situación
              </a>
              @endif

              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-sm font-small m-0" style="width: 100%">
                  <tbody>
                    <tr>
                      <td colspan="{{ Auth::user()->isAdmin() ? '8' : '7' }}">REPUESTOS</td>
                    </tr>
                    <tr>
                      <th>DETALLE</th>
                      <th>PRECIO COSTO</th>
                      <th>UTILIDAD</th>
                      <th>DESCUENTO</th>
                      <th>CANT</th>
                      <th>PRECIO</th>
                      <th>TOTAL</th>
                      @if(Auth::user()->isAdmin())
                      <th class="text-center">ACCIÓN</th>
                      @endif
                    </tr>
                    @foreach($situacionRepuestos as $repuesto)
                      <tr>
                        <td>{{ $repuesto->titulo() }}</td>
                        <td class="text-right">{{ $repuesto->costo() }}</td>
                        <td class="text-right">{{ $repuesto->utilidad() }}</td>
                        <td class="text-right"></td>
                        <td class="text-center">{{ $repuesto->cantidad() }}</td>
                        <td class="text-right">{{ $repuesto->valorVenta() }}</td>
                        <td class="text-right">{{ $repuesto->total() }}</td>
                        @if(Auth::user()->isAdmin())
                        <td class="text-center">
                          @if(!$proceso->status && !$repuesto->status)
                          <button class="btn btn-danger btn-sm btn-fill btn-delete" data-id="{{ $repuesto->id }}" data-type="item" data-toggle="modal"  data-target="#delSituacionModal">
                            <i class="fa fa-times"></i>
                          </button>
                          @endif
                        </td>
                        @endif
                      </tr>
                    @endforeach
                    <tr>
                      <td colspan="5"></td>
                      <td class="text-right"><strong>SUB TOTAL</strong></td>
                      <td class="text-right">{{ $proceso->situacion->sumValue('total', false, 2, 'repuesto') }}</td>
                      @if(Auth::user()->isAdmin())
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td colspan="{{ Auth::user()->isAdmin() ? '8' : '7' }}">LIBRICANTES E INSUMOS</td>
                    </tr>
                    <tr>
                      <th>DETALLE</th>
                      <th>PRECIO COSTO</th>
                      <th>UTILIDAD</th>
                      <th>DESCUENTO</th>
                      <th>CANT</th>
                      <th>PRECIO</th>
                      <th>TOTAL</th>
                      @if(Auth::user()->isAdmin())
                      <th class="text-center">ACCIÓN</th>
                      @endif
                    </tr>
                    @foreach($situacionInsumos as $insumo)
                      <tr>
                        <td>{{ $insumo->titulo() }}</td>
                        <td class="text-right">{{ $insumo->costo() }}</td>
                        <td class="text-right">{{ $insumo->utilidad() }}</td>
                        <td class="text-right"></td>
                        <td class="text-center">{{ $insumo->cantidad() }}</td>
                        <td class="text-right">{{ $insumo->valorVenta() }}</td>
                        <td class="text-right">{{ $insumo->total() }}</td>
                        @if(Auth::user()->isAdmin())
                        <td class="text-center">
                          @if(!$proceso->status && !$insumo->status)
                          <button class="btn btn-danger btn-sm btn-fill btn-delete" data-id="{{ $insumo->id }}" data-type="item" data-toggle="modal"  data-target="#delSituacionModal">
                            <i class="fa fa-times"></i>
                          </button>
                          @endif
                        </td>
                        @endif
                      </tr>
                    @endforeach
                    <tr>
                      <td colspan="5"></td>
                      <td class="text-right"><strong>SUB TOTAL</strong></td>
                      <td class="text-right">{{ $proceso->situacion->sumValue('total', false, 2, 'insumo') }}</td>
                      @if(Auth::user()->isAdmin())
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td colspan="{{ Auth::user()->isAdmin() ? '8' : '7' }}">MANO DE OBRA</td>
                    </tr>
                    <tr>
                      <th>DETALLE</th>
                      <th>PRECIO COSTO</th>
                      <th>UTILIDAD</th>
                      <th>DESCUENTO</th>
                      <th>CANT</th>
                      <th>PRECIO</th>
                      <th>TOTAL</th>
                      @if(Auth::user()->isAdmin())
                      <th class="text-center">ACCIÓN</th>
                      @endif
                    </tr>
                    @foreach($situacionHoras as $hora)
                      <tr>
                        <td><a tabindex="0" class="btn btn-simple btn-link p-0" role="button" data-toggle="popover" data-trigger="focus" data-placement="top" title="Descripción" data-content="{{ $hora->descripcion ?? 'N/A' }}">{{ $hora->titulo() }}</a></td>
                        <td class="text-right">{{ $hora->costo() }}</td>
                        <td class="text-right">{{ $hora->utilidad() }}</td>
                        <td class="text-right">{{ $hora->descuentoText() }}</td>
                        <td class="text-center">{{ $hora->cantidad() }}</td>
                        <td class="text-right">{{ $hora->valorVenta() }}</td>
                        <td class="text-right">{{ $hora->total() }}</td>
                        @if(Auth::user()->isAdmin())
                        <td class="text-center">
                          @if(!$proceso->status && !$hora->status)
                          <button class="btn btn-danger btn-sm btn-fill btn-delete" data-id="{{ $hora->id }}" data-type="item" data-toggle="modal"  data-target="#delSituacionModal">
                            <i class="fa fa-times"></i>
                          </button>
                          @endif
                        </td>
                        @endif
                      </tr>
                    @endforeach
                    <tr>
                      <td colspan="5"></td>
                      <td class="text-right"><strong>SUB TOTAL</strong></td>
                      <td class="text-right">{{ $proceso->situacion->sumValue('total', false, 2, 'horas') }}</td>
                      @if(Auth::user()->isAdmin())
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td colspan="{{ Auth::user()->isAdmin() ? '8' : '7' }}">OTROS</td>
                    </tr>
                    <tr>
                      <th>DETALLE</th>
                      <th>PRECIO COSTO</th>
                      <th>UTILIDAD</th>
                      <th>DESCUENTO</th>
                      <th>CANT</th>
                      <th>PRECIO</th>
                      <th>TOTAL</th>
                      @if(Auth::user()->isAdmin())
                      <th class="text-center">ACCIÓN</th>
                      @endif
                    </tr>
                    @foreach($situacionOtros as $otro)
                      <tr>
                        <td><a tabindex="0" class="btn btn-simple btn-link p-0" role="button" data-toggle="popover" data-trigger="focus" data-placement="top" title="Descripción" data-content="{{ $otro->descripcion ?? 'N/A' }}">{{ $otro->titulo() }}</a></td>
                        <td class="text-right">{{ $otro->costo() }}</td>
                        <td class="text-right">{{ $otro->utilidad() }}</td>
                        <td class="text-right">{{ $otro->descuentoText() }}</td>
                        <td class="text-center">{{ $otro->cantidad() }}</td>
                        <td class="text-right">{{ $otro->valorVenta() }}</td>
                        <td class="text-right">{{ $otro->total() }}</td>
                        @if(Auth::user()->isAdmin())
                        <td class="text-center">
                          @if(!$proceso->status && !$otro->status)
                          <button class="btn btn-danger btn-sm btn-fill btn-delete" data-id="{{ $otro->id }}" data-type="item" data-toggle="modal"  data-target="#delSituacionModal">
                            <i class="fa fa-times"></i>
                          </button>
                          @endif
                        </td>
                        @endif
                      </tr>
                    @endforeach
                    <tr>
                      <td colspan="5"></td>
                      <td class="text-right"><strong>SUB TOTAL</strong></td>
                      <td class="text-right">{{ $proceso->situacion->sumValue('total', false, 2, 'otros') }}</td>
                      @if(Auth::user()->isAdmin())
                      <td></td>
                      @endif
                    </tr>
                  </tbody>
                </table>
              </div>
            </div><!-- .tab-pane -->
            <div id="tab3" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab3-tab" aria-expanded="false">
              @if( !$proceso->status && ($proceso->etapa == 4 || $proceso->etapa == 5) && Auth::user()->isAdmin())
              <a class="btn btn-primary btn-fill btn-xs mb-2" href="{{ route('admin.cotizacion.create', ['situacion' => $proceso->situacion->id]) }}">
                <i class="fa fa-plus"></i> Generar cotización
              </a>
              @endif

              <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Código</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">Items</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Pagado</th>
                    <th class="text-center">Utilidad</th>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($proceso->cotizaciones as $cotizacion)
                    <tr>
                      <td scope="row">{{ $loop->iteration }}</td>
                      <td>
                        <a href="{{ route('admin.cotizacion.show', ['cotizacion' => $cotizacion->id]) }}">
                          {{ $cotizacion->codigo() }}
                        </a>
                      </td>
                      <td>{{ $cotizacion->descripcionShort() }}</td>
                      <td class="text-center">{{ $cotizacion->items->count() }}</td>
                      <td class="text-right">{{ $cotizacion->total(false) }}</td>
                      <td class="text-right">{{ $cotizacion->pagado(false) }}</td>
                      <td class="text-right">{{ $cotizacion->utilidad(false) }}</td>
                      <td class="text-center">{{ $cotizacion->created_at->format('d-m-Y H:i:s') }}</td>
                      <td class="text-center">{!! $cotizacion->status() !!}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div><!-- .tab-pane -->
            <div id="tab5" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab5-tab" aria-expanded="false">
              <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Cotización</th>
                    <th scope="col" class="text-center">Pago</th>
                    <th scope="col" class="text-center">Fecha</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($pagos as $pago)
                    <tr>
                      <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                      <td class="text-center">
                        <a href="{{ route('admin.cotizacion.show', ['cotizacion' => $pago->cotizacion_id]) }}">
                          {{ $pago->cotizacion->codigo() }}
                        </a>
                      </td>
                      <td class="text-right">{{ $pago->pago() }}</td>
                      <td class="text-center">{{ $pago->created_at->format('d-m-Y H:i:s')}}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div><!-- .tab-pane -->
            @endif
            @if($proceso->inspeccion)
            <div id="tab6" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab6-tab">
              @if( !$proceso->status && $proceso->inspeccion && Auth::user()->isAdmin())
                <a class="btn btn-success btn-fill btn-xs mb-2" href="{{ route('admin.inspeccion.edit', ['inspeccion' => $proceso->inspeccion->id]) }}">
                  <i class="fa fa-pencil"></i> Modificar inspección
                </a>
              @endif
              <a class="btn btn-danger btn-fill btn-xs mb-2" href="{{ route('admin.inspeccion.pdf', ['inspeccion' => $proceso->inspeccion->id]) }}">
                <i class="fa fa-file-pdf-o"></i> Descargar PDF
              </a>
              <div class="row">
                @foreach($proceso->inspeccion->fotos as $foto)
                  <div class="col-sm-4 col-md-2 mb-2">
                    <div class="media-thumbs p-1 rounded">
                      @if(!$proceso->status && Auth::user()->isAdmin())
                      <div class="media-thumbs-options mb-1">
                        <button class="btn btn-danger btn-xs btn-fill btn-delete" data-id="{{ $foto->id }}" data-type="foto-inspeccion" data-toggle="modal"  data-target="#delElementModal">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                      @endif
                      <div class="media-thumbs-content">
                        <a href="#imageModal" data-toggle="modal" data-url="{{ asset('storage/'.$foto->foto) }}">
                          <img src="{{ asset('storage/'.$foto->foto) }}" class="img-fluid">
                        </a>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
              <div class="mt-2 table-responsive">
                <p class="text-muted">
                  <span class="text-dark"><strong>Combustible:</strong></span> {{ $proceso->inspeccion->combustible() }}
                </p>
                <p class="text-muted">
                  <span class="text-dark"><strong>observación:</strong></span> {{ $proceso->inspeccion->observacion }}
                </p>
                <table class="table table-sm" style="width: 100%">
                  <tbody>
                    <tr>
                      <td>Radio</td>
                      <td>{!! $proceso->inspeccion->badge('radio') !!}</td>
                      <td>Luces altas</td>
                      <td>{!! $proceso->inspeccion->badge('luces_altas') !!}</td>
                    </tr>
                    <tr>
                      <td>Antena</td>
                      <td>{!! $proceso->inspeccion->badge('antena') !!}</td>
                      <td>Luces bajas</td>
                      <td>{!! $proceso->inspeccion->badge('luces_bajas') !!}</td>
                    </tr>
                    <tr>
                      <td>Pisos delanteros</td>
                      <td>{!! $proceso->inspeccion->badge('pisos_delanteros') !!}</td>
                      <td>Intermitentes</td>
                      <td>{!! $proceso->inspeccion->badge('intermitentes') !!}</td>
                    </tr>
                    <tr>
                      <td>Pisos traseros</td>
                      <td>{!! $proceso->inspeccion->badge('pisos_traseros') !!}</td>
                      <td>Encendedor</td>
                      <td>{!! $proceso->inspeccion->badge('encendedor') !!}</td>
                    </tr>
                    <tr>
                      <td>Cinturones</td>
                      <td>{!! $proceso->inspeccion->badge('cinturones') !!}</td>
                      <td>Limpia parabrisas delantero</td>
                      <td>{!! $proceso->inspeccion->badge('limpia_parabrisas_delantero') !!}</td>
                    </tr>
                    <tr>
                      <td>Tapiz</td>
                      <td>{!! $proceso->inspeccion->badge('tapiz') !!}</td>
                      <td>Limpia parabrisas trasero</td>
                      <td>{!! $proceso->inspeccion->badge('limpia_parabrisas_trasero') !!}</td>
                    </tr>
                    <tr>
                      <td>Triángulos</td>
                      <td>{!! $proceso->inspeccion->badge('triangulos') !!}</td>
                      <td>Tapa de combustible</td>
                      <td>{!! $proceso->inspeccion->badge('tapa_combustible') !!}</td>
                    </tr>
                    <tr>
                      <td>Extintor</td>
                      <td>{!! $proceso->inspeccion->badge('extintor') !!}</td>
                      <td>Seguro de ruedas</td>
                      <td>{!! $proceso->inspeccion->badge('seguro_ruedas') !!}</td>
                    </tr>
                    <tr>
                      <td>Botiquín</td>
                      <td>{!! $proceso->inspeccion->badge('botiquin') !!}</td>
                      <td>Perilla interior</td>
                      <td>{!! $proceso->inspeccion->badge('perilla_interior') !!}</td>
                    </tr>
                    <tr>
                      <td>Gata</td>
                      <td>{!! $proceso->inspeccion->badge('gata') !!}</td>
                      <td>Perilla exterior</td>
                      <td>{!! $proceso->inspeccion->badge('perilla_exterior') !!}</td>
                    </tr>
                    <tr>
                      <td>Herramientas</td>
                      <td>{!! $proceso->inspeccion->badge('herramientas') !!}</td>
                      <td>Manuales</td>
                      <td>{!! $proceso->inspeccion->badge('manuales') !!}</td>
                    </tr>
                    <tr>
                      <td>Neumático repuesto</td>
                      <td>{!! $proceso->inspeccion->badge('neumatico_repuesto') !!}</td>
                      <td>Documentación</td>
                      <td>{!! $proceso->inspeccion->badge('documentación') !!}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div><!-- .tab-pane -->
            @endif
          </div><!-- .tab-content -->
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
  
  @if(Auth::user()->isAdmin())
  <div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="delModalLabel">Eliminar Servicio</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <form class="col-md-10" action="{{ route('admin.proceso.destroy', ['proceso' => $proceso->id]) }}" method="POST">
              @csrf
              @method('DELETE')

              <p class="text-center">¿Esta seguro de eliminar este Servicio?</p><br>

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
    
    @if(!$proceso->status)
    <div id="statusModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="statusModalLabel">Marcar como completado</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row justify-content-md-center">
              <form class="col-md-10" action="{{ route('admin.proceso.status', ['proceso' => $proceso->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="text-center">¿Esta seguro que desea marcar este Servicio como <strong>Completo</strong>?</h5>
                <p class="text-center text-muted">No se podrán hacer modificaciones a la información de este Servicio.</p>
                <p class="text-center text-muted">Esta acción no se puede deshacer.</p>

                <center>
                  <button class="btn btn-fill btn-warning" type="submit">Aceptar</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </center>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
  @endif
  
  @if(!$proceso->status & Auth::user()->isAdmin())
    <div id="delElementModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delElementModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="delElementModalLabel"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row justify-content-md-center">
              <form id="delElement" class="col-md-8" action="#" method="POST">
                @csrf
                @method('DELETE')

                <p class="text-center">¿Esta seguro de eliminar <span id="modal-message"></span>?</p><br>

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

    <div id="delSituacionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delSituacionModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="delSituacionModalLabel"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row justify-content-md-center">
              <form id="delSituacion" class="col-md-8" action="#" method="POST">
                @csrf
                @method('DELETE')

                <p class="text-center">¿Esta seguro de eliminar este Item?</p><br>

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

  <div id="imageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel">
    <div class="modal-dialog modal-lg dialog-top" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="delElementModalLabel">Imagen</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <img id="image" src="#" class="img-fluid mx-auto d-block" alt="Responsive image">
          <br>
          <center>
            <button type="button" class="btn btn-flat btn-secondary" data-dismiss="modal">Cerrar</button>
          </center>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      @if(Auth::user()->isAdmin())
      $('#delElementModal').on('show.bs.modal', function (e) {
        let id = $(e.relatedTarget).data('id'),
            type = $(e.relatedTarget).data('type');
        let url = (type == 'preevaluacion' ? '{{ route("admin.preevaluacion.index") }}/' : ( type == 'foto' ? '{{ route("admin.preevaluacion.foto.index") }}/' : '{{ route("admin.inspeccion.foto.index") }}/')) + id

        $('#delElementModalLabel').text(type == 'preevaluacion' ? 'Eliminar Pre-evaluación' : 'Eliminar Foto')
        $('#modal-message').text(type == 'preevaluacion' ? 'este dato de Pre-evaluación' : 'esta Foto')
        $('#delElement').attr('action', url)
      })

      $('#delSituacionModal').on('show.bs.modal', function (e) {
        let id = $(e.relatedTarget).data('id')
        $('#delSituacion').attr('action', '{{ route("admin.situacion.item.index") }}/'+id)
      })
      @endif

      $('#imageModal').on('show.bs.modal', function (e) {
        let src = $(e.relatedTarget).data('url')

        $('#image').attr('src', src)
      })

      $('.link-scroll').click(scrollToTabs)

      // Inicializar popovers
      $('[data-toggle="popover"]').popover()
    })

    function scrollToTabs(e){
      e.preventDefault();
      let tab = $(this).data('tab');

      $(`${tab}-tab`).click()
      $('.main-panel').animate({
          scrollTop: $('.proceso-tabs').offset().top
      }, 500);      
    }
  </script>
@endsection
