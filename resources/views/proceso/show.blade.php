@extends('layouts.app')

@section('title', 'Servicio - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('proceso.index') }}"> Servicios </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('proceso.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
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
          <strong>Vehículo</strong>
          <p class="text-muted">
            {{ $proceso->vehiculo->vehiculo() }}
          </p>
          <hr>

          @if($proceso->situacion)
          <strong>Total Neto</strong>
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
                      {{ $proceso->agendamiento ? $proceso->agendamiento->fecha() : '' }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-md-4">
          <a class="link-scroll" href="#" titlte="Ver pre-evaluación" data-tab="#tab1">
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
                        {!! $proceso->preevaluacionesStatus() !!}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>

        <div class="col-sm-6 col-md-4">
          <a class="link-scroll" href="#" titlte="Ver hoja de situación" data-tab="#tab2">
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
                        {!! $proceso->situacionStatus() !!}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>

        <div class="col-sm-6 col-md-4">
          @if($proceso->situacion && !$proceso->hasCotizaciones() && !$proceso->status && ($proceso->etapa == 4 || $proceso->etapa == 5))
          <a href="{{ route('cotizacion.create', ['situcion' => $proceso->situacion->id]) }}" title="Generar cotización">
          @else
          <a class="link-scroll" href="#" title="Ver cotizaciones" data-tab="#tab3">
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
          <a class="link-scroll" href="#" titlte="Ver inspección" data-tab="#tab5">
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
                        {!! $proceso->inspeccionStatus() !!}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
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
              <a class="nav-link" id="tab4-tab" href="#tab4" role="tab" data-toggle="tab" aria-controls="tab4" aria-selected="false"><i class="fa fa-credit-card"></i> Pagos</a>
            </li>
            @endif
            @if($proceso->inspeccion)
            <li class="nav-item">
              <a class="nav-link" id="tab5-tab" href="#tab5" role="tab" data-toggle="tab" aria-controls="tab5" aria-selected="false"><i class="fa fa-list"></i> Inspección</a>
            </li>
            @endif
          </ul>
          <div class="tab-content">
            <div id="tab1" class="tab-pane fade show active pt-2" role="tabpanel" aria-labelledby="tab1-tab">
              <div class="row">
                @foreach($preevaluacionesFotos as $foto)
                  <div class="col-sm-4 col-md-2 mb-2">
                    <div class="media-thumbs p-1 rounded">
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
                      <th scope="col" class="text-center">Referencia</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($preevaluaciones as $preevaluacion)
                      <tr>
                        <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $preevaluacion->descripcion }}</td>
                        <td>{{ $preevaluacion->observacion ?? 'N/A' }}</td>
                        <td class="text-right">{{ $preevaluacion->referencia() ?? 'N/A'  }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div><!-- .tab-pane -->
            
            @if($proceso->situacion)
            <div id="tab2" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab2-tab">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-sm font-small m-0" style="width: 100%">
                  <tbody>
                    <tr>
                      <td colspan="4">REPUESTOS</td>
                    </tr>
                    <tr>
                      <th>DETALLE</th>
                      <th>CANT</th>
                      <th>PRECIO</th>
                      <th>TOTAL</th>
                    </tr>
                    @foreach($situacionRepuestos as $repuesto)
                      <tr>
                        <td>{{ $repuesto->titulo() }}</td>
                        <td class="text-center">{{ $repuesto->cantidad() }}</td>
                        <td class="text-right">{{ $repuesto->valorVenta() }}</td>
                        <td class="text-right">{{ $repuesto->total() }}</td>
                      </tr>
                    @endforeach
                    <tr>
                      <td colspan="2"></td>
                      <td class="text-right"><strong>SUB TOTAL</strong></td>
                      <td class="text-right">{{ $proceso->situacion->sumValue('total', false, 2, 'repuesto') }}</td>
                    </tr>
                    <tr>
                      <td colspan="4">LIBRICANTES E INSUMOS</td>
                    </tr>
                    <tr>
                      <th>DETALLE</th>
                      <th>CANT</th>
                      <th>PRECIO</th>
                      <th>TOTAL</th>
                    </tr>
                    @foreach($situacionInsumos as $insumo)
                      <tr>
                        <td>{{ $insumo->titulo() }}</td>
                        <td class="text-center">{{ $insumo->cantidad() }}</td>
                        <td class="text-right">{{ $insumo->valorVenta() }}</td>
                        <td class="text-right">{{ $insumo->total() }}</td>
                      </tr>
                    @endforeach
                    <tr>
                      <td colspan="2"></td>
                      <td class="text-right"><strong>SUB TOTAL</strong></td>
                      <td class="text-right">{{ $proceso->situacion->sumValue('total', false, 2, 'insumo') }}</td>
                    </tr>
                    <tr>
                      <td colspan="4">MANO DE OBRA</td>
                    </tr>
                    <tr>
                      <th>DETALLE</th>
                      <th>CANT</th>
                      <th>PRECIO</th>
                      <th>TOTAL</th>
                    </tr>
                    @foreach($situacionHoras as $hora)
                      <tr>
                        <td>{{ $hora->descripcion ?? 'N/A' }}</td>
                        <td class="text-center">{{ $hora->cantidad() }}</td>
                        <td class="text-right">{{ $hora->valorVenta() }}</td>
                        <td class="text-right">{{ $hora->total() }}</td>
                      </tr>
                    @endforeach
                    <tr>
                      <td colspan="2"></td>
                      <td class="text-right"><strong>SUB TOTAL</strong></td>
                      <td class="text-right">{{ $proceso->situacion->sumValue('total', false, 2, 'horas') }}</td>
                    </tr>
                    <tr>
                      <td colspan="4">OTROS</td>
                    </tr>
                    <tr>
                      <th>DETALLE</th>
                      <th>CANT</th>
                      <th>PRECIO</th>
                      <th>TOTAL</th>
                    </tr>
                    @foreach($situacionOtros as $otro)
                      <tr>
                        <td>{{ $otro->descripcion ?? 'N/A' }}</td>
                        <td class="text-center">{{ $otro->cantidad() }}</td>
                        <td class="text-right">{{ $otro->valorVenta() }}</td>
                        <td class="text-right">{{ $otro->total() }}</td>
                      </tr>
                    @endforeach
                    <tr>
                      <td colspan="2"></td>
                      <td class="text-right"><strong>SUB TOTAL</strong></td>
                      <td class="text-right">{{ $proceso->situacion->sumValue('total', false, 2, 'otros') }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div><!-- .tab-pane -->

            <div id="tab3" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab3-tab" aria-expanded="false">
              @if($proceso->situacion && !$proceso->status && ($proceso->etapa == 4 || $proceso->etapa == 5))
              <a class="btn btn-primary btn-fill btn-xs mb-2" href="{{ route('cotizacion.create', ['situacion' => $proceso->situacion->id]) }}">
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
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($proceso->cotizaciones as $cotizacion)
                    <tr>
                      <td scope="row">{{ $loop->iteration }}</td>
                      <td>
                        <a href="{{ route('cotizacion.show', ['cotizacion' => $cotizacion->id]) }}">
                          {{ $cotizacion->codigo() }}
                        </a>
                      </td>
                      <td>{{ $cotizacion->descripcionShort() }}</td>
                      <td class="text-center">{{ $cotizacion->items->count() }}</td>
                      <td class="text-right">{{ $cotizacion->total(false) }}</td>
                      <td class="text-right">{{ $cotizacion->pagado(false) }}</td>
                      <td class="text-center">{{ $cotizacion->created_at->format('d-m-Y H:i:s') }}</td>
                      <td class="text-center">{!! $cotizacion->status() !!}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div><!-- .tab-pane -->

            <div id="tab4" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab4-tab" aria-expanded="false">
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
                        <a href="{{ route('cotizacion.show', ['cotizacion' => $pago->cotizacion_id]) }}">
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
            <div id="tab5" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab5-tab">              
              <button class="btn btn-success btn-fill btn-xs mb-2" data-toggle="modal" data-target="#statusModal"><i class="fa fa-pencil" aria-hidden="true"></i> Modificar status</button>
              <a class="btn btn-danger btn-fill btn-xs mb-2" href="{{ route('inspeccion.pdf', ['inspeccion' => $proceso->inspeccion->id]) }}">
                <i class="fa fa-file-pdf-o"></i> Descargar PDF
              </a>
              <div class="row">
                @foreach($proceso->inspeccion->fotos as $foto)
                  <div class="col-sm-4 col-md-2 mb-2">
                    <div class="media-thumbs p-1 rounded">
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
                <p class="text-muted m-0">
                  <strong class="text-dark">Combustible:</strong> {{ $proceso->inspeccion->combustible }} {{ $proceso->inspeccion->combustibleIsOtro() ? '('.$proceso->inspeccion->otro.')' : '' }}
                </p>
                <p class="text-muted m-0">
                  <strong class="text-dark">Observación:</strong> {{ $proceso->inspeccion->observacion }}
                </p>
                <p class="m-0">
                  <strong class="text-dark">Estatus:</strong> {!! $proceso->inspeccion->status() !!}
                </p>
                <p class="text-muted m-0">
                  <strong class="text-dark">Comentarios del cliente:</strong> {{ $proceso->inspeccion->comentarios ?? 'N/A' }}
                </p>
                <table class="table table-sm mt-2" style="width: 100%">
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

  <div id="imageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel">
    <div class="modal-dialog modal-lg dialog-top" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="statusModalLabel">Imagen</h4>
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
  
  <div id="statusModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="statusModalLabel">Cambiar Estatus</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <form id="status" class="col-md-12" action="{{ route('inspeccion.status', ['inspeccion' => $proceso->inspeccion->id]) }}" method="POST">
              @csrf
              @method('PATCH')

              @if($proceso->inspeccion->isPending())
                <div class="form-group">
                  <label class="w-100">Seleccionar estatus:</label>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input id="aprobar" class="custom-control-input" type="radio" name="estatus" value="aprobado" required>
                    <label class="custom-control-label" for="aprobar">Aprobar</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input id="recahzar" class="custom-control-input" type="radio" name="estatus" value="rechazado" required>
                    <label class="custom-control-label" for="recahzar">Recahzar</label>
                  </div>
                  <p class="text-center">
                    <small class="text-muted">
                      Al aprobar la inspección usted esta de acuerdo con todos los puntos expresados en ella. Puede dejar comentarios adicionales o comunicarse con nosotros ante cualquier duda. De rechazar la inspección, indique en la opción de comentarios la razón del rechazo.
                    </small>
                  </p>
                </div>
              @endif

              <div class="form-group">
                <label for="comentarios">Comentarios: </label>
                <textarea id="comentarios" class="form-control" type="text" maxlength="500" name="comentarios">{{ old('comentarios', $proceso->inspeccion->comentarios) }}</textarea>
              </div>

              @if(count($errors) > 0)
                <div class="alert alert-danger alert-important">
                  <ul class="m-0">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <center>
                <button class="btn btn-fill btn-primary" type="submit">Enviar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
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
